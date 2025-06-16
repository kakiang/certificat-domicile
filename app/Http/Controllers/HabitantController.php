<?php

namespace App\Http\Controllers;

use App\Models\Habitant;
use App\Models\Maison;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class HabitantController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $habitants = Habitant::orderBy('nom')->paginate(15);
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

        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::transaction(function () use ($request, $validatedData) {
            $user = User::create([
                'name' => $request->prenom . ' ' . $request->nom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $validatedData['user_id'] = $user->id;

            Habitant::create($validatedData);

            event(new Registered($user));

            if(!Auth::check()){
                Auth::login($user);
            }
        });

        return redirect()->route('habitants.index')
                        ->with('success', 'Habitant enregistré avec succès');
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
