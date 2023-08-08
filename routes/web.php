<?php

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

Route::get('/login', [AuthenController::class, 'loginView'])->name('login');
Route::post('/login', [AuthenController::class, 'login'])->name('login1');


Route::group([
    'middleware' => 'auth:web',
    'prefix' => 'auth'

], function ($router) {
    Route::get('/', function () {
        return view('welcome');
    });
});
