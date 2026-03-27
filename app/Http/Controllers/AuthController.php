<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // FORM LOGIN
    public function login(){
        return view('auth.login');
    }

    // XỬ LÝ LOGIN
    public function handleLogin(Request $request){
    $request->validate([
        'email'=>'required|email',
        'password'=>'required'
    ]);

    if(Auth::attempt($request->only('email','password'))){

        $request->session()->regenerate();

        // phân quyền
        if (Auth::user()->role === 'admin') {
            return redirect('/admin');
        }

        return redirect('/');
    }

    return back()->with('error','Sai email hoặc mật khẩu');
}

    // FORM REGISTER
    public function register(){
        return view('auth.register');
    }

    // XỬ LÝ REGISTER
    public function handleRegister(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        return redirect('/login')->with('success','Đăng ký thành công');
    }

    // LOGOUT
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}