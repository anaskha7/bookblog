<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'secret_code' => 'nullable|string'
        ]);

        $role = 'subscriber';
        $is_super = false;

        // Si el código secreto existe y es correcto, el usuario será admin y super (por compatibilidad con admin original)
        if (!empty($validated['secret_code']) && $validated['secret_code'] === 'SUPER_SECRET_ADMIN_CODE') {
            $role = 'admin';
            $is_super = true;
        }

        $user = \App\Models\User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password_hash' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => $role,
            'is_super' => $is_super,
        ]);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('home');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt authentication using custom password field
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password_hash)) {
            \Illuminate\Support\Facades\Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        \Illuminate\Support\Facades\Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
