<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetricController;
use App\Http\Controllers\TrackerController;
use App\Http\Controllers\ReporterController;
//use App\Http\Controllers\ConfigureController;

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
    return view('footer.credits');
})->name('credits');

Route::get('/disclaimer', function () {
    return view('footer.disclaimer');
})->name('disclaimer');

//
// Authenticated routes
//
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    Route::group(['prefix' => 'configure'], function () {
        Route::get('/', [ConfigureController::class, 'index'])->name('configure');
        Route::post('/', [ConfigureController::class, 'store'])->name('configure.store');
    });
     */

    Route::group(['prefix' => 'tracker'], function () {
        Route::get('/', [TrackerController::class, 'index'])->name('tracker');
        Route::get('/create', [TrackerController::class, 'create'])->name('tracker.create');
        Route::post('/', [TrackerController::class, 'store'])->name('tracker.store');
        Route::put('/{tracker_id}', [TrackerController::class, 'update'])->name('tracker.update');
        Route::get('/{tracker_id}/edit', [TrackerController::class, 'edit'])->name('tracker.edit');
        Route::get('/{tracker_id}/delete', [TrackerController::class, 'delete'])->name('tracker.delete');

        Route::group(['prefix' => '/{tracker_id}/metric'], function () {
            //Route::get('/', [MetricController::class, 'index'])->name('metric');
            Route::get('/create', [MetricController::class, 'create'])->name('metric.create');
            Route::post('/', [MetricController::class, 'store'])->name('metric.store');
            Route::put('/{metric_id}', [MetricController::class, 'update'])->name('metric.update');
            Route::get('/{metric_id}/edit', [MetricController::class, 'edit'])->name('metric.edit');
            Route::get('/{metric_id}/delete', [MetricController::class, 'delete'])->name('metric.delete');
        });
    });

    Route::group(['prefix' => 'reporter'], function () {
        Route::get('/', [ReporterController::class, 'index'])->name('reporter.index');
        Route::get('/graph/{metric}', [ReporterController::class, 'graph'])->name('reporter.graph');
    });
});



require __DIR__.'/auth.php';
