<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:3000/api/events');
        $events = $response->json(); // Convert JSON response to array

        return view('events.index', compact('events'));
    }

    public function add()
    {
        return view('events.add');
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
