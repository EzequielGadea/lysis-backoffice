<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

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

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('auth', [LoginController::class, 'Authenticate']);

Route::middleware(['auth'])->group(function () {
    Route::view('userManagement', 'userManagement')->name('user');
    Route::view('register', 'userManagement');

    Route::get('userManagement', [UserController::class, 'ReturnUsersManagement']);
    
    Route::post('userRegister', [UserController::class, 'Create']);
    Route::post('userDelete', [UserController::class, 'Delete'])

});
