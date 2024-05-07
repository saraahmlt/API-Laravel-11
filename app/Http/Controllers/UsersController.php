<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

class UsersController extends Controller
{
     /**
     * Display a listing of User.
     *
     * @OA\Get(
     *     path="/api/v1/users",
     *     summary="Get all users",
     *     tags={"Users"},
     *     security={{ "sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
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
        $users = User::all();
        
        return response()->json(['users' => $users]);
    }
/**
     * Store a newly created User in database.
     *
     * @OA\Post(
     *     path="/api/v1/users",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     security={{ "sanctum": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="John Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="john@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="password123"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                     format="password",
     *                     example="password123"
     *                 ),
     *                 required={"name", "email", "password", "password_confirmation"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
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
            'email' => 'required|string',
            'password' => 'required|string',
            'password_confirmation' => 'required|string',
        ]);

        $user = User::create($validatedData);
        return response()->json(['user' => $user], 201);
    }

    /**
     * Display the specified User.
     *
     * @OA\Get(
     *     path="/api/v1/users/{user}",
     *     summary="Get a specific user",
     *     tags={"Users"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="ID of the user to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/User")
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
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['user' => $user]);
    }

 /**
     * Update the specified User from database.
     *
     * @OA\Put(
     *     path="/api/v1/users/{user}",
     *     summary="Update a specific user",
     *     tags={"Users"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="ID of the user to update",
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
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="John Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="john@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="password123"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                     format="password",
     *                     example="password123"
     *                 ),
     *                 required={"name", "email", "password", "password_confirmation"}
     *             )
     *         )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="User updated successfully",
     *     @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="User updated successfully"),
     *         @OA\Property(property="status", type="string", example="success"),
     *         @OA\Property(property="data", type="object", ref="#/components/schemas/User")
     *     )
     * ),
     *     @OA\Response(
     *         response=422,
     *         description="Resource deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found"
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
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string',
            'password_confirmation' => 'required|string',
        ]);
    
        $user->update($validatedData);
    
        return response()->json(['user' => $user]);
    }
    
  /**
     * Remove the specified User from database.
     *
     * @OA\Delete(
     *     path="/api/v1/users/{user}",
     *     summary="Delete a specific user",
     *     tags={"Users"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="ID of the user to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Resource deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found"
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
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user->delete();

        return response()->json(null, 204);
    }

      /**
     * Login a User and return token.
     *
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Login with email and password",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="john@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="password123"
     *                 ),
     *                 required={"email", "password"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User logged successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *                 @OA\Property(property="token", type="string", example="token_here")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated"),
     *             @OA\Property(property="status", type="string", example="error")
     *         )
     *     )
     * )
     */ 

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

     /**
     * Store a newly created User in database and return token.
     *
     * @OA\Post(
     *     path="/api/v1/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="John Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="john@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="password123"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                     format="password",
     *                     example="password123"
     *                 ),
     *                 required={"name", "email", "password", "password_confirmation"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Register successfull",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Register successfull"),
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *                 @OA\Property(property="token", type="string", example="token_here")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     )
     * )
     */

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



