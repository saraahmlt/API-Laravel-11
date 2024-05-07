<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ApiProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/v1/products",
     *     summary="Get all products",
     *     tags={"Products"},
     *     security={{ "sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Products")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
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
     *
     * @OA\Post(
     *     path="/api/v1/products",
     *     summary="Create a new product",
     *     tags={"Products"},
     *     security={{ "sanctum": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "description", "price", "stock", "categories"},
     *                 @OA\Property(property="name", type="string", example="Productname"),
     *                 @OA\Property(property="description", type="string", example="Product description"),
     *                 @OA\Property(property="price", type="number", format="float", example="12.25"),
     *                 @OA\Property(property="stock", type="integer", example="10"),
     *                 @OA\Property(
     *                     property="categories",
     *                     type="array",
     *                     @OA\Items(type="integer", format="int64", example="1")
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Products")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
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
     *
     * @OA\Get(
     *     path="/api/v1/products/{product}",
     *     summary="Get a specific product",
     *     tags={"Products"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="ID of the product to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Products")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
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
     *
     * @OA\Put(
     *     path="/api/v1/products/{product}",
     *     summary="Update a specific product",
     *     tags={"Products"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="ID of the product to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "description", "price", "stock"},
     *                 @OA\Property(property="name", type="string", example="Productname"),
     *                 @OA\Property(property="description", type="string", example="Product description"),
     *                 @OA\Property(property="price", type="number", format="float", example="12.25"),
     *                 @OA\Property(property="stock", type="integer", example="10"),
     *                 @OA\Property(
     *                     property="categories",
     *                     type="array",
     *                     @OA\Items(type="integer", format="int64", example="1")
     *                 ),
     *                
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Resource updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Products")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
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
     *
     * @OA\Delete(
     *     path="/api/v1/products/{product}",
     *     summary="Delete a specific product",
     *     tags={"Products"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="ID of the product to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Resource deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
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

