<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporterController;
use App\Http\Controllers\TrackerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//
// Non-authenticated routes
//

// keep this around (for now) to help learning blade
Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    if (Auth::check()) {
        return view('dashboard');
    } else {
        return view('home');
    }
})->name('home');

Route::get('/credits', function () {
    return view('credits');
})->name('credits');

//
// Authenticated routes
//
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'tracker'], function () {
        Route::get('/', [TrackerController::class, 'create'])->name('tracker.create');
        Route::post('/', [TrackerController::class, 'store'])->name('tracker.store');
    });

    Route::group(['prefix' => 'reporter'], function () {
        Route::get('/', [ReporterController::class, 'index'])->name('reporter.index');
        Route::get('/graph/{metric}', [ReporterController::class, 'graph'])->name('reporter.graph');
    });
});



require __DIR__.'/auth.php';
