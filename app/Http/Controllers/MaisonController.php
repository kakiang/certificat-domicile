<?php

namespace App\Http\Controllers;

use App\Models\Maison;
use App\Models\Proprietaire;
use App\Models\Quartier;
use Illuminate\Http\Request;

class MaisonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maisons = Maison::paginate(15);
        return view('maisons.index', compact('maisons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proprietaires = Proprietaire::all();
        $quartiers = Quartier::all();
        return view('maisons.create', ['proprietaires' => $proprietaires,
            'quartiers' => $quartiers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'numero' => 'required|max:15',
            'adresse' => 'required|max:255',
            'description' => 'required',
            'proprietaire_id' => 'required',
            'quartier_id' => 'required',
        ]);
        Maison::create($validatedData);

        return redirect()->route('maisons.index')->with('success', 'Maison ajouté avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maison $maison)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maison $maison)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maison $maison)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maison $maison)
    {
        //
    }
}
