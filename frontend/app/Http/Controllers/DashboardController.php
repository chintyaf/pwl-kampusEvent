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
        $token = Session::get('auth_token');
        $user = Session::get('user');

        if (!$token || !$user) {
            return redirect()->route('login');
        }

        // Verify token with backend
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($this->apiUrl . '/protected/dashboard');

            if ($response->successful()) {
                return view('dashboard', compact('user'));
            } else {
                Session::forget(['auth_token', 'user']);
                return redirect()->route('login')->withErrors(['error' => 'Session expired']);
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Connection error']);
        }
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
                'Authorization' => 'Bearer ' . $token
            ])->get($this->apiUrl . $endpoint);

            if ($response->successful()) {
                $data = $response->json();
                return view('protected.' . $view, compact('user', 'data'));
            } else {
                $error = $response->json();
                return redirect()->route('dashboard')->withErrors(['error' => $error['message'] ?? 'Access denied']);
            }
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->withErrors(['error' => 'Connection error']);
        }
    }
}
