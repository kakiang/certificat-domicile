<?php

namespace App\Http\Controllers;

use App\Models\Habitant;
use App\Models\Maison;
use Illuminate\Http\Request;

class HabitantController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $habitants = Habitant::orderBy('nom')->paginate(5);
        return view('habitants.index', compact('habitants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $maisons = Maison::orderBy('numero')->get();
        return view('habitants.create', compact('maisons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validatedData = $request->validate([
            'nom' => ['required', 'max:50'],
            'prenom' => ['required', 'max:50'],
            'telephone' => ['required', 'max:15'],
            'date_naissance' => ['required', 'date', 'before:today'],
            'lieu_naissance' => ['required', 'max:100'],
            'maison_id' => ['required'],
        ]);

        Habitant::create($validatedData);

        return redirect()->route('habitants.index')
                        ->with('success', 'Habitant ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Habitant $habitant) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Habitant $habitant) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Habitant $habitant) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habitant $habitant) {
        //
    }
}
