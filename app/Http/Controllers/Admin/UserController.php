<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin',
        ], [
            'name.required' => 'Vui long nhap ho va ten.',
            'email.required' => 'Vui long nhap email.',
            'email.email' => 'Email khong dung dinh dang.',
            'email.unique' => 'Email nay da ton tai.',
            'password.required' => 'Vui long nhap mat khau.',
            'password.min' => 'Mat khau phai co it nhat 8 ky tu.',
            'role.required' => 'Vui long chon vai tro.',
            'role.in' => 'Vai tro khong hop le.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = 'active';

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Them nguoi dung moi thanh cong!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'password' => 'nullable|string|min:8',
        ], [
            'name.required' => 'Vui long nhap ho va ten.',
            'email.required' => 'Vui long nhap email.',
            'email.email' => 'Email khong dung dinh dang.',
            'email.unique' => 'Email nay da ton tai.',
            'password.min' => 'Mat khau phai co it nhat 8 ky tu.',
            'role.required' => 'Vui long chon vai tro.',
            'role.in' => 'Vai tro khong hop le.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Cap nhat thong tin thanh cong!');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'active' ? 'blocked' : 'active';
        $user->save();

        return back()->with('success', 'Thay doi trang thai thanh cong!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() === $user->id) {
            return back()->with('error', 'Ban khong the tu xoa chinh minh!');
        }

        $user->delete();

        return back()->with('success', 'Da xoa nguoi dung thanh cong!');
    }
}
