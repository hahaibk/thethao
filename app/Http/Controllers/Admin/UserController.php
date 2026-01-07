<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        // Chặn không cho xóa chính mình hoặc xóa Admin khác
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Không thể xóa chính mình!');
        }
        
        if ($user->isAdmin()) {
             return back()->with('error', 'Không thể xóa tài khoản Admin!');
        }

        $user->delete();
        return back()->with('success', 'Đã xóa người dùng');
    }
}