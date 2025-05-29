<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'mobile_no' => 'required|numeric|digits:10',
            'password'  => 'required|min:6'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ], 422);
        }

        $user = User::where('mobile_no', $request->mobile_no)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'data' => [
                    'response code' => 200,
                    'token' => $token,
                    'user' => $user,
                    'role' => $user->roles->first()->role_name ?? null,
                    'status' => true,
                    'message' => 'Login successful',
                ]
            ]);
        }

        return response()->json([
            'response code' => 401,
            'status' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete(); // Deletes the current token
        }

        return response()->json([
            'response code' => 200,
            'status' => true,
            'message' => 'User successfully logged out'
        ]);
    }
}
