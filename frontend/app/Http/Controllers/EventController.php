<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:3000/api/events');
        $events = $response->json(); // Convert JSON response to array

        return view('events.index', compact('events'));
    }

    public function viewAttendance()
    {
        // $response = Http::get('http://localhost:3000/api/events');
        // $events = $response->json(); // Convert JSON response to array

        return view('events.attendee');
    }

    public function add()
    {
        $token = Session::get('token');

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

        return view('events.add')->with(['user' => $user]);
    }

    public function store(Request $request)
    {
        $token = Session::get('token');

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

        $sessions = $request->input('sessions', []);
        $sessionDates = collect($sessions)->pluck('date')->filter();

        // Calculate start_date and end_date
        $startDate = $sessionDates->min();
        $endDate = $sessionDates->max();

        // Format to ISO 8601 (or you can use Y-m-d if needed by backend)
        $startDate = Carbon::parse($startDate)->toDateString(); // or ->toISOString()
        $endDate = Carbon::parse($endDate)->toDateString();

        // dd($user);
        // Prepare payload
        $data = [
            'user_id' => $user['id'],
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'poster_url' => $request->input('poster_url'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'sessions' => [],
        ];

        foreach ($sessions as $session) {
            $data['sessions'][] = [
                'title' => $session['title'] ?? '',
                'description' => $session['description'] ?? '',
                'date' => $session['date'] ?? '',
                'start_time' => $session['start_time'] ?? '',
                'end_time' => $session['end_time'] ?? '',
                'max_participants' => $session['max_participants'] ?? '',
                'registration_fee' => $session['registration_fee'] ?? '',
                'location' => $session['location'] ?? '',
                'speakers' => $session['speakers'] ?? [],
                'moderators' => $session['moderators'] ?? [],
            ];
        }

        dd($data, $sessions);

        // Send to Node.js backend
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post('http://localhost:3000/api/events/store', $data);

        // Handle response
        if ($response->successful()) {
            return redirect()->route('event.index')->with('success', 'Event submitted successfully!');
        } else {
            return back()->withErrors(['submit_error' => 'Failed to submit event.']);
        }
    }

    public function edit($id)
    {
        $response = Http::get("http://localhost:3000/api/events/{$id}");

        if ($response->successful()) {
            $event = $response->json(); // parse JSON response to array
            return view('events.edit', compact('event'));
        } else {
            abort(404, 'Event not found or error fetching event.');
        }
    }

    // public function update($id, $request){
    //     // Send PUT request with form data to Node.js API
    //     $response = Http::put("http://localhost:3000/events/{$id}", $request->all());

    //     if ($response->successful()) {
    //         return redirect()->route('events.edit', $id)->with('success', 'Event updated successfully!');
    //     } else {
    //         return back()->withErrors('Failed to update event.');
    //     }
    // }
}
