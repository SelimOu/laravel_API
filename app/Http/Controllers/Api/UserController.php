<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Validation\ValidationException;
use Validator;
use OpenApi\Annotations as OA;


class UserController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/user",
     *      tags={"User"},
     *      summary="Get all users",
     *      description="Get all users",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/user",
     *      tags={"User"},
     *      summary="Create a new user",
     *      description="Create a new user",
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      )
     * )
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        
        return [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'auth_token'=> $user->createToken('auth_token')->plainTextToken
        ];
    }

    /**
     * @OA\Put(
     *      path="/api/v1/user/{post}",
     *      tags={"User"},
     *      summary="Update an existing user",
     *      description="Update an existing user",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="post",
     *          in="path",
     *          description="ID of the user",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      )
     * )
     */
    public function update(StoreUserRequest $request, User $post)
    {
        $post->update($request->validated());
        return new UserResource($post);
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/user/{post}",
     *      tags={"User"},
     *      summary="Delete a user",
     *      description="Delete a user",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="post",
     *          in="path",
     *          description="ID of the user",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=204, description="No content"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function destroy(User $post)
    {
        $post->delete();
        return response(null, 204);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/user/{post}",
     *      tags={"User"},
     *      summary="Get a single user",
     *      description="Get a single user",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="post",
     *          in="path",
     *          description="ID of the user",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=404, description="User not found")
     * )
     */
    public function show($id)
    {
        $user = User::find($id);
        return UserResource::make($user);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/login",
     *      tags={"User"},
     *      summary="Login user",
     *      description="Login user",
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *              @OA\Property(property="password", type="string", format="password", example="secret")
     *          )
     *      )
     * )
     */
    public function login(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            throw ValidationException::withMessages(['message' => "Les informations d'identification fournies sont incorrectes"]);
        }

        if (auth('sanctum')->check()) {
            auth()->user()->tokens()->delete();
        }

        $user = Auth::user();
        $token = Auth::user()
                  ->createToken('app_token', ['*'])
                  ->plainTextToken; 

        return [$user, $token];
    }

     /**
     * @OA\Post(
     *      path="/api/v1/register",
     *      tags={"User"},
     *      summary="Regsiter a new user",
     *      description="Register a new user",
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      )
     * )
     */
    public function register(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        
        return [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'auth_token'=> $user->createToken('auth_token')->plainTextToken
        ];
    }
}
