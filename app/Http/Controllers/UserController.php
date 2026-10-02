<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function authorizeSuperAdmin()
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak. Fitur ini hanya untuk Superadmin.');
        }
    }

    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();

        if ($request->has('username')) {
            $request->merge([
                'username' => trim($request->input('username')),
            ]);
        }
        if ($request->has('email')) {
            $request->merge([
                'email' => trim($request->input('email')),
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:superadmin,pengakses'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username tersebut sudah terdaftar. Silakan gunakan username lain.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, minus (-), dan garis bawah (_), tanpa spasi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Alamat email tersebut sudah digunakan oleh akun lain.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi awal minimal 6 karakter.',
            'role.required' => 'Peran (Role) wajib dipilih.',
            'role.in' => 'Peran akun harus superadmin atau pengakses.',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        return redirect()->route('dashboard', ['tab' => 'users'])->with('success', 'Pengguna baru (' . $validated['username'] . ' - ' . strtoupper($validated['role']) . ') berhasil ditambahkan.');
    }

    public function toggleStatus($id)
    {
        $this->authorizeSuperAdmin();

        $targetUser = User::findOrFail($id);

        if ($targetUser->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        $targetUser->is_active = !$targetUser->is_active;
        if (!$targetUser->is_active) {
            $targetUser->current_session_id = null;
            DB::table('sessions')->where('user_id', $targetUser->id)->delete();
        }
        $targetUser->save();

        $statusText = $targetUser->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('dashboard', ['tab' => 'users'])->with('success', "Akun {$targetUser->username} berhasil {$statusText}.");
    }

    public function resetPassword(Request $request, $id)
    {
        $this->authorizeSuperAdmin();

        $validated = $request->validate([
            'new_password' => ['required', 'string', 'min:6'],
        ]);

        $targetUser = User::findOrFail($id);
        $targetUser->password = Hash::make($validated['new_password']);
        $targetUser->current_session_id = null;
        DB::table('sessions')->where('user_id', $targetUser->id)->delete();
        $targetUser->save();

        return redirect()->route('dashboard', ['tab' => 'users'])->with('success', "Kata sandi untuk {$targetUser->username} berhasil diperbarui. Sesi perangkat telah di-reset.");
    }

    public function terminateSession($id)
    {
        $this->authorizeSuperAdmin();

        $targetUser = User::findOrFail($id);
        $targetUser->current_session_id = null;
        DB::table('sessions')->where('user_id', $targetUser->id)->delete();
        $targetUser->save();

        return redirect()->route('dashboard', ['tab' => 'users'])->with('success', "Sesi perangkat untuk akun {$targetUser->username} telah berhasil diputus.");
    }

    public function destroy($id)
    {
        $this->authorizeSuperAdmin();

        $targetUser = User::findOrFail($id);

        if ($targetUser->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        DB::table('sessions')->where('user_id', $targetUser->id)->delete();
        $targetUser->delete();

        return redirect()->route('dashboard', ['tab' => 'users'])->with('success', "Pengguna {$targetUser->username} berhasil dihapus.");
    }
}
