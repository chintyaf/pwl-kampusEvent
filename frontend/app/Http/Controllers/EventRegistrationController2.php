<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventRegistrationController extends Controller
{
    public function register($id)
    {
        $response = Http::get("http://localhost:3000/api/events/{$id}");

        if ($response->successful()) {
            $event = $response->json(); // parse JSON response to array
            // dd($event);

            return view('event-register.register')->with(
                ['event' => $event]
            );
        } else {
            abort(404, 'Event not found or error fetching event.');
        }
        return view('event-register.register');
    }
}
