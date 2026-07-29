<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register (Request $request)
    {
        $validated=$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => hash::make($validated['password']),
            'solde_heures' => 2.00,
            'statut_compte' => 'actif',
        ]);

        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
              'user' => $user,
              'token' => $token,

        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
              'user' => $user,
              'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user()->load('skills'));
    }

    public function balance(Request $request)
    {
        return response()->json([
            
            'solde_heures'   => $user->solde_heures,
            'statut_compte'  => $user->statut_compte,
            'warning'        => $user->isSoldeWarning(),
            ]);
    }

    public function transactions(Request $request)
    {
        $user = $request->user()->transactionsReceived()->union($request->user()->transactionsSent())->latest()->paginate(15);
        
        return response()->json($transactions);
    }
}
