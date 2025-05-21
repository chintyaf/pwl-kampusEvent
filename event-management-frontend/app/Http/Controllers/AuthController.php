<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('NODE_API_URL', 'http://localhost:5000/api');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = Http::post("{$this->apiBaseUrl}/auth/login", [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            session([
                'token' => $data['token'],
                'user' => $data['user']
            ]);
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $response = Http::post('http://localhost:5000/api/register', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
        
        if ($response->successful()) {
            $data = $response->json();
            session([
                'token' => $data['token'],
                'user' => $data['user']
            ]);
            return redirect('/');
        }

        return back()->withErrors($response->json());
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        return redirect('/login');
    }
}