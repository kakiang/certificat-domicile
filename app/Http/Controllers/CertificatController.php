<?php

namespace App\Http\Controllers;

use App\Models\Certificat;
use App\Models\Habitant;
use App\Models\Maison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use function Spatie\LaravelPdf\Support\pdf;

class CertificatController extends Controller {
    /**
     * Constructeur pour autoriser automatiquement les actions sur le contrôleur.
     * Cela simplifie la gestion des permissions pour les méthodes CRUD standards.
     */
    public function __construct() {
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
    public function index() {
        $certificats = Certificat::forCurrentUser()->paginate(15);
        return view('certificats.index', compact('certificats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        if (!Auth::check()) {
            return redirect()->route('habitants.create')
            ->with('message', 'Please register as a Habitant first or log in.');
        }

        $habitants = Habitant::forCurrentUser()->orderBy('nom')->get();
        
        if ($habitants->isEmpty()) {
            return redirect()->route('habitants.create')
                ->with('message', 'You need to create a Habitant profile first.');
        }

        return view('certificats.create', compact('habitants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        Log::info('Début de la méthode store pour CertificatController.');
        
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

        if ($request->hasFile('piece_identite_file_path')) {
            $file = $request->file('piece_identite_file_path');
            $validatedData['piece_identite_file_path'] = $file->store('piece_identites');

            $originalFileName = $file->getClientOriginalName();
            $validatedData['piece_identite_slug'] = Str::slug(pathinfo($originalFileName, PATHINFO_BASENAME));
        }

        if ($request->hasFile('justificatif_domicile_file_path')) {
            $file = $request->file('justificatif_domicile_file_path');
            $validatedData['justificatif_domicile_file_path'] = $file->store('justificatif_domiciles');

            $originalFileName = $file->getClientOriginalName();
            $validatedData['justificatif_domicile_slug'] = Str::slug(pathinfo($originalFileName, PATHINFO_BASENAME));
        }

        $habitant = Habitant::with('maison.quartier')->findOrFail($validatedData['habitant_id']);
        Log::info('Informations de l\'habitant récupérées.', ['habitant_id' => $habitant->id]);

        if ($habitant->maison && $habitant->maison->quartier) {
            $codeQuartier = Str::upper(Str::substr($habitant->maison->quartier->nom, 0, 3));
            $codeMaison = $habitant->maison->numero;
            $codeHabitant = $habitant->id;
            $validatedData['numero_certificat'] = "{$codeQuartier}-{$codeMaison}-{$codeHabitant}";
                    Log::info('Numéro de certificat généré.', ['numero' => $validatedData['numero_certificat']]);
        } else {
            Log::warning('Impossible de générer le numéro de certificat car les informations de la maison ou du quartier sont manquantes.');
        }

        try {
            Certificat::create($validatedData);
            Log::info('Certificat créé avec succès.', ['data' => $validatedData]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du certificat.', ['error' => $e->getMessage()]);
        }
        return redirect()->route('certificats.index')
                        ->with('success', 'Demande certificat enregistré avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificat $certificat) {
        return view('certificats.show', compact('certificat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificat $certificat) {
        $habitants = Habitant::orderBy('nom')->get();
        return view('certificats.edit', compact('certificat', 'habitants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificat $certificat) {
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

    public function update_status(Request $request, Certificat $certificat) {
        Log::info('function update_status');
        $validatedData = $request->validate([
            'status' => ['required', Rule::in(['En attente', 'En cours de traitement', 'Incomplète', 'Délivré', 'Rejété'])],
            'observation' => ['nullable', 'string'],
        ]);
        Log::info('Données validées avec succès.', $validatedData);
        $certificat->update($validatedData);

        Log::info('Certificat mise à jour.');
        return redirect()->route('certificats.show', $certificat)
                        ->with('success', 'Le statut du certificat a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificat $certificat) {
        // Supprimer les fichiers associés avant de supprimer l'enregistrement du certificat
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

    public function print(Certificat $certificat) {
        return pdf()->view('pdfs.certificat', ['certificat' => $certificat])
                    ->name('certificat-'.$certificat->numero_certificat.'.pdf');
    }
}
