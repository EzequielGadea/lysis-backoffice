<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\RefereeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\SanctionCardController;
use App\Http\Controllers\SanctionCardlessController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\MarkNameController;
use App\Http\Controllers\PlayerTeamController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ResultController;
use App\Models\Events\Event;

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

        Route::controller(SubscriptionController::class)->group(function () {
            Route::get('subscriptionManagement', 'show')->name('subscriptionManagement');
            Route::get('subscriptionUpdate/{id}', 'edit');
            Route::post('subscriptionRegister', 'create');
            Route::post('subscriptionUpdate', 'update');
            Route::post('subscriptionDelete', 'delete');
            Route::post('subscriptionRestore', 'restore');
        });

        Route::controller(RefereeController::class)->group(function () {
            Route::get('refereeManagement', 'show')->name('refereeManagement');
            Route::get('refereeUpdate/{id}', 'edit');
            Route::post('refereeRegister', 'create');
            Route::post('refereeUpdate', 'update');
            Route::post('refereeDelete', 'delete');
            Route::post('refereeRestore', 'restore');
        });

        Route::controller(ManagerController::class)->group(function () {
            Route::get('managerManagement', 'show')->name('managerManagement');
            Route::get('managerUpdate/{id}', 'edit');
            Route::post('managerRegister', 'create');
            Route::post('managerUpdate', 'update');
            Route::post('managerDelete', 'delete');
            Route::post('managerRestore', 'restore');
        });

        Route::controller(PlayerController::class)->group(function () {
            Route::get('playerManagement', 'show')->name('playerManagement');
            Route::get('playerUpdate/{id}', 'edit');
            Route::post('playerRegister', 'create');
            Route::post('playerUpdate', 'update');
            Route::post('playerDelete', 'delete');
            Route::post('playerRestore', 'restore');
        });

        Route::controller(SportController::class)->group(function () {
            Route::get('sportManagement', 'show')->name('sportManagement');
            Route::get('sportUpdate/{id}', 'edit');
            Route::post('sportRegister', 'create');
            Route::post('sportUpdate', 'update');
            Route::post('sportDelete', 'delete');
            Route::post('sportRestore', 'restore');
        });

        Route::controller(LeagueController::class)->group(function () {
            Route::get('leagueManagement', 'show')->name('leagueManagement');
            Route::get('leagueUpdate/{id}', 'edit');
            Route::post('leagueRegister', 'create');
            Route::post('leagueUpdate', 'update');
            Route::post('leagueDelete', 'delete');
            Route::post('leagueRestore', 'restore');
        });

        Route::controller(SanctionCardController::class)->group(function () {
            Route::get('sanctionCardManagement', 'show')->name('sanctionCardManagement');
            Route::get('sanctionCardUpdate/{id}', 'edit');
            Route::post('sanctionCardRegister', 'create');
            Route::post('sanctionCardUpdate', 'update');
            Route::post('sanctionCardDelete', 'delete');
            Route::post('sanctionCardRestore', 'restore');
        });

        Route::controller(SanctionCardlessController::class)->group(function () {
            Route::get('sanctionCardlessManagement', 'show')->name('sanctionCardlessManagement');
            Route::get('sanctionCardlessUpdate/{id}', 'edit');
            Route::post('sanctionCardlessRegister', 'create');
            Route::post('sanctionCardlessUpdate', 'update');
            Route::post('sanctionCardlessDelete', 'delete');
            Route::post('sanctionCardlessRestore', 'restore');
        });

        Route::controller(TeamController::class)->group(function () {
            Route::get('teamManagement', 'show')->name('teamManagement');
            Route::get('teamUpdate/{id}', 'edit');
            Route::post('teamRegister', 'create');
            Route::post('teamUpdate', 'update');
            Route::post('teamDelete', 'delete');
            Route::post('teamRestore', 'restore');
        });

        Route::controller(PlayerTeamController::class)->group(function () {
            Route::get('playerTeamManagement/{id}', 'show');
            Route::get('playerTeamUpdate/{id}', 'edit');
            Route::post('playerTeamRegister', 'create');
            Route::post('playerTeamDelete', 'delete');
            Route::post('playerTeamRestore', 'restore');
            Route::post('playerTeamUpdate', 'update');
        });

        Route::controller(CountryController::class)->group(function () {
            Route::get('countryManagement', 'show')->name('countryManagement');
            Route::get('countryUpdate/{id}', 'edit');
            Route::post('countryRegister', 'create');
            Route::post('countryUpdate', 'update');
            Route::post('countryDelete', 'delete');
            Route::post('countryRestore', 'restore');
        });

        Route::controller(CityController::class)->group(function () {
            Route::get('cityManagement', 'show')->name('cityManagement');
            Route::get('cityUpdate/{id}', 'edit');
            Route::post('cityRegister', 'create');
            Route::post('cityUpdate', 'update');
            Route::post('cityDelete', 'delete');
            Route::post('cityRestore', 'restore');
        });

        Route::controller(VenueController::class)->group(function () {
            Route::get('venueManagement', 'show')->name('venueManagement');
            Route::get('venueUpdate/{id}', 'edit');
            Route::post('venueRegister', 'create');
            Route::post('venueUpdate', 'update');
            Route::post('venueDelete', 'delete');
            Route::post('venueRestore', 'restore');
        });

        Route::controller(PositionController::class)->group(function () {
            Route::get('positionManagement', 'show')->name('positionManagement');
            Route::get('positionUpdate/{id}', 'edit');
            Route::post('positionRegister', 'create');
            Route::post('positionUpdate', 'update');
            Route::post('positionDelete', 'delete');
            Route::post('positionRestore', 'restore');
        });

        Route::controller(MarkNameController::class)->group(function () {
            Route::get('markNameManagement', 'show')->name('markNameManagement');
            Route::get('markNameUpdate/{id}', 'edit');
            Route::post('markNameRegister', 'create');
            Route::post('markNameUpdate', 'update');
            Route::post('markNameDelete', 'delete');
            Route::post('markNameRestore', 'restore');
        });

        Route::controller(EventController::class)->group(function () {
            Route::get('eventManagement', 'show')->name('eventManagement');
            Route::get('eventUpdate/{event}', 'edit');
            Route::post('eventRegister', 'create');
            Route::post('eventUpdate/{event}', 'update');
            Route::delete('eventDelete/{event}', 'delete');
            Route::post('eventRestore', 'restore');
        });

        Route::controller(ResultController::class)->prefix('result')->group(function () {
            Route::get('/management/{event}', 'show');
            Route::get('/update/{event}', 'edit');
            Route::post('/create/{event}', 'create');
            Route::post('/update/{event}', 'update');
            Route::delete('/delete/{event}', 'delete');
            Route::post('/restore', 'restore');
        });
    });
});
