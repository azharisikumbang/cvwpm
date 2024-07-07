<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login()
    {
        // redirect if authenticated
        if ($user = auth()->user())
            return redirect()->intended($user->role->getRedirectRoute());

        return view('authentication.login');
    }

    public function authenticate(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials))
        {
            $request->session()->regenerate();
            $route = auth()->user()->role->getRedirectRoute();

            return redirect()->intended($route);
        }

        return back()->withErrors([
            'username' => 'Username atau password anda salah. Silahkan coba kembali.',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
