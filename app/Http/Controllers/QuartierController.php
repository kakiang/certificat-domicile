<?php

namespace App\Http\Controllers;

use App\Models\Quartier;
use Illuminate\Http\Request;

class QuartierController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $quartiers = Quartier::paginate(15);
        return view('quartiers.index', compact('quartiers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('quartiers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nom' => 'required|max:100',
            'description' => 'required|max:500',
        ]);
        $nomQuartier = $validatedData['nom'];
        Quartier::create($validatedData);
        return redirect()->route('quartiers.index')
                ->with('success', "Le quartier \"{$nomQuartier}\" a été ajouté avec succès.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Quartier $quartier) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quartier $quartier) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quartier $quartier) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quartier $quartier) {
        $nomQuartier = $quartier->nom;
        $quartier->delete();
        return redirect()->route('quartiers.index')
                ->with('success', "Le quartier \"{$nomQuartier}\" a été supprimé avec succès.");
    }
}
