<?php

namespace App\Http\Controllers;

use App\Models\Certificat;
use App\Models\Habitant;
use Illuminate\Http\Request;
use function Pest\Laravel\get;

class CertificatController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $certificats = Certificat::paginate(15);
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
        $validatedData = $request->validate([
            'habitant_id' => ['required'],
        ]);
        Certificat::create($validatedData);
        return redirect()->route('certificats.index')
                        ->with('success', 'Demande certificat enregistré avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificat $certificat) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificat $certificat) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificat $certificat) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificat $certificat) {
        //
    }
}
