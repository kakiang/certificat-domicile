<?php

namespace App\Http\Controllers;

use App\Models\Certificat;
use App\Models\Habitant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $habitants = Habitant::orderBy('nom')->get();
        return view('certificats.create', compact('habitants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $fileSizeMax = 1025 * 5;
        $validatedData = $request->validate([
            'habitant_id' => 'required|exists:habitants,id',
            'piece_identite' => 'required|string',
            'piece_identite_file_path' => 'required|file|mimes:jpeg,png,pdf|max:' . $fileSizeMax,
            'justificatif_domicile' => 'required|string',
            'justificatif_domicile_file_path' => 'required|file|mimes:jpeg,png,pdf|max:' . $fileSizeMax,
        ]);

        if (!auth()->user()->is_admin) {
            $habitantIdOfCurrentUser = auth()->user()->habitant->id ?? null;
            if (!$habitantIdOfCurrentUser || (int)$validatedData['habitant_id'] !== $habitantIdOfCurrentUser) {
                return redirect()->route('certificats.create')
                        ->with('error', 'Vous n\'êtes pas autorisé à créer un certificat pour un autre habitant.');
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

        Certificat::create($validatedData);
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
        $fileSizeMax = 1025 * 5; // 5MB

        $validatedData = $request->validate([
            'habitant_id' => 'required|exists:habitants,id',
            'piece_identite' => 'required|string',
            'piece_identite_file_path' => 'nullable|file|mimes:jpeg,png,pdf|max:' . $fileSizeMax, // Nullable pour les fichiers existants
            'justificatif_domicile' => 'required|string',
            'justificatif_domicile_file_path' => 'nullable|file|mimes:jpeg,png,pdf|max:' . $fileSizeMax, // Nullable pour les fichiers existants
        ]);

        // Logique similaire à `store` pour empêcher les habitants de changer l'habitant_id
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

        // Mettre à jour le certificat avec les données validées
        $certificat->update($validatedData);

        return redirect()->route('certificats.index')
                        ->with('success', 'Demande certificat mise à jour avec succès');
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
}
