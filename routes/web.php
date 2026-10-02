<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication Routes
Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [WebAuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Superadmin User Management
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('/users/{id}/terminate-session', [UserController::class, 'terminateSession'])->name('users.terminate-session');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Reverse Proxy to bypass browser CORS when testing in Swagger UI
    Route::any('/service/medifirst2000/{path?}', function (Request $request, $path = '') {
        if ($request->isMethod('OPTIONS')) {
            return response('', 200)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', '*');
        }

        $queryParams = $request->query();

        // Workaround for backend server bug in emr/get-cppt where noregistrasifk triggers undefined table "rm" error
        if ($path === 'emr/get-cppt' && isset($queryParams['noregistrasifk'])) {
            unset($queryParams['noregistrasifk']);
        }

        $targetUrl = 'https://chasanboesoirie.id/service/medifirst2000/' . $path;

        if (!empty($queryParams)) {
            $targetUrl .= '?' . http_build_query($queryParams);
        }

        $headers = [
            'User-Agent' => $request->header('User-Agent') ?: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'Accept' => '*/*',
        ];
        if ($token = $request->header('X-AUTH-TOKEN')) {
            $headers['X-AUTH-TOKEN'] = $token;
        }
        if ($auth = $request->header('Authorization')) {
            $headers['Authorization'] = $auth;
        }

        $client = Http::withoutVerifying()
            ->withHeaders($headers)
            ->withOptions([
                'timeout' => 30,
                'connect_timeout' => 15,
                'force_ip_resolve' => 'v4',
                'http_errors' => false,
            ])
            ->retry(3, 200, function ($exception) {
                return $exception instanceof \Illuminate\Http\Client\ConnectionException
                    || $exception instanceof \GuzzleHttp\Exception\ConnectException;
            });

        $contentType = $request->header('Content-Type');
        if ($contentType) {
            $client->contentType($contentType);
        }

        $method = strtoupper($request->method());

        try {
            if (in_array($method, ['GET', 'HEAD'])) {
                $response = $client->send($method, $targetUrl);
            } elseif ($request->isJson()) {
                $response = $client->send($method, $targetUrl, [
                    'json' => $request->json()->all(),
                ]);
            } else {
                $response = $client->send($method, $targetUrl, [
                    'body' => $request->getContent(),
                ]);
            }

            return response($response->body(), $response->status())
                ->header('Content-Type', $response->header('Content-Type') ?: 'application/json')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', '*');
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Connection to SIMRS backend server timed out or failed.',
                'message' => $e->getMessage(),
                'target_url' => $targetUrl,
            ], 504)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', '*');
        }
    })->where('path', '.*');
});
