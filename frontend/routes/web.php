<?php

use App\Http\Controllers\ComiteController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/backsie', function () {
    return view('layouts.back');
});

Route::get('/fronties', function () {
    return view('layouts.front');
});



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

Route::get('/', function () {
    return view('welcome');
    // $response = Http::get('http://localhost:5000/api/messages');
    // $messages = $response->json(); // this will be an array

    // return view('welcome', compact('messages'));
// });
});
Route::get('/register', function () {
    return view('register'); // resources/views/register.blade.php
});

Route::get('/login', function () {
    return view('login'); // resources/views/login.blade.php
})-> name('login');

Route::get('/home', function () {
    return view('home'); // resources/views/home.blade.php
}) -> name('home');

// ADMIN
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.index');

Route::get('/admin/manage-users', function () {
    return view('admin.manage-users');
});

// Route::get('/committee', function () {
//     return view('committee.index');
// });

Route::get('/admin/users/member', function () {
    return view('admin.list-member');
})->name('admin.list-member');


// FINANCE
Route::prefix('finance')->group(function () {
    Route::get('/', function () {
        return view('finance.index');
    })->name('finance.index');

    Route::get('/add', function () {
        return view('finance.add');
    })->name('finance.add');

    Route::get('/edit', function () {
        return view('finance.edit');
    })->name('finance.edit');

    Route::get('/disable', function () {
        return view('finance.disable');
    })->name('finance.disable');
});


Route::get('/finance/update-status', function () {
    return view('finance.update-status');
});

Route::get('/member', function () {
    return view('member.index');
});

Route::get('/staff', function () {
    return view('staff.index');
});


// COMITE
Route::prefix('committee')->group(function () {
        Route::controller(EventController::class)->group(function(){
            // Route::get('', 'index')->name('comite.index');
        });

        Route::controller(EventController::class)->prefix('events')->group(function(){
            Route::get('', 'index')->name('event.index');
            Route::get('add', 'add')->name('event.add');
            Route::post('store', 'store')->name('comite.store');
            Route::get('edit/{id}', 'edit')->name('comite.edit');
            Route::put('update/{id}', 'update')->name('comite.update');
            Route::get('delete/{id}', 'delete')->name('comite.delete');
        });

});


