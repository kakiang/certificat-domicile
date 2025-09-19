<?php

namespace App\Http\Controllers;

use App\Models\Certificat;
use App\Models\CertificatDelivre;
use App\Models\Habitant;
use App\Models\Parametre;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use function Spatie\LaravelPdf\Support\pdf;

class CertificatController extends Controller
{
    /**
     * Constructeur pour autoriser automatiquement les actions sur le contrôleur.
     * Cela simplifie la gestion des permissions pour les méthodes CRUD standards.
     */
    public function __construct()
    {
        // Applique les policies pour les méthodes CRUD du controller.
        // Chaque méthode du controller sera automatiquement associée à la méthode correspondante dans CertificatPolicy.
        // Pour 'store', la policy 'create' est appelée avec la classe du modèle.
        // Pour 'index', la policy 'viewAny' est appelée.
        // Pour 'show', 'edit', 'update', 'destroy',
        // les policies 'view', 'update', 'delete' sont appelées avec l'instance du modèle.
        $this->authorizeResource(Certificat::class, 'certificat');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $certificats = Certificat::forCurrentUser()->paginate(15);
        return view('certificats.index-card', compact('certificats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('habitants.create')
                ->with('message', 'Vous devez d\'abord vous connecter ou créer votre profil habitant.');
        }

        $habitants = Habitant::forCurrentUser()->orderBy('nom')->get();

        if ($habitants->isEmpty()) {
            return redirect()->route('habitants.create')
                ->with('message', 'Vous devez d\'abord créer votre profil habitant.');
        }

        $singleHabitant = $habitants->count() === 1 ? $habitants->first() : null;

        return view('certificats.create', compact('habitants', 'singleHabitant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Début de la création du certificat.');

        $fileSizeMax = 1024 * 5;
        $validatedData = $request->validate([
            'habitant_id' => 'required|exists:habitants,id',
            'piece_identite' => 'required|string',
            'piece_identite_file_path' => 'required|file|mimes:jpeg,png,pdf|max:' . $fileSizeMax,
            'justificatif_domicile' => 'required|string',
            'justificatif_domicile_file_path' => 'required|file|mimes:jpeg,png,pdf|max:' . $fileSizeMax,
        ]);

        Log::info('Données validées avec succès.', $validatedData);

        if (!auth()->user()->is_admin) {
            $habitantIdOfCurrentUser = auth()->user()->habitant->id ?? null;
            if (!$habitantIdOfCurrentUser || (int)$validatedData['habitant_id'] !== $habitantIdOfCurrentUser) {
                return redirect()->route('certificats.create')
                    ->with('error', 'Vous n\'êtes pas autorisé à créer une demande de certificat pour un autre habitant.');
            }
        }

        try {
            DB::beginTransaction();

            $validatedData = $this->handleFileUploads($request, $validatedData);

            $certificat = Certificat::create($validatedData);

            $certificat->numero_certificat = $this->generateCertificatNumber($certificat);
            $certificat->save();

            DB::commit();

            Log::info('Certificat créé avec succès.', ['certificat_id' => $certificat->id]);

            return redirect()->route('certificats.index')
                ->with('success', 'Demande de certificat enregistrée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création du certificat.', ['error' => $e->getMessage()]);

            return redirect()->route('certificats.index')
                ->with('error', "Une erreur est survenue lors de la création de la demande : " . $e->getMessage());
        }
    }

    private function handleFileUploads(Request $request, array $validatedData)
    {
        // Traitement de la pièce d'identité
        if ($request->hasFile('piece_identite_file_path')) {
            $file = $request->file('piece_identite_file_path');
            $validatedData['piece_identite_file_path'] = $file->store('piece_identites');
            $validatedData['piece_identite_slug'] = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        }

        // Traitement du justificatif de domicile
        if ($request->hasFile('justificatif_domicile_file_path')) {
            $file = $request->file('justificatif_domicile_file_path');
            $validatedData['justificatif_domicile_file_path'] = $file->store('justificatif_domiciles');
            $validatedData['justificatif_domicile_slug'] = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        }

        return $validatedData;
    }

    private function generateCertificatNumber(Certificat $certificat)
    {
        $habitant = $certificat->habitant;

        if ($habitant && $habitant->maison && $habitant->maison->quartier) {
            $codeQuartier = Str::upper(Str::substr($habitant->maison->quartier->nom, 0, 3));
            $codeMaison = $habitant->maison->numero;
            $codeHabitant = $habitant->id;
            $annee = now()->format('Y');
            return "{$annee}-{$codeQuartier}-{$codeMaison}-{$codeHabitant}{$certificat->id}";
        }

        Log::warning('Impossible de générer le numéro de certificat car les informations de la maison ou du quartier sont manquantes.');
        return null;
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificat $certificat)
    {
        return view('certificats.show', compact('certificat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificat $certificat)
    {
        $habitants = Habitant::orderBy('nom')->get();
        return view('certificats.edit', compact('certificat', 'habitants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificat $certificat)
    {
        $fileSizeMax = 1024 * 5; // 5MB

        $validatedData = $request->validate([
            'habitant_id' => 'required|exists:habitants,id',
            'piece_identite' => 'required|string',
            'piece_identite_file_path' => 'nullable|file|mimes:jpeg,png,pdf|max:' . $fileSizeMax, // Nullable pour les fichiers existants
            'justificatif_domicile' => 'required|string',
            'justificatif_domicile_file_path' => 'nullable|file|mimes:jpeg,png,pdf|max:' . $fileSizeMax, // Nullable pour les fichiers existants
        ]);

        if (!auth()->user()->is_admin) {
            $habitantIdOfCurrentUser = auth()->user()->habitant->id ?? null;
            if (!$habitantIdOfCurrentUser || (int)$validatedData['habitant_id'] !== $habitantIdOfCurrentUser) {
                return redirect()->route('certificats.index')
                    ->with('error', 'Vous n\'êtes pas autorisé à créer un certificat pour un autre habitant.');
            }
        }

        // Gérer les mises à jour de fichiers
        if ($request->hasFile('piece_identite_file_path')) {
            // Supprimer l'ancien fichier si un nouveau est téléchargé
            if ($certificat->piece_identite_file_path) {
                Storage::delete($certificat->piece_identite_file_path);
            }
            $file = $request->file('piece_identite_file_path');
            $validatedData['piece_identite_file_path'] = $file->store('piece_identites');
            $originalFileName = $file->getClientOriginalName();
            $validatedData['piece_identite_slug'] = Str::slug(pathinfo($originalFileName, PATHINFO_FILENAME));
        } else {
            // Si pas de nouveau fichier, conserver l'ancien chemin
            $validatedData['piece_identite_file_path'] = $certificat->piece_identite_file_path;
            $validatedData['piece_identite_slug'] = $certificat->piece_identite_slug;
        }

        if ($request->hasFile('justificatif_domicile_file_path')) {
            // Supprimer l'ancien fichier si un nouveau est téléchargé
            if ($certificat->justificatif_domicile_file_path) {
                Storage::delete($certificat->justificatif_domicile_file_path);
            }
            $file = $request->file('justificatif_domicile_file_path');
            $validatedData['justificatif_domicile_file_path'] = $file->store('justificatif_domiciles');
            $originalFileName = $file->getClientOriginalName();
            $validatedData['justificatif_domicile_slug'] = Str::slug(pathinfo($originalFileName, PATHINFO_FILENAME));
        } else {
            // Si pas de nouveau fichier, conserver l'ancien chemin
            $validatedData['justificatif_domicile_file_path'] = $certificat->justificatif_domicile_file_path;
            $validatedData['justificatif_domicile_slug'] = $certificat->justificatif_domicile_slug;
        }

        $certificat->update($validatedData);

        return redirect()->route('certificats.index')
            ->with('success', 'Demande certificat mise à jour avec succès');
    }

    public function update_status(Request $request, Certificat $certificat)
    {
        Log::info('function update_status');
        $validatedData = $request->validate([
            'status' => ['required', Rule::in(['En attente', 'En cours de traitement', 'Incomplète', 'Délivré', 'Rejété'])],
            'observation' => ['nullable', 'string'],
        ]);
        Log::info('Données validées avec succès.', $validatedData);


        try {
            DB::beginTransaction();

            if ($validatedData['status'] === 'Délivré') {
                Log::info('Le statut a changé pour Délivré');

                $date_delivrance = Carbon::now();
                $validatedData['date_delivrance'] = $date_delivrance;
                $certificat->update($validatedData);
                Log::info('Certificat mise à jour avec statut Délivré');

                $habitant = $certificat->habitant;
                $maison = $habitant->maison;
                $quartier = $maison->quartier;

                CertificatDelivre::create([
                    'certificat_id' => $certificat->id,
                    'numero_certificat' => $certificat->numero_certificat,
                    'code_secret' => $certificat->code_secret,
                    'habitant_id' => $habitant->id,
                    'habitant_nom' => $habitant->nom,
                    'habitant_prenom' => $habitant->prenom,
                    'habitant_telephone' => $habitant->telephone,
                    'habitant_date_naissance' => $habitant->date_naissance,
                    'habitant_lieu_naissance' => $habitant->lieu_naissance,
                    'habitant_maison_adresse' => $maison->adresse,
                    'habitant_maison_proprietaire' => $maison->full_name,
                    'habitant_maison_quartier_nom' => $quartier->nom,
                    'date_demande' => $certificat->date_demande,
                    'date_delivrance' => $certificat->date_delivrance,
                ]);

                Log::info('Enregistrement dans certificat_delivres créé avec succès.');
            } else {
                $certificat->update($validatedData);
                Log::info('Certificat mis à jour avec statut autre que Délivré');
            }

            DB::commit();

            return redirect()->route('certificats.show', $certificat)
                ->with('success', 'Le statut du certificat a été mis à jour avec succès');
        } catch (\Exception $ex) {

            DB::rollBack();

            Log::error('Erreur lors de la mise à jour du statut ou de la création de certificat_delivre', ['exception' => $ex->getMessage()]);

            return redirect()->route('certificats.show', $certificat)
                ->with('error', 'Une erreur est survenue lors de la mise à jour du statut. Veuillez réessayer.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificat $certificat)
    {
        if ($certificat->piece_identite_file_path) {
            Storage::delete($certificat->piece_identite_file_path);
        }
        if ($certificat->justificatif_domicile_file_path) {
            Storage::delete($certificat->justificatif_domicile_file_path);
        }

        $certificat->delete();
        return redirect()->route('certificats.index')
            ->with('success', 'Demande certificat supprimé avec succès');
    }

    private function get_config_data()
    {
        $parametre = Parametre::first();
        if (!$parametre) {
            Log::error('Aucun paramètre trouvé.');
            return null;
        }

        return [
            'nom_commune' => $parametre->nom_commune,
            'nom_departement' => $parametre->nom_departement,
            'nom_region' => $parametre->nom_region,
            'nom_maire' => $parametre->nom_maire,
        ];
    }

    private function get_signature_path()
    {
        $signaturePath = 'signatures/maire_signature.png';
        if (Storage::disk('local')->exists($signaturePath)) {
            $fileContents = Storage::disk('local')->get($signaturePath);
            $signatureData = base64_encode($fileContents);
            $signature = 'data:image/png;base64,' . $signatureData;
            return $signature;
        }
        return null;
    }

    public function print(Certificat $certificat)
    {
        $configData = $this->get_config_data();
        if (!$configData) {
            Log::error('Les paramètres de la commune ne sont pas configurés.');
            return back()->with("error", "Les paramètres de la commune ne sont pas configurés. Veuillez contacter l'administrateur.");
        }

        $signaturePath = $this->get_signature_path();
        if (!$signaturePath) {
            Log::error('Le fichier de signature du maire est manquant.');
            // return back()->with("error", "Les paramètres de la commune ne sont pas configurés. Veuillez contacter l'administrateur.");
        }

        $certDelivre = CertificatDelivre::where('certificat_id', $certificat->id)->first();

        if (!$certDelivre) {
            Log::error('Le certificat délivré correspondant est introuvable pour le certificat ID: ' . $certificat->id);
            return back()->with("error", "Le certificat correspondant introuvable. Veuillez contacter l'administrateur.");
        }
        
        if (!$certificat->numero_certificat || !$certificat->code_secret) {
            Log::error('Le certificat ou le code secret est manquant pour le certificat ID: ' . $certificat->id);
            return back()->with("error", "Une erreur est survenue. Veuillez contacter l'administrateur.");
        }
        $verificationUrl = route('certificats.show_certificat', [
            'numero_certificat' => $certificat->numero_certificat,
            'code_secret' => $certificat->code_secret,
        ]);
        $qrcode = QrCode::size(150)->generate($verificationUrl);

        return pdf()->view('pdfs.certificat_delivre', [
            'certificat' => $certDelivre,
            'config' => $configData,
            'signaturePath' => $signaturePath,
            'qrcode' => $qrcode,
        ])->name('certificat-' . $certificat->numero_certificat . '.pdf');
    }

    public function show_certificat($numero_certificat, $code_secret)
    {
        $certificat = Certificat::where('numero_certificat', $numero_certificat)
            ->where('code_secret', $code_secret)
            ->first();

        if (!$certificat) {
            Log::warning('Tentative d\'accès non autorisée au certificat: ' . $numero_certificat);
            return null;
        }

        $certDelivre = CertificatDelivre::where('certificat_id', $certificat->id)->first();
        if (!$certDelivre) {
            Log::warning('Tentative d\'accès non autorisée au certificat: ' . $numero_certificat);
            return null;
        }

        $configData = $this->get_config_data();
        if (!$configData) {
            return null;
        }
        $signaturePath = $this->get_signature_path();
        if (!$signaturePath) {
            // return null;
        }

        return view('pdfs.certificat_delivre', [
            'certificat' => $certDelivre,
            'config' => $configData,
            'signaturePath' => $signaturePath,
        ]);
    }
}
