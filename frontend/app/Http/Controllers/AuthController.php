<?php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    private $apiUrl = 'http://localhost:3000/api';

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $response = Http::post('http://localhost:3000/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->failed()) {
            return back()->withErrors(['login' => $response->json('error') ?? 'Login failed']);
        }

        $token = $response->json('token');

        // Store token in session or cookie
        session(['jwt_token' => $token]);

        return redirect('/dashboard'); // or any protected page
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     try {
    //         $response = Http::post($this->apiUrl . '/auth/login', [
    //             'email' => $request->email,
    //             'password' => $request->password
    //         ]);

    //         if ($response->successful()) {
    //             $data = $response->json();

    //             // Store token and user data in session
    //             Session::put('auth_token', $data['token']);
    //             Session::put('user', $data['user']);

    //             return redirect()->route('dashboard')->with('success', 'Login successful!');
    //         } else {
    //             $error = $response->json();
    //             return back()->withErrors(['email' => $error['message'] ?? 'Login failed']);
    //         }
    //     } catch (\Exception $e) {
    //         return back()->withErrors(['email' => 'Connection error. Please try again.']);
    //     }
    // }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:guest,member,admin,finance_team,event_committee,staff',
        ]);

        try {
            // dd($this->apiUrl . '/auth/register');
            $response = Http::post($this->apiUrl . '/auth/register', [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                // dd($data);
                 return redirect()->route('dashboard')->with('success', 'Registration successful!');
            } else {
                $error = $response->json();
                return back()->withErrors(['email' => $error['message']]);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Connection error. Please try again.']);
        }
    }

    public function logout()
    {
        Session::forget(['auth_token', 'user']);
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
