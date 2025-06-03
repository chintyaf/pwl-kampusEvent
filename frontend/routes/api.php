<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/users', function (Request $request) {
    // You can access the data like:
    $data = $request->all();

    // For now, just return it as JSON
    return response()->json([
        'message' => 'User received',
        'data' => $data
    ]);
});

return [
    'node_url' => env('NODE_API_URL', 'http://localhost:3000/api'),
];
