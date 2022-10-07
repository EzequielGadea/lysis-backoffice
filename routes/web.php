<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\TagController;

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
    
    Route::post('auth', [LoginController::class, 'authenticate']);
    
    Route::middleware(['auth'])->group(function () {    
        Route::post('logout', [LoginController::class, 'logout']);

        Route::controller(UserController::class)->group(function () {
            Route::get('userManagement', 'show')->name('userManagement');
            Route::get('userUpdate/{id}', 'showUpdate');
            Route::post('userRegister', 'create');
            Route::post('userUpdate', 'update');
            Route::post('userDelete', 'delete');
            Route::post('userRestore', 'restore');
        });
        
        Route::controller(AdminController::class)->group(function () {
            Route::get('adminManagement', 'show')->name('adminManagement');
            Route::get('adminUpdate/{id}', 'showUpdate');
            Route::post('adminRegister', 'create');
            Route::post('adminUpdate', 'update');
            Route::post('adminDelete', 'delete');
            Route::post('adminRestore', 'restore');
        });
        
        Route::controller(AdController::class)->group(function () {
            Route::get('adManagement', 'show')->name('adManagement');
            Route::get('adUpdate/{id}', 'edit');
            Route::post('adRegister', 'create');
            Route::post('adUpdate', 'update');
            Route::post('adDelete', 'delete');
            Route::post('adRestore', 'restore');
        });

        Route::controller(TagController::class)->group(function () {
            Route::get('tagManagement', 'show')->name('tagManagement');
            Route::get('tagUpdate/{id}', 'edit');
            Route::post('tagRegister', 'create');
            Route::post('tagUpdate', 'update');
            Route::post('tagDelete', 'delete');
            Route::post('tagRestore', 'restore');
        });
    });
});
