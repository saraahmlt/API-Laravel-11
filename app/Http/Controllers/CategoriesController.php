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
        $categories = Categories::all();
        
        return response()->json(['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $category = Categories::create($validatedData);

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
        $category = Products::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
    
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
        ]);

        $category->update($validatedData);
    
        return response()->json(['category' => $category]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $category = Categories::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
    
        $category->delete();
    
        return response()->json(null, 204);
    }
}