<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        // Récupérer tous les utilisateurs
        $users = User::all();
        
        // Retourner les utilisateurs au format JSON
        return response()->json(['users' => $users]);
    }

    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Créer un nouvel utilisateur
        $user = User::create($validatedData);

        // Retourner l'utilisateur créé au format JSON
        return response()->json(['user' => $user], 201);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['user' => $user]);
    }

    public function update(Request $request, $id)
{
    // Trouver l'utilisateur avec l'ID donné
    $user = User::find($id);
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Valider les données du formulaire
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string',
        'password' => 'required|string',
    ]);

    // Mettre à jour les données de l'utilisateur
    $user->update($validatedData);

    // Retourner l'utilisateur mis à jour au format JSON
    return response()->json(['user' => $user]);
}
    public function destroy($id)
    {
        // Trouver l'utilisateur avec l'ID donné
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        // Supprimer l'utilisateur
        $user->delete();
    
        // Retourner une réponse vide avec un code de statut 204
        return response()->json(null, 204);
    }
}


