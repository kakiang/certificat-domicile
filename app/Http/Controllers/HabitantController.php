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
use Illuminate\Support\Facades\Log;

class HabitantController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->authorizeResource(Habitant::class, 'habitant');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Habitant::forCurrentUser()->orderBy('nom');
        $habitants = $query->get();

        if (!Auth::user()->is_admin) {
            return view('habitants.show', ['habitant' => $habitants->first()]);
        }
        $habitants = $query->paginate(15);
        return view('habitants.index-card', compact('habitants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $maisons = Maison::orderBy('numero')->get();
        return view('habitants.create', compact('maisons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Début du processus de création de l\'habitant');
        
        $validatedData = $request->validate([
            'nom' => ['required', 'string', 'max:50'],
            'prenom' => ['required', 'string', 'max:50'],
            'telephone' => ['required', 'string', 'max:20'],
            'date_naissance' => ['required', 'date', 'before:today'],
            'lieu_naissance' => ['required', 'max:100'],
            'maison_id' => ['required', 'exists:maisons,id'],
        ]);

        Log::info('Validation des données réussie pour la création de l\'habitant', ['data' => $validatedData]);

        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Log::info('Validation des données email et mot de passe réussie pour la création de l\'utilisateur');

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->prenom . ' ' . $request->nom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Log::info('Utilisateur créé avec succès', ['user' => $user]);

            $validatedData['user_id'] = $user->id;

            Habitant::create($validatedData);

            Log::info('Habitant créé avec succès');

            event(new Registered($user));

            if (!Auth::check()) {
                Log::info('Aucun utilisateur connecté, connexion automatique de l\'utilisateur créé');
                Auth::login($user);
            } else {
                Log::info('Utilisateur déjà connecté, pas de connexion automatique nécessaire');
            }

            DB::commit();

            Log::info('Processus de création de l\'habitant et de l\'utilisateur terminé avec succès');

            return redirect()->route('habitants.index')
                ->with('success', 'Compte habitant crée avec succès');

        } catch (\Exception $ex) {
            Log::error('Exception lors de la création de l\'habitant ou de l\'utilisateur', ['exception' => $ex->getMessage()]);
            DB::rollBack();
            return redirect()->route('habitants.index')
                ->with('error', 'Une erreur est survenue lors de la création du compte. Veuillez réessayer');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Habitant $habitant)
    {
        return view('habitants.show', compact('habitant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Habitant $habitant)
    {
        $maisons = Maison::orderBy('numero')->get();
        return view('habitants.edit', compact('habitant', 'maisons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Habitant $habitant)
    {
        $validatedData = $request->validate([
            'nom' => ['required', 'string', 'max:50'],
            'prenom' => ['required', 'string', 'max:50'],
            'telephone' => ['required', 'string', 'max:20'],
            'date_naissance' => ['required', 'date', 'before:today'],
            'lieu_naissance' => ['required', 'max:100'],
            'maison_id' => ['required', 'exists:maisons,id'],
        ]);
        $habitant->update($validatedData);
        return redirect()->route('habitants.show', $habitant)
            ->with('success', 'Les informations de l\'habitant ont été mises à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habitant $habitant)
    {
        DB::beginTransaction();

        try {

            if ($habitant->user) {
                $habitant->user->delete();
            }
            $habitant->delete();
            DB::commit();
            return redirect()->route('habitants.index')
                ->with('success', 'L\'habitant et son compte utilisateur ont été supprimés avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la suppression de l\'habitant ID ' . $habitant->id . ': ' . $e->getMessage());
            return redirect()->route('habitants.index')
                ->with('error', 'Une erreur est survenue lors de la suppression de l\'habitant.');
        }
    }
}
