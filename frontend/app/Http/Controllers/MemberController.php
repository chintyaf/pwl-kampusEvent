<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function profile()
    {
        // $response = Http::get('http://localhost:3000/api/events');
        // $events = $response->json(); // Convert JSON response to array

        return view('member.profile');
    }

    public function registered()
    {
        // $response = Http::get('http://localhost:3000/api/events');
        // $events = $response->json(); // Convert JSON response to array

        return view('member.registered');
    }
}
