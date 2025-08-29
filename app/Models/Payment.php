<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'certificat_id',
        'item_name',
        'amount',
        'currency',
        'customer_email',
        'custom_field',
        'payment_token',
        'status',
        'paytech_response',
        'error_message',
        'ip_address',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'custom_field' => 'array',
        'paytech_response' => 'array',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_INITIATED = 'initiated';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_INVALID = 'invalid';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function certificat()
    {
        return $this->belongsTo(Certificat::class);
    }

     public function markAsInitiated($paymentToken, $response = null)
    {
        $this->update([
            'status' => self::STATUS_INITIATED,
            'payment_token' => $paymentToken,
            'paytech_response' => $response,
        ]);
    }

    public function markAsSuccess($response = null)
    {
        $this->update([
            'status' => self::STATUS_SUCCESS,
            'paytech_response' => $response,
        ]);
    }

    public function markAsFailed($errorMessage, $response = null)
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'error_message' => $errorMessage,
            'paytech_response' => $response,
        ]);
    }

    public function markAsCancelled($response = null)
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
            'paytech_response' => $response,
        ]);
    }

    public function markAsInvalid($errorMessage, $response = null)
    {
        $this->update([
            'status' => self::STATUS_INVALID,
            'error_message' => $errorMessage,
            'paytech_response' => $response,
        ]);
    }
}
