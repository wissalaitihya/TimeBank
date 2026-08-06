<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiTokenController extends Controller
{
    public function index(Request $request)
    {
        $user   = $request->user();
        $tokens = $user->tokens()->latest()->get();

        return view('api-tokens.index', compact('tokens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $token = $request->user()
            ->createToken($request->name)
            ->plainTextToken;

        return redirect()->route('api-tokens.index')
            ->with('new_token', $token);
    }

    public function destroy(Request $request, $tokenId)
    {
        $request->user()
            ->tokens()
            ->where('id', $tokenId)
            ->delete();

        return redirect()->route('api-tokens.index')
            ->with('success', 'Token révoqué.');
    }
}
