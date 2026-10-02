<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnforceSingleDeviceSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // If current_session_id is tracked and doesn't match this request's session ID
            if ($user->current_session_id && $user->current_session_id !== $request->session()->getId()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'login' => 'Sesi Anda telah berakhir karena akun ini sedang aktif digunakan di perangkat lain. Satu akun hanya dapat digunakan pada satu perangkat secara bersamaan.',
                ]);
            }
        }

        return $next($request);
    }
}
