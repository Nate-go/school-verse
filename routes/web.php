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

Route::group([
    'middleware' => ['auth', 'author:'. json_encode([UserRole::ADMIN])]
], function ($router) {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/homepage', function () {
        return view('homepage');
    })->name('homepage');
});
