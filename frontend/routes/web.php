<?php

use App\Http\Controllers\ComiteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// FRONT - MEMBER
// HOME
Route::controller(HomeController::class)->group(function () {
    Route::get('', 'index')->name('home');
    Route::get('event/{id}', 'view')->name('event.view');
});

Route::controller(EventRegistrationController::class)->group(function(){
    Route::get('event/{id}/register', 'register')->name('event.register');

});

Route::get('/chin/test', function () {
    return view('test');
});

Route::get('/events/detail', function () {
    return view('events.detail');
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

// AUTH
Route::get('/register', function () {
    return view('register'); // resources/views/register.blade.php
});

Route::get('/login', function () {
    return view('login'); // resources/views/login.blade.php
});

Route::get('/home', function () {
    return view('home'); // resources/views/home.blade.php
});


// BACK - ADMIN, FINANCE, COMITE
// ADMIN
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.index');

Route::get('/admin/manage-users', function () {
    return view('admin.manage-users');
});

// COMITE
Route::prefix('committee')->prefix('committee')->group(function () {
    Route::controller(EventController::class)->group(function () {
            Route::get('', 'index')->name('event.index');
    });

    Route::controller(EventController::class)
        ->prefix('events')
        ->group(function () {
            Route::get('', 'index')->name('event.index');
            Route::get('add', 'add')->name('event.add');
            Route::post('store', 'store')->name('events.store');
            Route::get('edit/{id}', 'edit')->name('events.edit');
            // Route::put('update/{id}', 'update')->name('events.update');
            Route::get('delete/{id}', 'delete')->name('events.delete');
        });

    Route::get('/render-speaker', function () {
        return view('events.input.speaker'); // the Blade view with x-forms.input elements
    });

    Route::get('/render-moderator', function () {
        return view('events.input.moderator'); // the Blade view with x-forms.input elements
    });

        Route::get('/render-session', function () {
        return view('events.input.session'); // the Blade view with x-forms.input elements
    });
});



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

