<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // public function register(Request $request)
    // {
    //     $validator = Validator::make(request()->all(), [
    //         'name' => 'required|string|max:255|unique:users',
    //         'password' => 'required|string|min:8',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     $user = User::create([
    //         'name' => request('name'),
    //         'password' => Hash::make(request('password')),
    //     ]);

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'Bearer',
    //     ]);
    // }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('name', 'password'))) {
            return response()->json([
                'message' => 'Login Failed'
            ], 401);
        }

        $user = User::where('name', $request['name'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Successfully Logged In',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    public function me(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully Logged Out',
        ], 200);
    }
}
