<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetricsController;

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

    /*
     * Metrics
     */
    Route::group(['prefix' => 'tracker'], function () {
        Route::get('/', [MetricsController::class, 'create'])->name('tracker');
    });

    Route::group(['prefix' => 'metrics'], function () {
        Route::get('/', [MetricsController::class, 'index'])->name('reporter');
        //Route::get('/', [MetricsController::class, 'create']);
        Route::post('/', [MetricsController::class, 'store']);
        Route::get('/{metric}', [MetricsController::class, 'show'])->name('reporter-metric');
    });
});



require __DIR__.'/auth.php';
