<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            'password_confirmation' => 'required|string',
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
            'password_confirmation' => 'required|string',
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

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            if (auth('sanctum')->check()) {
                auth()->user()->tokens()->delete();
            }
            $token = Auth::user()->createToken('app_token_' . Auth::user()->id, ['*'])->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'status' => 'success',
                'data' => [
                    "user" => Auth::user(),
                    "token" => $token
                ]
            ]);
        } else {
            return response()->json(['message' => 'Unauthorized', 'status' => 'error'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('app_token_'.$user->id, ['*'])->plainTextToken;

        return response()->json([
            'message' => 'User created successfully',
            'status' => 'success',
            'data' => [
                "user" => $user,
                "token" => $token
            ]
        ], 201);
    }
}



