<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AnexoController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\ActivityTypeController;
use App\Http\Controllers\Api\ClientOriginController;
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
            Route::get('/user', 'show')->name('api.users.show');
            Route::post('/register', 'store')->name('api.users.register');
            Route::patch('/update', 'update')->name('api.users.update');
        });

        Route::group(['prefix' => "companies"], function()
        {
            Route::get('/company', 'show')->name('api.users.companies.show');
            Route::get('/list', 'listCompanies')->name('api.users.companies.list');
            Route::post('/register', 'store')->name('api.users.companies.register');
            Route::patch('/update', 'update')->name('api.users.companies.update');
            Route::post('/users/register', 'store')->name('api.users.companies.users.register');
            Route::get('/users/list', 'listCompaniesUsers')->name('api.users.companies.users.list');
        });
    });

    Route::controller(ProfileController::class)->group(function ()
    {
        Route::group(['prefix' => "users"], function()
        {
            Route::get('/profile', 'show')->name('api.users.profile');
            Route::patch('/profile/update', 'update')->name('api.users.profile.update');
        });
    });

    Route::group(['prefix' => "clients"], function()
    {
        Route::controller(ClientController::class)->group(function ()
        {
            Route::get('/list', 'index')->name('api.clients.list');
            Route::get('/client/{id}', 'show')->name('api.clients.show');
            //Route::post('/register', 'store')->name('api.clients.register');
            Route::patch('/update/{id}', 'update')->name('api.clients.update');

            Route::post('/activity/register', 'store_client_activity')->name('api.clients.activity.register');
        });

        Route::group(['prefix' => "origins"], function()
        {
            Route::controller(ClientOriginController::class)->group(function ()
            {
                Route::get('/list', 'index')->name('api.clients.origins');
                Route::post('/register', 'store')->name('api.clients.origins.register');
                Route::patch('/update/{id}', 'update')->name('api.clients.origins.update');

                Route::group(['prefix' => "mediums"], function()
                {
                    Route::post('/register', 'store')->name('api.clients.origins.medium.register');
                    Route::patch('/update/{id}', 'update')->name('api.clients.origins.medium.update');
                    Route::get('/list/{id_client_origin}', 'index')->name('api.clients.origins.medium');    //Route::get('/list/{id_client_origin}', 'listOriginsMedium')->name('api.clients.origins.medium');
                });
            });
        });
    });

    Route::group(['prefix' => "activities"], function()
    {
        Route::controller(ActivityController::class)->group(function ()
        {
            Route::get('/list', 'index')->name('api.activities.list');
            Route::post('/register', 'store')->name('api.activities.register');
        });

        Route::group(['prefix' => "types"], function()
        {
            Route::controller(ActivityTypeController::class)->group(function ()
            {
                Route::get('/list', 'index')->name('api.activities.types');
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
                Route::get('/list/{id_activity_type}', 'index')->name('api.activities.subjects');
            });
        });
    });

    Route::group(['prefix' => "tags"], function()
    {
        Route::controller(TagController::class)->group(function ()
        {
            Route::get('/list/{type}', 'index')->name('api.tags.list');
            Route::get('/list/all', 'index')->name('api.tags.list.all');
            Route::post('/register', 'store')->name('api.tags.register');
            Route::patch('/update/{id}', 'update')->name('api.tags.update');
        });
    });

    Route::post('/fetch/curp', [AnexoController::class, 'fetchCurp'])->name('api.fetch.curp');
    Route::get('/fetch/data/cp/{cp}', [AnexoController::class, 'fetchCp'])->name('api.fetch.data.cp');
});

Route::post('/login', [AuthController::class, 'login']);
//Route::post('/register', [AuthController::class, 'register']);
