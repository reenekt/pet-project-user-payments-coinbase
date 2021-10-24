<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('login');
    }

    public function login(Request $request)
    {
        if ($request->user('sanctum')) {
            throw ValidationException::withMessages([
                'auth' => ['The user is already logged in'],
            ]);
        }

        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $user = User::query()
            ->where('email', $request->input('login'))
            ->orWhere('phone_number', $request->input('login'))
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['The provided credentials are incorrect'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken('first-party-app')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
        } catch (\Throwable $exception) {
            return response()->json([
                'result' => false,
            ]);
        }

        return response()->json([
            'result' => true,
        ]);
    }

    public function currentUser(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }
}
