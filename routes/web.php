<?php

use App\Http\Controllers\AuthenController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InsistenceController;
use App\Http\Controllers\UserController;
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
    return view('error/page-not-permission');
})->name('notPermission');

Route::get('/not-found', function () {
    return view('error/page-not-found');
})->name('notFound');

Route::fallback(function () {
    return redirect()->route('notFound');
});

Route::group([
    'middleware' => ['auth'],
], function ($router) {

    Route::get('/logout', [AuthenController::class, 'logout'])->name('logout');

    Route::get('/', [HomeController::class, 'index'])->name('homepage');

    Route::resource('users', UserController::class);

    Route::resource('grades', GradeController::class);

    Route::resource('semters', SemesterController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('insistences', InsistenceController::class);
    Route::resource('rooms', RoomController::class);

    Route::resource('rooms.exams', ExamsController::class)->shallow();
    Route::resource('rooms.teachers', TeachersController::class)->shallow();
    Route::resource('rooms.students', StudentsController::class)->shallow();
});
