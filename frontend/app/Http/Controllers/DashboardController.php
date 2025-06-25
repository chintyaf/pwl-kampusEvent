<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    private $apiUrl = 'http://localhost:3000/api';

    public function index()
    {
        $token = Session::get('token');


        if (!$token) {
            // dd($token);
            return redirect()->route('login');
        }

        // Validate token via Node.js backend
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('http://localhost:3000/api/auth/login-auth');


        if ($response->failed()) {
            // dd($response->status(), $response->body()); // Inspect backend error
            Session::forget('token');
            return redirect()
                ->route('login')
                ->withErrors(['login' => 'Session expired or invalid token']);
        }

        $user = $response->json();

        $routes = [
            'admin' => 'admin.index',
            'finance_team' => 'finance.index',
            'member' => 'home',
            'event_committee' => 'comite.index',
            'event_staff' => 'staff.index',
        ];
        // dd($routes[$user['role']], $user);

        return isset($routes[$user['role']])
        ? redirect()->route($routes[$user['role']])
        : abort(403, 'Unauthorized');
    }

    public function admin()
    {
        return $this->accessProtectedRoute('/protected/admin', 'admin');
    }

    public function finance()
    {
        return $this->accessProtectedRoute('/protected/finance', 'finance');
    }

    public function events()
    {
        return $this->accessProtectedRoute('/protected/events', 'events');
    }

    public function staff()
    {
        return $this->accessProtectedRoute('/protected/staff', 'staff');
    }

    public function members()
    {
        return $this->accessProtectedRoute('/protected/members', 'members');
    }

    private function accessProtectedRoute($endpoint, $view)
    {
        $token = Session::get('auth_token');
        $user = Session::get('user');

        if (!$token) {
            return redirect()->route('login');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->apiUrl . $endpoint);

            if ($response->successful()) {
                $data = $response->json();
                return view('protected.' . $view, compact('user', 'data'));
            } else {
                $error = $response->json();
                return redirect()
                    ->route('dashboard')
                    ->withErrors(['error' => $error['message'] ?? 'Access denied']);
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('dashboard')
                ->withErrors(['error' => 'Connection error']);
        }
    }
}
