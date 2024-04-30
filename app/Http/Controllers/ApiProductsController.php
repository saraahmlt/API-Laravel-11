<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;

class ApiProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer tous les produits
        $products = Products::with('categories')->get();
        
        // Retourner les produits au format JSON
        return response()->json(['products' => $products]);
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
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'categories' => 'required|array',
        ]);

        // Créer un nouveau produit
        $product = Products::create($validatedData);

        // Attacher les catégories au produit
        $product->categories()->attach($validatedData['categories']);

        // Retourner le produit créé au format JSON
        return response()->json(['product' => $product], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Products::with('categories')->find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json(['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Trouver le produit avec l'ID donné
        $product = Products::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'stock' => 'integer',
            'price' => 'numeric',
            'categories' => 'array',
        ]);
    
        // Mettre à jour les données du produit
        $product->update($validatedData);

        // Mettre à jour les catégories associées au produit
        if (isset($validatedData['categories'])) {
            $product->categories()->sync($validatedData['categories']);
        }
    
        // Retourner le produit mis à jour au format JSON
        return response()->json(['product' => $product]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Trouver le produit avec l'ID donné
        $product = Products::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        // Supprimer le produit
        $product->delete();
    
        // Retourner une réponse vide avec un code de statut 204
        return response()->json(null, 204);
    }
}

