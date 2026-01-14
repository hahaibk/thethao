<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Hiển thị form login
    public function showLogin()
    {
        return view('shop.login.login');
    }

    // ================== LOGIN ==================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // 🔒 NẾU TÀI KHOẢN BỊ KHÓA → ĐÁ RA NGAY
            if ($user->is_locked) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tài khoản này đã bị khóa!'
                ]);
            }

            // regenerate session
            $request->session()->regenerate();

            // Điều hướng theo role
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }

            if ($user->role === 'staff') {
                return redirect('/staff');
            }

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng'
        ]);
    }

    // ================== REGISTER ==================
    public function showRegister()
    {
        return view('shop.login.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'user',
            'is_locked' => false,
        ]);

        Auth::login($user);

        return redirect('/');
    }

    // ================== LOGOUT ==================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
