<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

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

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');
    
    Route::post('auth', [LoginController::class, 'Authenticate']);
    
    Route::middleware(['auth'])->group(function () {    
        Route::get('userManagement', [UserController::class, 'ReturnUsersManagement'])->name('userManagement');
        Route::get('adminManagement', [AdminController::class, 'ReturnAdminManagement'])->name('adminManagement');
        
        Route::post('logout', [LoginController::class, 'Logout']);
        Route::post('userRegister', [UserController::class, 'Create']);
        Route::post('userDelete', [UserController::class, 'Delete']);
        Route::post('adminRegister', [UserController::class, 'Create']);
    });
});
