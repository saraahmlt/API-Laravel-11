<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;
use App\Models\Categories;
use App\Models\Products;
use OpenApi\Annotations as OA; // Import des annotations OpenAPI

/**
 * @OA\Info(
 *     title="API de gestion des catégories",
 *     version="1.0.0",
 *     description="Documentation de l'API de gestion des catégories",
 *     @OA\Contact(
 *         email="contact@example.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */


class CategoriesController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/v1/categories",
     *     summary="Get all categories",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Categories")
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
    public function index()
    {
        $categories = Categories::all();
        
        return response()->json(['categories' => $categories]);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/v1/categories",
     *     summary="Create a new category",
     *     tags={"Categories"},
     *     security={{ "sanctum": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"name", "description"},
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 example={"name": "Category Title", "description": "Category Description"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Categories")
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
        ]);
        $category = Categories::create($validatedData);

        return response()->json(['category' => $category], 201);
    }

     /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/v1/categories/{category}",
     *     summary="Get a specific category",
     *     tags={"Categories"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         description="ID of the category to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Categories")
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
    $category = Categories::find($id);
    if (!$category) {
        return response()->json(['error' => 'Category not found'], 404);
    }

    return response()->json(['category' => $category]);
}

/**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/v1/categories/{category}",
     *     summary="Update a specific category",
     *     tags={"Categories"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         description="ID of the category to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"name", "description"},
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 example={"name": "Category Title", "description": "Category Description"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Resource updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Categories")
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
        $category = Categories::find($id);
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
     *
     * @OA\Delete(
     *     path="/api/v1/categories/{category}",
     *     summary="Delete a specific category",
     *     tags={"Categories"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         description="ID of the category to delete",
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

        $category = Categories::find($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
    
        $category->delete();
    
        return response()->json(null, 204);
    }
}