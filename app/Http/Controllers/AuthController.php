<?php

namespace App\Http\Controllers;

use App\Services\LarApi;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private LarApi $api)
    {
    }

    public function showLogin()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $token = $this->api->login($credentials['email'], $credentials['password']);

        if (!$token) {
            return back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put('api_token', $token);

        return redirect()->intended(route('counties.index'));
    }

    public function logout(Request $request)
    {
        $this->api->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
