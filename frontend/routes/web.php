<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
    // $response = Http::get('http://localhost:5000/api/messages');
    // $messages = $response->json(); // this will be an array

    // return view('welcome', compact('messages'));
});

Route::get('/register', function () {
    return view('register'); // resources/views/register.blade.php
});

Route::get('/login', function () {
    return view('login'); // resources/views/login.blade.php
});

Route::get('/home', function () {
    return view('home'); // resources/views/home.blade.php
});