<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name("home");

Route::get('/event1', function () {
    return view('event-register.detail');
});

Route::get('/event1/register', function () {
    return view('event-register.register');
});


Route::get('/event1/payment', function () {
    return view('event-register.payment');
});

Route::get('/event1/registered', function () {
    return view('event-register.registered');
});
