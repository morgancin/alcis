<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AnexoController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\ClientOriginController;
use App\Http\Controllers\Api\ActivityTypeController;
use App\Http\Controllers\Api\ActivitySubjectController;

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
            Route::get('/users/list/{id_user}', 'listCompaniesUsers')->name('api.users.companies.users.list');
        });
    });

    Route::group(['prefix' => "clients"], function()
    {
        Route::controller(ClientController::class)->group(function ()
        {
            Route::get('/client/{id}', 'show')->name('api.clients.show');
            Route::post('/register', 'store')->name('api.clients.register');
            Route::get('/list/{id_user}', 'index')->name('api.clients.list');
            Route::patch('/update/{id}', 'update')->name('api.clients.update');
        });

        //Route::get('/origins/list', [ClientOriginController::class, 'index'])->name('api.clients.origins');
        //Route::get('/origins/mediums/list/{id_client_origin}', [ClientOriginController::class, 'listOriginsMedium'])->name('api.clients.origins.medium');

        Route::group(['prefix' => "origins"], function()
        {
            Route::controller(ClientOriginController::class)->group(function ()
            {
                Route::get('/list/{id_user}', 'index')->name('api.clients.origins');
                Route::post('/register', 'store')->name('api.clients.origins.register');
                Route::patch('/update/{id}', 'update')->name('api.clients.origins.update');

                Route::group(['prefix' => "mediums"], function()
                {
                    Route::post('/register', 'store')->name('api.clients.origins.medium.register');
                    Route::patch('/update/{id}', 'update')->name('api.clients.origins.medium.update');
                    Route::get('/list/{id_user}/{id_client_origin}', 'listOriginsMedium')->name('api.clients.origins.medium');
                });
            });
        });
    });

    Route::group(['prefix' => "activities"], function()
    {
        Route::controller(ActivityController::class)->group(function ()
        {
            Route::post('/register', 'store')->name('api.activities.register');
            Route::get('/list/{id_user}', 'index')->name('api.activities.list');
        });

        //Route::get('/types/list/{id_user}', ActivityTypeController::class)->name('api.activities.types');
        //Route::get('/subjects/list/{id_activity_type}', ActivitySubjectController::class)->name('api.activities.subjects');

        Route::group(['prefix' => "types"], function()
        {
            Route::controller(ActivityTypeController::class)->group(function ()
            {
                Route::get('/list/{id_user}', 'index')->name('api.activities.types');
                Route::post('/register', 'store')->name('api.activities.types.register');
                Route::patch('/update/{id}', 'update')->name('api.activities.types.update');
            });
        });

        Route::group(['prefix' => "subjects"], function()
        {
            Route::controller(ActivitySubjectController::class)->group(function ()
            {
                Route::post('/register', 'store')->name('api.activities.subjects.register');
                Route::patch('/update/{id}', 'update')->name('api.activities.subjects.update');
                Route::get('/list/{id_user}/{id_activity_type}', 'index')->name('api.activities.subjects');
            });
        });
    });

    Route::post('/fetch/curp', [AnexoController::class, 'fetchCurp'])->name('api.fetch.curp');
    Route::get('/fetch/data/cp/{cp}', [AnexoController::class, 'fetchCp'])->name('api.fetch.data.cp');
});

Route::post('/login', [AuthController::class, 'login']);
//Route::post('/register', [AuthController::class, 'register']);
