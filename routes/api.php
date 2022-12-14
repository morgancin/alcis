<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AnexoController;
use App\Http\Controllers\Api\PriceController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\PriceListController;
use App\Http\Controllers\Api\ActivityTypeController;
use App\Http\Controllers\Api\ClientOriginController;
use App\Http\Controllers\Api\ActivityResultController;
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
                Route::get('/client-origin/{id}', 'show')->name('api.clients.origins.client_origin');

                Route::group(['prefix' => "mediums"], function()
                {
                    Route::get('/list/all', 'index')->name('api.clients.origins.medium.list.all');
                    Route::post('/register', 'store')->name('api.clients.origins.medium.register');
                    Route::patch('/update/{id}', 'update')->name('api.clients.origins.medium.update');
                    Route::get('/list/{id_client_origin}', 'index')->name('api.clients.origins.medium.list');
                    Route::get('/client-origin-medium/{id}', 'show')->name('api.clients.origins.medium.client_origin_medium');
                });
            });
        });
    });

    Route::group(['prefix' => "activities"], function()
    {
        Route::controller(ActivityController::class)->group(function ()
        {
            Route::get('/list', 'index')->name('api.activities.list');
            Route::post('/create', 'store')->name('api.activities.create');
            Route::get('/activity/{id}', 'show')->name('api.activities.activity');
            Route::post('/reschedule/create/{id}', 'store_reschedule')->name('api.activities.reschedule.create');
        });

        Route::group(['prefix' => "types"], function()
        {
            Route::controller(ActivityTypeController::class)->group(function ()
            {
                Route::get('/list', 'index')->name('api.activities.types');
                Route::post('/register', 'store')->name('api.activities.types.register');
                Route::patch('/update/{id}', 'update')->name('api.activities.types.update');
                Route::get('/activity-type/{id}', 'show')->name('api.activities.types.activity_type');
            });
        });

        Route::group(['prefix' => "subjects"], function()
        {
            Route::controller(ActivitySubjectController::class)->group(function ()
            {
                Route::post('/register', 'store')->name('api.activities.subjects.register');
                Route::patch('/update/{id}', 'update')->name('api.activities.subjects.update');
                Route::get('/list/{id_activity_type}', 'index')->name('api.activities.subjects');
                Route::get('/activity-subject/{id}', 'show')->name('api.activities.subjects.activity_subject');
            });
        });

        Route::group(['prefix' => "results"], function()
        {
            Route::controller(ActivityResultController::class)->group(function ()
            {
                Route::get('/list', 'index')->name('api.activities.results');
                Route::post('/create', 'store')->name('api.activities.results.register');
                Route::patch('/update/{id}', 'update')->name('api.activities.results.update');
                Route::get('/activity-result/{id}', 'show')->name('api.activities.results.activity_subject');
            });
        });
    });

    Route::group(['prefix' => "tags"], function()
    {
        Route::controller(TagController::class)->group(function ()
        {
            Route::get('/tag/{id}', 'show')->name('api.tags.tag');
            Route::get('/list/{type}', 'index')->name('api.tags.list');
            Route::get('/list/all', 'index')->name('api.tags.list.all');
            Route::post('/register', 'store')->name('api.tags.register');
            Route::patch('/update/{id}', 'update')->name('api.tags.update');
        });
    });

    ///////////NEWS
    Route::group(['prefix' => "products"], function()
    {
        Route::controller(ProductController::class)->group(function ()
        {
            Route::get('/list', 'index')->name('api.products.list');
            Route::post('/create', 'store')->name('api.products.create');
            Route::get('/product/{id}', 'show')->name('api.products.product');
            Route::patch('/update/{id}', 'update')->name('api.products.update');
        });
    });

    Route::group(['prefix' => "categories"], function()
    {
        Route::controller(CategoryController::class)->group(function ()
        {
            Route::get('/list', 'index')->name('api.categories.list');
            Route::post('/create', 'store')->name('api.categories.create');
            Route::get('/category/{id}', 'show')->name('api.categories.category');
            Route::patch('/update/{id}', 'update')->name('api.categories.update');
        });
    });

    Route::group(['prefix' => "currencies"], function()
    {
        Route::controller(CurrencyController::class)->group(function ()
        {
            Route::get('/list', 'index')->name('api.currencies.list');
            Route::post('/create', 'store')->name('api.currencies.create');
            Route::get('/currency/{id}', 'show')->name('api.currencies.currency');
            Route::patch('/update/{id}', 'update')->name('api.currencies.update');
        });
    });

    Route::group(['prefix' => "prices"], function()
    {
        Route::controller(PriceController::class)->group(function ()
        {
            Route::get('/list', 'index')->name('api.prices.list');
            Route::post('/create', 'store')->name('api.prices.create');
            Route::get('/price/{id}', 'show')->name('api.prices.price');
            Route::patch('/update/{id}', 'update')->name('api.prices.update');
        });

        Route::group(['prefix' => "lists"], function()
        {
            Route::controller(PriceListController::class)->group(function ()
            {
                Route::get('/list', 'index')->name('api.prices.list');
                Route::post('/create', 'store')->name('api.prices.create');
                Route::patch('/update/{id}', 'update')->name('api.prices.update');
                Route::get('/price-list/{id}', 'show')->name('api.prices.price_list');
            });
        });
    });

    Route::group(['prefix' => "quotes"], function()
    {
        Route::controller(QuoteController::class)->group(function ()
        {
            Route::get('/list', 'index')->name('api.quotes.list');
            Route::post('/create', 'store')->name('api.quotes.create');
            Route::get('/quote/{id}', 'show')->name('api.quotes.quote');
            //Route::patch('/update/{id}', 'update')->name('api.quotes.update');
        });

        /*
        Route::group(['prefix' => "lists"], function()
        {
            Route::controller(PriceListController::class)->group(function ()
            {
                Route::get('/list', 'index')->name('api.prices.list');
                Route::post('/create', 'store')->name('api.prices.create');
                Route::patch('/update/{id}', 'update')->name('api.prices.update');
                Route::get('/price-list/{id}', 'show')->name('api.prices.price_list');
            });
        });
        */
    });

    Route::post('/fetch/curp', [AnexoController::class, 'fetchCurp'])->name('api.fetch.curp');
    Route::get('/fetch/data/cp/{cp}', [AnexoController::class, 'fetchCp'])->name('api.fetch.data.cp');
});

Route::post('/login', [AuthController::class, 'login']);
//Route::post('/register', [AuthController::class, 'register']);
