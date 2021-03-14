<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/tracker', function () {
    return view('tracker');
})->middleware(['auth'])->name('tracker');


require __DIR__.'/auth.php';
