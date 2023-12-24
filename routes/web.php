<?php

use App\Http\Controllers\AuthController;
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

Route::middleware('checkAuth')->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Route::get('register', [AuthController::class, 'registerView'])->name('registerView');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::get('login', [AuthController::class, 'loginView']);
    Route::post('login', [AuthController::class, 'login'])->name('loginUser');
});
Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('update-profile', [AuthController::class, 'profileView'])->name('profileView');
    Route::put('update-profile', [AuthController::class, 'updateProfile'])->name('updateProfile');
});
