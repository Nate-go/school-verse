<?php

use App\Constant\UserRole;
use App\Http\Controllers\AuthenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthenController::class, 'index'])->name('login.index');
Route::post('/login', [AuthenController::class, 'login'])->name('login');
Route::get('/not-permission', function () {
    return view('notPermission');
})->name('notPermission');

Route::get('/', function () {
    return view('index');
});

Route::get('/change', function () {
    return view('otherindex');
});

Route::get('/homepage', function () {
    return view('homepage');
})->name('homepage');

Route::group([
    'middleware' => ['auth']
], function ($router) {
    Route::resource('users', UserController::class);

    // Route::get('/homepage', function () {
    //     return view('homepage');
    // })->name('homepage');
});
