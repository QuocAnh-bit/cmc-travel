<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function handleLogin(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'status' => 'active',
        ])) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect('/admin');
            }

            return redirect('/');
        }

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->status !== 'active' && Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withInput($request->safe()->except('password'))
                ->with('error', 'Tai khoan cua ban dang bi khoa.');
        }

        return back()
            ->withInput($request->safe()->except('password'))
            ->with('error', 'Sai email hoac mat khau.');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function handleRegister(RegisterRequest $request)
    {
        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect('/login')->with('success', 'Dang ky thanh cong');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
