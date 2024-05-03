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
    public function index(Request $request)
    {
        if ($request->has('category_id')) {
            $categoryId = $request->input('category_id');
    
            $products = Products::whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId); 
            })->with('categories')->get();
        } else {
            $products = Products::with('categories')->get();
        }
    
        return response()->json(['products' => $products]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    /**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'stock' => 'required|integer',
        'price' => 'required|numeric',
        'categories' => 'required|array',
    ]);

    $product = Products::create($validatedData);

    $product->categories()->attach($validatedData['categories']);

    return response()->json(['product' => $product->load('categories')], 201);
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
        $product = Products::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'stock' => 'integer',
            'price' => 'numeric',
            'categories' => 'array',
        ]);
    
        $product->update($validatedData);

        if (isset($validatedData['categories'])) {
            $product->categories()->sync($validatedData['categories']);
        }
    
        return response()->json(['product' => $product]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Products::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        $product->delete();
    
        return response()->json(null, 204);
    }
}

