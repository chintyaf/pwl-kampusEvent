<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = Session::get('jwt');
        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get('http://localhost:3000/api/profile');

        if ($response->failed()) {
            Session::forget('jwt');
            return redirect('/login');
        }

        // Attach user data to request
        $request->merge(['user' => $response->json()]);
        return $next($request);
    }
}
