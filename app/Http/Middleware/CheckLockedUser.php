<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckLockedUser
{
    public function handle($request, Closure $next)
    {
        dd('CHECK LOCKED USER');
        if (Auth::check()) {

            // 🔥 reload user từ DB mỗi request
            Auth::user()->refresh();

            if (Auth::user()->is_locked) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')
                    ->withErrors(['email' => 'Tài khoản của bạn đã bị khóa']);
            }
        }

        return $next($request);
    }
}
