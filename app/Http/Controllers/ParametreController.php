<?php

namespace App\Http\Controllers;

use App\Models\Parametre;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Log;

class ParametreController extends Controller
{
    /**
     * Affiche la vue d'édition des paramètres.
     * Crée une instance si elle n'existe pas.
     */
    public function edit()
    {
        if (Gate::denies('access-parametres')) {
            abort(403);
        }
        // On récupère le premier (et seul) enregistrement de la table
        // S'il n'existe pas, on en crée un nouveau
        $parametres = Parametre::firstOrNew([]);

        return view('parametres.edit', ['parametres' => $parametres]);
    }

    /**
     * Enregistre ou met à jour les paramètres de la commune.
     *
     */
    public function store(Request $request)
    {
        Log::info('Requête de mise à jour des paramètres reçue : ' . json_encode($request->all()));
        if (Gate::denies('access-parametres')) {
            abort(403);
        }
        // Validation des données
        $validatedData = $request->validate([
            'nom_commune' => 'required|string|max:255',
            'nom_departement' => 'required|string|max:255',
            'nom_region' => 'required|string|max:255',
            'nom_maire' => 'required|string|max:255',
            'maire_signature' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'prix_certificat' => 'required|numeric|min:1',
        ]);
        Log::info('Données validées : ' . json_encode($validatedData));
        if ($request->hasFile('maire_signature')) {
            Log::info('Fichier de signature du maire reçu.');
            $file = $request->file('maire_signature');

            $validatedData['maire_signature'] = $file->storeAs(
                'signatures',
                'maire_signature',
                'local'
            );
            Log::info('Signature du maire enregistrée : ' . $validatedData['maire_signature']);
        }else {
            Log::info('Aucun fichier de signature du maire reçu.');
            unset($validatedData['maire_signature']);
        }

        Parametre::updateOrCreate(
            ['id' => Parametre::first()?->id],
            $validatedData
        );
        Log::info('Paramètres mis à jour : ' . json_encode($validatedData));
        return redirect()->back()->with('success', 'Paramètres mis à jour avec succès.');
    }
}
