<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;
use App\Models\Categories;
use App\Models\Products;

class CategoriesController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer tous les produits
        $categories = Categories::all();
        
        // Retourner les produits au format JSON
        return response()->json(['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Créer un nouveau produit
        $category = Categories::create($validatedData);

        // Retourner le produit créé au format JSON
        return response()->json(['category' => $category], 201);
    }

    /**
     * Display the specified resource.
     */
   /**
 * Display the specified resource.
 */
public function show($id)
{
    $category = Categories::find($id);
    if (!$category) {
        return response()->json(['error' => 'Category not found'], 404);
    }

    return response()->json(['category' => $category]);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Trouver le produit avec l'ID donné
        $category = Products::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
    
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
        ]);
    
        // Mettre à jour les données du produit
        $category->update($validatedData);
    
        // Retourner le produit mis à jour au format JSON
        return response()->json(['category' => $category]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Trouver le produit avec l'ID donné
        $category = Categories::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
    
        // Supprimer le produit
        $category->delete();
    
        // Retourner une réponse vide avec un code de statut 204
        return response()->json(null, 204);
    }
}