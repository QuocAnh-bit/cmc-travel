<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
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

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
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

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validated();

        if ($user->id === Auth::id() && $user->role === 'admin' && $validated['role'] !== 'admin' && ! $this->hasAnotherAdmin($user->id)) {
            return back()->withInput()->with('error', 'Khong the ha quyen admin cuoi cung.');
        }

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

        if (Auth::id() === $user->id) {
            return back()->with('error', 'Ban khong the tu khoa tai khoan cua minh!');
        }

        if ($user->role === 'admin' && $user->status === 'active' && ! $this->hasAnotherActiveAdmin($user->id)) {
            return back()->with('error', 'Khong the khoa admin dang la tai khoan quan tri cuoi cung.');
        }

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

        if ($user->role === 'admin' && ! $this->hasAnotherAdmin($user->id)) {
            return back()->with('error', 'Khong the xoa admin cuoi cung trong he thong!');
        }

        $user->delete();

        return back()->with('success', 'Da xoa nguoi dung thanh cong!');
    }

    private function hasAnotherAdmin(int $ignoreUserId): bool
    {
        return User::where('role', 'admin')
            ->whereKeyNot($ignoreUserId)
            ->exists();
    }

    private function hasAnotherActiveAdmin(int $ignoreUserId): bool
    {
        return User::where('role', 'admin')
            ->where('status', 'active')
            ->whereKeyNot($ignoreUserId)
            ->exists();
    }
}
