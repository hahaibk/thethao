<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Hiển thị danh sách user
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Form tạo user mới
    public function create()
    {
        return view('admin.users.create');
    }

    // Lưu user mới
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,user',
            'is_locked' => 'nullable|boolean',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'is_locked' => $data['is_locked'] ?? false,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Tạo user thành công');
    }

    // Form edit user
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
{
    $auth = auth()->user();

    // Nếu không phải admin, chỉ cho edit tên chính mình
    if (!$auth->isAdmin()) {
        if ($user->id !== $auth->id) {
            return back()->with('error', 'Bạn không có quyền chỉnh sửa user này!');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $data['name']
        ]);

        return back()->with('success', 'Cập nhật thành công');
    }

    // Admin chỉnh sửa user
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'role' => 'required|in:admin,user',
        'is_locked' => 'required|boolean',
    ]);

    $user->name = $data['name'];
    $user->role = $data['role'];
    $user->is_locked = $data['is_locked'];

    $user->save();

    return redirect()->route('admin.users.index')
                 ->with('success', 'Cập nhật user thành công');
}

    // Xóa user
    public function destroy(User $user)
    {
        $auth = Auth::user();

        if ($user->id === $auth->id) {
            return back()->with('error', 'Không thể xóa chính mình!');
        }

        if ($user->isAdmin()) {
            return back()->with('error', 'Không thể xóa tài khoản Admin!');
        }

        $user->delete();

        return back()->with('success', 'Đã xóa người dùng');
    }
}
