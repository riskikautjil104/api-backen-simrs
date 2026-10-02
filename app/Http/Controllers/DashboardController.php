<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $users = [];
        $totalUsers = 0;
        $activeUsers = 0;
        $activeSessionsCount = 0;

        if ($user->isSuperAdmin()) {
            $users = User::orderByRaw("CASE WHEN role = 'superadmin' THEN 1 ELSE 2 END")
                ->orderBy('created_at', 'desc')
                ->get();

            $totalUsers = $users->count();
            $activeUsers = $users->where('is_active', true)->count();
            $activeSessionsCount = $users->whereNotNull('current_session_id')->count();
        }

        $activeTab = $request->query('tab', 'overview');

        // Prevent non-superadmin from accessing user management tab
        if ($activeTab === 'users' && !$user->isSuperAdmin()) {
            $activeTab = 'overview';
        }

        return view('dashboard.index', compact(
            'user',
            'users',
            'activeTab',
            'totalUsers',
            'activeUsers',
            'activeSessionsCount'
        ));
    }
}
