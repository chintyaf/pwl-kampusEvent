<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ComiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\MemberController;

// Route::get('/', function () {
//     return redirect()->route('login');
// });

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login-auth');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register-auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// // ADMIN
Route::middleware(['auth.api:admin'])->group(function () {
    // Route::get('/admin', function () {
    //     return view('test');
    // })->name('dashboard');
});

// FRONT - MEMBER
// HOME
Route::controller(HomeController::class)->group(function () {
    Route::get('', 'index')->name('home');
    Route::get('event/{id}', 'view')->name('event.view');
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
    // return view('event-register.registered');
});

Route::middleware(['auth.api:member'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('', 'index')->name('home');
        Route::get('profile', 'profile')->name('member.profile');
        Route::get('event/{id}', 'view')->name('event.view');
    });

    Route::controller(MemberController::class)->group(function () {
        Route::get('profile', 'profile')->name('member.profile');
        Route::get('profile/registered/event', 'registered')->name('member.registered');
    });

    Route::controller(EventRegistrationController::class)->group(function () {
        Route::get('event/{id}/register', 'register')->name('event.register');
    });
});

// BACK - ADMIN, FINANCE, COMITE
// ADMIN
Route::middleware(['auth.api:admin'])->group(function () {
    Route::controller(AdminController::class)
        ->prefix('admin')
        ->group(function () {
            Route::get('', 'index')->name('admin.index');
        });
});

// Route::get('/admin', function () {
//     return view('admin.index');
// })->name('admin.index');

Route::get('/admin/manage-users', function () {
    return view('admin.manage-users');
});

// COMITE
Route::middleware(['auth.api:event_committee'])->prefix('committee')->group(function () {
Route::controller(EventController::class)->group(function () {
            Route::get('dashboard', 'index')->name('comite.index');
        });

        Route::controller(EventController::class)->group(function () {
            Route::get('', 'index')->name('event.index');
        });

        Route::controller(EventController::class)
            ->prefix('events')
            ->group(function () {
                Route::get('', 'index')->name('event.index');
                Route::get('add', 'add')->name('event.add');
                Route::post('store', 'store')->name('events.store');
                Route::get('{id}/edit', 'edit')->name('events.edit');
                // Route::put('update/{id}', 'update')->name('events.update');
                Route::get('delete/{id}', 'delete')->name('events.delete');
                Route::get('{id}/attendance', 'viewAttendance')->name('events.view-attendace');
            });

        Route::get('/render-speaker', function () {
            return view('events.input.speaker');
        });

        Route::get('/render-moderator', function () {
            return view('events.input.moderator');
        });

        Route::get('/render-session', function () {
            return view('events.input.session');
        });
});

Route::get('/admin/users/member', function () {
    return view('admin.list-member');
})->name('admin.list-member');

// FINANCE

Route::get('/finance', function () {
    return view('finance.index');
})->name('finance.index');

Route::get('/finance/registrations', function () {
    return view('finance.registrations');
})->name('finance.registrations');


Route::middleware(['auth.api:finance_team'])->group(function () {
    // Route::get('/', [FinanceController::class, 'index'])->name('index');
    // Route::get('/finance', [FinanceController::class, 'dashboard'])->name('dashboard');

    // Route::get('/dashboard', [FinanceController::class, 'dashboard'])->name('dashboard');

    // Route::get('/registrations', [PaymentVerificationController::class, 'index'])->name('registrations');
    // Route::get('/registrations/{id}', [PaymentVerificationController::class, 'show'])->name('registrations.show');

    // // Individual Status Updates
    // Route::put('/registrations/{id}/status', [PaymentVerificationController::class, 'updateStatus'])->name('registrations.update-status');

    // Route::prefix('finance')->group(function () {
    //     Route::get('/', function () {
    //         return view('finance.index');
    //     })->name('finance.index');

    //     Route::get('/add', function () {
    //         return view('finance.add');
    //     })->name('finance.add');

    //     Route::get('/edit', function () {
    //         return view('finance.edit');
    //     })->name('finance.edit');

    //     Route::get('/disable', function () {
    //         return view('finance.disable');
    //     })->name('finance.disable');
    // });
});

Route::get('/finance/update-status', function () {
    return view('finance.update-status');
});

// STAFF
Route::middleware(['auth.api:admin'])->group(function () {
    Route::get('/staff', function () {
        return view('staff.index');
    })->name('staff.index');

    Route::get('/scanQR', function () {
    return view('test');
});
});

