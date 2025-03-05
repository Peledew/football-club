<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Js;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::create($fields);

        $token = $user->createToken($request->email);

        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                "message" => "Bad credentials"
            ], 401);
        }

        $token = $user->createToken($user->email);

        return response()->json([
            "user" => $user,
            "token" => $token->plainTextToken,
        ]);

    }

    public function logout(Request $request): JsonResponse{
        $request -> user() -> tokens() -> delete();
        return response()->json(['message' => 'You are logged out']);
    }
}
