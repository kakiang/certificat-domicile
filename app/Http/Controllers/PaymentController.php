<?php

namespace App\Http\Controllers;

use App\Models\Certificat;
use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function initiatePayment(Request $request, Certificat $certificat)
    {
        $habitant = $certificat->habitant;
        Log::info("Initiating payment for Certificat ID: {$certificat->id}, Habitant ID: {$habitant->id}");
        $amount = Parametre::first()->prix_certificat ?? 0;

        // $url = config('paytech.base_url') . config('paytech.routes.payment');
        // $envi = config('paytech.env', 'test');
        // Log::info("Paytech url: {$url}");
        // Log::info("Certificat {$certificat}");
        // return back()->with('error', "{$url} - {$envi}");

        // Basic validation
        if ($amount <= 0) {
            Log::error("Certificat price not configured in parameters.");
            return back()->with('error', "Le prix du certificat n'est pas configuré. Veuillez contacter l'administrateur.");
        }
        if (!$habitant || !$habitant->telephone) {
            Log::error("Habitant or telephone number missing for certificat ID: {$certificat->id}");
            return back()->with('error', 'Un numéro de téléphone valide est requis pour procéder au paiement.');
        }

        $validated =  [
            'item_name' => 'Certificat de domicile',
            'amount' => $amount,
            'email' => $habitant->user->email,
            'first_name' => $habitant->prenom,
            'last_name' => $habitant->nom,
            'phone' => $habitant->telephone,
        ];

        // Generate unique order ID
        $orderId = 'ORD_' . Str::upper(Str::random(10));
        Log::info("Initiating payment", ['order_id' => $orderId, 'certificat_id' => $certificat->id]);

        try {
            // Create payment record in database
            $payment = Payment::create([
                'order_id' => $orderId,
                'user_id' => Auth::id(),
                'certificat_id' => $certificat->id,
                'item_name' => $validated['item_name'],
                'amount' => $amount,
                'currency' => 'XOF',
                'customer_email' => $validated['email'],
                'ip_address' => $request->ip(),
                'status' => Payment::STATUS_PENDING,
            ]);

            // Prepare payload for PayTech
            $payload = [
                'item_name' => $validated['item_name'],
                'item_price' => $amount,
                'currency' => 'XOF',
                'command_name' => "Purchase: " . $validated['item_name'],
                'ref_command' => $orderId,
                'env' => config('paytech.env', 'test'),
                'ipn_url' => route('paytech.ipn'),
                'success_url' => route('payment.success', ['order_id' => $orderId]),
                'cancel_url' => route('payment.cancel', ['order_id' => $orderId]),
                'custom_field' => json_encode([
                    'order_id' => $orderId,
                    'email' => $validated['email'],
                    'first_name' => $validated['first_name'] ?? '',
                    'last_name' => $validated['last_name'] ?? '',
                    'phone' => $validated['phone'] ?? '',
                ]),
            ];

            // Add optional customer information
            // if (!empty($validated['first_name'])) {
            //     $payload['first_name'] = $validated['first_name'];
            // }
            // if (!empty($validated['last_name'])) {
            //     $payload['last_name'] = $validated['last_name'];
            // }
            // if (!empty($validated['email'])) {
            //     $payload['email'] = $validated['email'];
            // }
            // if (!empty($validated['phone'])) {
            //     $payload['phone'] = $validated['phone'];
            // }

            // Make API request to PayTech
            $response = Http::withHeaders([
                'API_KEY' => config('paytech.api_key'),
                'API_SECRET' => config('paytech.api_secret'),
            ])
                // ->post('https://paytech.sn/api/payment/request-payment', $payload);
                ->post(config('paytech.base_url') . config('paytech.routes.payment'), $payload);

            $responseData = $response->json();

            Log::info("PayTech Response", [
                'order_id' => $orderId,
                'status_code' => $response->status(),
                'response' => $responseData
            ]);

            // Handle PayTech response
            if ($response->successful() && isset($responseData['success']) && $responseData['success'] == 1) {
                // Payment initiation successful
                $payment->markAsInitiated(
                    $responseData['token'] ?? null,
                    $responseData
                );

                Log::info("Payment initiated successfully", [
                    'order_id' => $orderId,
                    'payment_token' => $responseData['token'] ?? null
                ]);

                // Redirect to PayTech payment page
                return redirect()->away($responseData['redirect_url']);
            } else {
                // Payment initiation failed
                $errorMessage = $responseData['message'] ?? 'Unknown error from PayTech';

                $payment->markAsFailed(
                    $errorMessage,
                    $responseData
                );

                Log::error('PayTech Payment Initiation Failed', [
                    'order_id' => $orderId,
                    'response' => $responseData,
                    'status_code' => $response->status()
                ]);

                return back()->with('error', 'Payment initiation failed: ' . $errorMessage);
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Network connection error
            $errorMessage = 'Network connection error: Unable to reach PayTech service';

            if (isset($payment)) {
                $payment->markAsFailed($errorMessage);
            }

            Log::error('PayTech Connection Error: ' . $e->getMessage());
            return back()->with('error', 'Service temporarily unavailable. Please try again.');
        } catch (\Exception $e) {
            // General exception
            $errorMessage = 'System error: ' . $e->getMessage();

            if (isset($payment)) {
                $payment->markAsFailed($errorMessage);
            }

            Log::error('PayTech Payment Exception: ' . $e->getMessage());
            return back()->with('error', 'A system error occurred. Please try again.');
        }
    }

    /**
     * Handle PayTech IPN (Instant Payment Notification)
     */
    public function handleIPN(Request $request)
    {
        Log::info('PayTech IPN Received: ', $request->all());

        try {
            $paymentToken = $request->input('payment_token');
            $customField = json_decode($request->input('custom_field', '{}'), true);
            $orderId = $customField['order_id'] ?? null;

            if (!$orderId) {
                Log::warning('PayTech IPN missing order_id in custom_field');
                return response('OK', 200);
            }

            // Find the payment record
            $payment = Payment::where('order_id', $orderId)->first();

            if (!$payment) {
                Log::warning("PayTech IPN for unknown order: $orderId");
                return response('OK', 200);
            }

            // Verify payment with PayTech
            $verificationResponse = Http::withHeaders([
                'API_KEY' => config('paytech.api_key'),
                'API_SECRET' => config('paytech.api_secret'),
            ])
                ->timeout(15)
                ->post(config('paytech.base_url') . config('paytech.routes.check'), [
                    'token' => $paymentToken
                ]);

            $verificationData = $verificationResponse->json();

            if (
                $verificationResponse->successful() &&
                isset($verificationData['success']) &&
                $verificationData['success'] == 1
            ) {

                // Payment verified successfully
                if ($verificationData['status'] == '1') {
                    // Payment successful
                    $payment->markAsSuccess($verificationData);
                    Log::info("Payment confirmed successful for order: $orderId");

                    // Mark the associated certificat as paid
                    $certificat = Certificat::find($payment->certificat_id);
                    if ($certificat) {
                        $certificat->markAsPaid();
                        Log::info("Certificat ID {$certificat->numero_certificat} marked as paid.");
                    } else {
                        Log::warning("No certificat found for payment ID {$payment->id}");
                    }
                } else {
                    // Payment failed or cancelled
                    $payment->markAsFailed(
                        'Payment status: ' . ($verificationData['status'] ?? 'unknown'),
                        $verificationData
                    );
                    Log::warning("Payment failed for order: $orderId", $verificationData);
                }
            } else {
                // Verification failed - mark as invalid
                $errorMessage = $verificationData['message'] ?? 'Verification failed';
                $payment->markAsInvalid($errorMessage, $verificationData);
                Log::error("Payment verification failed for order: $orderId", $verificationData);
            }
        } catch (\Exception $e) {
            Log::error('PayTech IPN Processing Error: ' . $e->getMessage());
        }

        return response('OK', 200);
    }

    public function paymentSuccess($orderId)
    {
        $payment = Payment::where('order_id', $orderId)->first();
        Log::info("Payment success callback for order_id: {$orderId}");
        if (!$payment) {
            Log::error("Payment with order_id {$orderId} not found in paymentCancel method");
            return redirect()->route('certificats.index')
                ->with('error', "Paiement non trouvé. Veuillez contacter l'administrateur.");
        }

        // If payment is already marked as success via IPN, show success page
        if ($payment->status === Payment::STATUS_SUCCESS) {
            Log::info("Displaying success page for order_id: {$orderId}");
            // return redirect()->route('payment.success', ['payment' => $payment])
            //     ->with('success', 'Votre paiement a été effectué avec succès. Merci!');
            return view('payment.success', ['payment' => $payment]);
        }

        // If IPN hasn't arrived yet, show processing message
        Log::info("Payment for order_id: {$orderId} is still processing.");
        return view('payment.processing', ['payment' => $payment]);
    }

    public function paymentCancel($orderId)
    {
        $payment = Payment::where('order_id', $orderId)->first();
        if (!$payment) {
            Log::error("Payment with order_id {$orderId} not found in paymentCancel method");
            return redirect()->route('certificats.index')
                ->with('error', "Paiement non trouvé. Veuillez contacter l'administrateur.");
        }

        try {
            $payment->markAsCancelled();

            return redirect()->route('certificats.show', ['certificat' => $payment->certificat])
                ->with('success', "Votre paiement a été annulé.");
        } catch (\Exception $e) {
            Log::error("Error cancelling payment {$orderId}: " . $e->getMessage());

            return redirect()->route('certificats.show', ['certificat' => $payment->certificat])
                ->with('error', "Une erreur est survenue lors de l\'annulation du paiement.");
        }
    }
}
