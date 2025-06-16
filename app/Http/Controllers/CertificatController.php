<?php

namespace App\Http\Controllers;

use App\Models\Certificat;
use App\Models\Habitant;
use Illuminate\Http\Request;
use function Pest\Laravel\get;
use Illuminate\Support\Str;

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
        $fileSizeMax = 1025 * 5;
        $validatedData = $request->validate([
            'habitant_id' => 'required|exists:habitants,id',
            'piece_identite' => 'required|string',
            'piece_identite_file_path' => 'required|file|mimes:jpeg,png,pdf|max:' . $fileSizeMax,
            'justificatif_domicile' => 'required|string',
            'justificatif_domicile_file_path' => 'required|file|mimes:jpeg,png,pdf|max:' . $fileSizeMax,
        ]);

        if ($request->hasFile('piece_identite_file_path')) {
            $file = $request->file('piece_identite_file_path');
            $validatedData['piece_identite_file_path'] = $file->store('piece_identites');

            $originalFileName = $file->getClientOriginalName();
            $validatedData['piece_identite_slug']=Str::slug(pathinfo($originalFileName, PATHINFO_BASENAME));
        }

         if ($request->hasFile('justificatif_domicile_file_path')) {
            $file = $request->file('justificatif_domicile_file_path');
            $validatedData['justificatif_domicile_file_path'] = $file->store('justificatif_domiciles');

            $originalFileName = $file->getClientOriginalName();
            $validatedData['justificatif_domicile_slug']=Str::slug(pathinfo($originalFileName, PATHINFO_BASENAME));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificat $certificat) {
        $certificat->delete();
        return redirect()->route('certificats.index')
                        ->with('success', 'Demande certificat supprimé avec succès');
    }
}
