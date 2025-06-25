<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class EventController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:3000/api/events');
        $events = $response->json(); // Convert JSON response to array

        return view('events.index', compact('events'));
    }

    public function viewAttendance($id)
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

        $response = Http::get("http://localhost:3000/api/comite/{$user_id}/events/{$id}");

        if ($response->successful()) {
            $user = $auth->json();
            $event = $response->json(); // parse JSON response to array
            return view('events.attendee')->with(['event' => $event, 'user' => $user]);
        } else {
            abort(404, 'Event not found or error fetching event.');
        }
        return view('events.attendee');
    }

    public function viewAttendanceSess($id, $session_id)
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

        $response = Http::get("http://localhost:3000/api/comite/{$user_id}/events/{$id}/{$session_id}");
        // dd($response->json());

        if ($response->successful()) {
            $user = $auth->json();
            $event = $response->json(); // parse JSON response to array
            $session = $event['session'];
            // dd($event, $session, $user);
            return view('events.sessattend')->with(['session' => $session, 'event' => $event['event'], 'user' => $user]);
        } else {
            abort(404, 'Event not found or error fetching event.');
        }
        return view('events.sessattend');
    }

    public function uploadCert(Request $request)
    {
        if (!$request->hasFile('zipFile')) {
            return response()->json(['message' => 'No file uploaded.'], 400);
        }

        $file = $request->file('zipFile');

        if ($file->getClientOriginalExtension() !== 'zip') {
            return response()->json(['message' => 'Only .zip files are allowed.'], 422);
        }

        // Simpan zip sementara
        $path = $file->storeAs('temp_zips', uniqid('upload_') . '.zip');

        $zipPath = storage_path('app/' . $path);
        $extractPath = storage_path('app/certificates/' . pathinfo($path, PATHINFO_FILENAME));

        // Ekstrak zip
        $zip = new ZipArchive;
        if ($zip->open($zipPath) === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();
        } else {
            return response()->json(['message' => 'Failed to extract zip file.'], 500);
        }

        // (Opsional) Hapus file zip setelah ekstrak
        unlink($zipPath);

        return response()->json(['message' => 'ZIP file uploaded and extracted successfully.']);
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

    public function scanQR($id)
    {
        $response = Http::get("http://localhost:3000/api/events/{$id}");

        if ($response->successful()) {
            $event = $response->json(); // parse JSON response to array
            return view('comite.scanqr', compact('event'));
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
