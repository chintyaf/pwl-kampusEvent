<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class EventRegistrationController extends Controller
{
    public function register($id)
    {
        $response = Http::get("http://localhost:3000/api/events/{$id}");
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

        if ($response->successful()) {
            $user = $auth->json();
            $event = $response->json(); // parse JSON response to array
            return view('event-register.register')->with(['event' => $event, 'user' => $user]);
        } else {
            // dd($event);
            abort(404, 'Event not found or error fetching event.');
        }
        return view('event-register.register');
    }

    public function store(Request $request)
    {
        // $sessions = json_decode($request->input('sessions'), true) ?? [];
        // dd($request);
        // ✅ Step 1: Get token from session and authenticate
        $token = Session::get('token');

        $auth = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('http://localhost:3000/api/auth/login-auth');

        if ($auth->failed()) {
            Session::forget('token');
            return redirect()
                ->route('login') // adjust your login route
                ->withErrors(['login' => 'Session expired or invalid token']);
        }

        $user = $auth->json();

        // ✅ Step 3: Prepare sessions
        $sessions = json_decode($request->input('sessions'), true) ?? [];


        foreach ($sessions as $session) {
            $data['attending_session'][] = [
                'id' => $session['id'] ?? '',
            ];
        }

        // dd($request, $data);
        $file = $request->file('payment_proof');

        if (!$file) {
            return back()->withErrors(['file' => 'No payment proof uploaded.']);
        }

        // dd($file);
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])
            ->attach(
                'proof_image_url', // ✅ Nama field, harus cocok dengan multer
                file_get_contents($file->getRealPath()), // ✅ ISI FILE, wajib pakai getRealPath()
                $file->getClientOriginalName(), // ✅ Nama file
            )
            ->post('http://localhost:3000/api/member/event/register', [
                // ✅ Endpoint backend
                'user_id' => $request->user_id,
                'event_id' => $request->event_id,
                'sessions' => json_encode($request->sessions),
                'payment_method' => $request->payment_method,
            ]);

        if ($response->successful()) {
            return redirect()->route('member.profile')->with('success', 'Event registration successful!');
        } else {
            dd($response);
            return back()->withErrors(['submit_error' => 'Failed to register for event.']);
        }
    }
}
