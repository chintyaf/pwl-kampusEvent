<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $token = Session::get('token');
        if (!$token) {
            // dd("gagal");
            return redirect('/login');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('http://localhost:3000/api/auth/login-auth');


        if ($response->failed()) {
            Session::forget('token');
            return redirect('/login')->withErrors(['login' => $response->json('error') ?? 'Login failed']);
        }

        $userData = $response->json();

        // Cek role jika diberikan
        if (!empty($roles) && !in_array($userData['role'] ?? null, $roles)) {
            abort(403, 'Unauthorized.');
        }

        // Inject data user ke dalam request
        $request->merge(['user' => $userData]);

        return $next($request);
    }
}
