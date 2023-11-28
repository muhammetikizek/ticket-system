<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'is_admin' => false
        ];

        if (Auth::guard('user')->attempt($credentials))
        {
            $request->session()->regenerate();
            session(['storeId' => Auth::guard('user')->user()->last_used_store_id]);
            return redirect()->route('order.create');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user->update([
            'last_used_store_id' => session('storeId'),
        ]);
        Auth::guard('user')->logout();
        return redirect('/');
    }
}
