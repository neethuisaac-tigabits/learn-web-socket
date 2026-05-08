<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ApiLoginController extends Controller
{
    public function authenticate(Request $request) {
        Log::info(['api login request:', request()->all()]);
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('user_token');
            return ['token' => $token->plainTextToken];
        }
        else {
            return ['token' => null];
        }
    }
}
