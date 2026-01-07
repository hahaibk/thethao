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
        return view('login/login'); // view login nhúng CSS
    }

    // Xử lý login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;

            if ($role === 'admin') return redirect('/admin');
            if ($role === 'staff') return redirect('/staff');

            return redirect('/'); // user
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng']);
    }

    // Hiển thị form đăng ký
    public function showRegister()
    {
        return view('login/register'); // view register nhúng CSS
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        // validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // tạo user mới, mặc định role = 'user'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // login luôn sau khi đăng ký
        Auth::login($user);

        return redirect('/'); // redirect user về trang chính
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    
}
