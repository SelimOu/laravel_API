<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Validation\ValidationException;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    
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


    
    public function update(StoreUserRequest $request, User $post )
    {
        $post->update($request->validated());
        return new UserResource($post);
    }

    
    public function destroy(User $post)
    {
        $post->delete();
        return response(null, 204);
    }

    public function show($id)
    {
        $product = User::all();
        $product = User::find($id);
        return UserResource::make($product);
    }
    public function login(request $request){

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            throw ValidationException::withMessages(['message' => "Les informations d'identification fournies sont incorrectes"]);
        }

        if(auth('sanctum')->check()){
            auth()->user()->tokens()->delete();
         }
         $user = auth::user();
         $token = Auth::user()
                  ->createToken('app_token',['*'])
                  ->plainTextToken; 
                //   dd($token);
        return [$user,$token];
                  
}
}