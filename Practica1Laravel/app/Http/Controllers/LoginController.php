<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\checkUserIsLogged;
use App\Models\User;
use Illuminate\Http\Response;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email:rfc',
            'password' => 'required',
        ]); 

        if(!auth()->attempt($data)) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthenticated');
        }

        $user = Auth::user();
        $accessToken = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => Auth::user(), 'token' => $accessToken]);

    }


    public function me(Request $request)
    {
        return auth('sanctum')->user();
    }

    public function logout(Request $request) {
        auth('sanctum')->user()->currentAccessToken()->delete();
    }
}