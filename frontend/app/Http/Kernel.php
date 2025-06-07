<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        // 'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'auth.api' => \App\Http\Middleware\AuthMiddleware::class, // Register the role middleware
    ];
}
