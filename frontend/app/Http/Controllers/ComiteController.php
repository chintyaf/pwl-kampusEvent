<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComiteController extends Controller
{

        public function upload(Request $request)
    {
        $request->validate([
            'zipFile' => 'required|mimes:zip|max:10240', // Max 10MB
        ]);

        $response = Http::attach(
            'zipFile',
            file_get_contents($request->file('zipFile')->getRealPath()),
            $request->file('zipFile')->getClientOriginalName()
        )->post('http://localhost:3000/api/upload-certificates');

        return back()->with('message', $response->json('message') ?? 'Upload completed.');
    }
}
