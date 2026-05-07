<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;

class LoginController extends Controller
{
    public function authenticate(Request $request) : RedirectResponse {
        Log::info(['web login request:', request()->all()]);
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/orders');
        }
        else {
            $user = User::where('email', request('email'))->first();
            # Create a user if a user with the entered email does not exist.
            if(empty($user)) {
                $user = User::create([
                    'name' => 'Web User',
                    'email' => request('email'),
                    'password' => request('password'),
                ]);
                # Create an order with a random amount
                $order = Order::create([
                    'user_id' => $user->id,
                    'amount' => rand(1, 100),
                    'bill_no' => 'ONL-' . rand(1, 1000),
                    'name' => $user->name,
                ]);

                return redirect('/orders/' . $order->id);
            }
        }

        return back()->withErrors([
            'email' => 'Invalid email'
        ])->onlyInput('email');
    }
    public function destroy(Request $request) : RedirectResponse{
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
