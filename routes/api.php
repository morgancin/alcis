<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ActivityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['middleware' => ['auth:sanctum']], function()
{
    //Route::get('/users/list', [UserController::class, 'index'])->name('api.users.list');
    //Route::post('/users/register', [UserController::class, 'store'])->name('api.users.register');
    //Route::patch('/users/update/{id}', [UserController::class, 'update'])->name('api.users.update');

    //Route::post('/clients/register', [ClientController::class, 'store'])->name('api.clients.register');
    //Route::get('/clients/list/{user_id}', [ClientController::class, 'index'])->name('api.clients.list');
    //Route::patch('/clients/update/{id}', [ClientController::class, 'update'])->name('api.clients.update');

    //Route::get('/companies/list', [UserController::class, 'listCompanies'])->name('api.users.companies.list');
    //Route::post('/companies/register', [UserController::class, 'store'])->name('api.users.companies.register');
    //Route::patch('/companies/update/{id}', [UserController::class, 'update'])->name('api.users.companies.update');
    //Route::post('/companies/users/register', [UserController::class, 'store'])->name('api.users.companies.users.register');
    //Route::get('/companies/users/list/{user_id}', [UserController::class, 'listCompaniesUsers'])->name('api.users.companies.users.list');

    Route::controller(UserController::class)->group(function ()
    {
        Route::group(['prefix' => "users"], function()
        {
            Route::get('/list', 'index')->name('api.users.list');
            Route::get('/user/{id}', 'show')->name('api.users.show');
            Route::post('/register', 'store')->name('api.users.register');
            Route::patch('/update/{id}', 'update')->name('api.users.update');
        });

        Route::group(['prefix' => "companies"], function()
        {
            Route::get('/company/{id}', 'show')->name('api.users.companies.show');
            Route::get('/list', 'listCompanies')->name('api.users.companies.list');
            Route::post('/register', 'store')->name('api.users.companies.register');
            Route::patch('/update/{id}', 'update')->name('api.users.companies.update');
            Route::post('/users/register', 'store')->name('api.users.companies.users.register');
            Route::get('/users/list/{user_id}', 'listCompaniesUsers')->name('api.users.companies.users.list');
        });
    });

    Route::group(['prefix' => "clients"], function()
    {
        Route::controller(ClientController::class)->group(function ()
        {
            Route::get('/client/{id}', 'show')->name('api.clients.show');
            Route::post('/register', 'store')->name('api.clients.register');
            Route::get('/list/{user_id}', 'index')->name('api.clients.list');
            Route::patch('/update/{id}', 'update')->name('api.clients.update');
        });
    });

    Route::group(['prefix' => "activities"], function()
    {
        Route::controller(ActivityController::class)->group(function ()
        {
            Route::post('/register', 'store')->name('api.activities.register');
            Route::get('/list/{user_id}', 'index')->name('api.activities.list');
        });
    });

    ///Se borrarán éstas EndPoints
    //Route::get('/user/{id}', [UserController::class, 'show'])->name('api.users2.show');
    //Route::get('/client/{id}', [ClientController::class, 'show'])->name('api.clients2.show');
    //Route::get('/company/{id}', [UserController::class, 'show'])->name('api.users.companies2.show');
    /////////
});

Route::post('/login', [AuthController::class, 'login']);
//Route::post('/register', [AuthController::class, 'register']);
