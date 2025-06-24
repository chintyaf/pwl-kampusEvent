<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class MemberController extends Controller
{
    public function profile()
    {
        $token = Session::get('token');

        // Validate token via Node.js backend
        $auth = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('http://localhost:3000/api/auth/login-auth');

        if ($auth->failed()) {
            Session::forget('token');
            return redirect()
                ->view('auth.login')
                ->withErrors(['login' => 'Session expired or invalid token']);
        }
        $user = $auth->json();
        $id = $user['id'];


        $response = Http::get("http://localhost:3000/api/member/profile/{$id}");

        if ($response->successful()) {
            $user = $auth->json();
            $event = $response->json(); // parse JSON response to array
            return view('member.profile')->with(
                ['event' => $event, 'user' => $user]
            );
        } else {
            // dd($event);
            abort(404, 'Event not found or error fetching event.');
        }
        return view('event-register.register');
    }

    public function registered($id)
    {
        $token = Session::get('token');

        // Validate token via Node.js backend
        $auth = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('http://localhost:3000/api/auth/login-auth');

        if ($auth->failed()) {
            Session::forget('token');
            return redirect()
                ->view('auth.login')
                ->withErrors(['login' => 'Session expired or invalid token']);
        }
        $user = $auth->json();
        $user_id = $user['id'];


        $response = Http::get("http://localhost:3000/api/member/profile/{$user_id}/registered/{$id}");

        if ($response->successful()) {
            $user = $auth->json();
            $event = $response->json(); // parse JSON response to array
            return view('member.registered')->with(
                ['event' => $event, 'user' => $user]
            );
        } else {
            // dd($event);
            abort(404, 'Event not found or error fetching event.');
        }
        return view('member.registered');
    }
}
