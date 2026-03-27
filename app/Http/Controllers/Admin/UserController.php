<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function block($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'blocked';
        $user->save();

        return back()->with('success', 'Đã khóa tài khoản');
    }

    public function unblock($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();

        return back()->with('success', 'Đã mở khóa');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return back()->with('success', 'Đã xóa user');
    }
}