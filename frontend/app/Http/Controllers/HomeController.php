<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:3000/api/events');
        $events = $response->json(); // Convert JSON response to array

        return view('index', compact('events'));
    }

    public function view($id)
    {
        $response = Http::get("http://localhost:3000/api/events/{$id}");

        if ($response->successful()) {
            $event = $response->json(); // parse JSON response to array
            // dd($event);

            return view('event-register.detail', compact('event'));
        } else {
            abort(404, 'Event not found or error fetching event.');
        }
    }


}
