<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WebAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $login = $credentials['login'];
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($fieldType, $login)->first();

        if ($user && !$user->is_active) {
            return back()->withErrors([
                'login' => 'Akun Anda berstatus nonaktif. Silakan hubungi Superadmin.',
            ])->onlyInput('login');
        }

        $attemptCredentials = [
            $fieldType => $login,
            'password' => $credentials['password'],
            'is_active' => true,
        ];

        if (Auth::attempt($attemptCredentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $sessionId = $request->session()->getId();

            /** @var User $authenticatedUser */
            $authenticatedUser = Auth::user();

            // Clear any other active sessions in the database for this user (enforce single active device)
            DB::table('sessions')
                ->where('user_id', $authenticatedUser->id)
                ->where('id', '!=', $sessionId)
                ->delete();

            // Parse simple device platform from User-Agent
            $userAgent = $request->userAgent() ?: 'Perangkat Tidak Dikenal';
            $device = 'Browser Web';
            if (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
                $device = 'iOS Mobile/Tablet';
            } elseif (preg_match('/Android/i', $userAgent)) {
                $device = 'Android Device';
            } elseif (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
                $device = 'macOS Desktop';
            } elseif (preg_match('/Windows/i', $userAgent)) {
                $device = 'Windows PC';
            } elseif (preg_match('/Linux/i', $userAgent)) {
                $device = 'Linux PC';
            }

            // Update user record with the active session and device details
            $authenticatedUser->update([
                'current_session_id' => $sessionId,
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
                'last_device' => $device,
            ]);

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'login' => 'Username/Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if ($user) {
            $user->update(['current_session_id' => null]);
            DB::table('sessions')->where('user_id', $user->id)->delete();
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
