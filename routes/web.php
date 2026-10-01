<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('api/documentation');
});

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
