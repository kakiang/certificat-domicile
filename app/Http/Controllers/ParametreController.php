<?php

namespace App\Http\Controllers;

use App\Models\Parametre;
use Gate;
use Illuminate\Http\Request;

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
        if (Gate::denies('access-parametres')) {
            abort(403);
        }
        // Validation des données
        $validatedData = $request->validate([
            'nom_commune' => 'required|string|max:255',
            'nom_departement' => 'required|string|max:255',
            'nom_region' => 'required|string|max:255',
            'nom_maire' => 'required|string|max:255',
            'prix_certificat' => 'required|numeric|min:1',
        ]);

        // On récupère le premier (et seul) enregistrement et on le met à jour ou on le crée
        $parametres = Parametre::firstOrCreate([]);
        $parametres->update($validatedData);

        return redirect()->back()->with('success', 'Paramètres mis à jour avec succès.');
    }
}
