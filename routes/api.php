<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PriceController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\ProspectController;
use App\Http\Controllers\Api\PriceListController;
use App\Http\Controllers\Api\ActivityTypeController;
use App\Http\Controllers\Api\ActivityResultController;
use App\Http\Controllers\Api\ActivitySubjectController;
use App\Http\Controllers\Api\ProspectingSourceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::controller(UserController::class)->group(function ()
{
    Route::group(['prefix' => "users"], function()
    {
        Route::post('/', 'store')->name('api.users.create');
    });
});
*/

Route::group(['middleware' => ['auth:sanctum']], function()
{
    Route::controller(UserController::class)->group(function ()
    {
        Route::group(['prefix' => "users"], function()
        {
            Route::get('/', 'index')->name('api.users.list');
            Route::get('/{id}', 'show')->name('api.users.show');
            Route::post('/', 'store')->name('api.users.create');
            Route::put('/{id}', 'update')->name('api.users.update');
            Route::delete('/{id}', 'destroy')->name('api.users.delete');

            //Route::get('/list', 'index')->name('api.users.list');
            //Route::get('/user', 'show')->name('api.users.show');
            //Route::post('/register', 'store')->name('api.users.register');
            //Route::patch('/update', 'update')->name('api.users.update');
        });

        /*
        Route::group(['prefix' => "companies"], function()
        {
            Route::get('/company', 'show')->name('api.users.companies.show');
            Route::get('/list', 'listCompanies')->name('api.users.companies.list');
            Route::post('/register', 'store')->name('api.users.companies.register');
            Route::patch('/update', 'update')->name('api.users.companies.update');
            Route::post('/users/register', 'store')->name('api.users.companies.users.register');
            Route::get('/users/list', 'listCompaniesUsers')->name('api.users.companies.users.list');
        });
        */
    });

    Route::controller(AccountController::class)->group(function ()
    {
        Route::group(['prefix' => "accounts"], function()
        {
            Route::get('/', 'index')->name('api.accounts.list');
            Route::get('/{id}', 'show')->name('api.accounts.show');
            Route::post('/', 'store')->name('api.accounts.create');
            Route::put('/{id}', 'update')->name('api.accounts.update');
            Route::delete('/{id}', 'destroy')->name('api.accounts.delete');
        });
    });

    Route::controller(CompanyController::class)->group(function ()
    {
        Route::group(['prefix' => "companies"], function()
        {
            Route::post('/', 'store')->name('api.companies.create');
            Route::get('/{id}', 'show')->name('api.companies.show');
            Route::put('/{id}', 'update')->name('api.companies.update');
            Route::get('/', 'index')->name('api.companies.list');
            Route::delete('/{id}', 'destroy')->name('api.companies.delete');
        });

        /*
        Route::group(['prefix' => "company-users"], function()
        {
            Route::post('/', 'store')->name('api.companies.users.create');
            Route::get('/{id}', 'list_users_companies')->name('api.companies.users.list');
        });
        */
    });

    Route::controller(ProfileController::class)->group(function ()
    {
        Route::group(['prefix' => "profiles"], function()
        {
            Route::get('/{id}', 'show')->name('api.profiles');
            Route::post('/', 'store')->name('api.profiles.create');
            Route::put('/{id}', 'update')->name('api.profiles.update');
        });
    });

    Route::group(['prefix' => "prospects"], function()
    {
        Route::controller(ProspectController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.prospects.list');
            Route::get('/{id}', 'show')->whereNumber('id')->name('api.prospects.show');
            Route::post('/', 'store')->name('api.prospects.create');
            Route::put('/{id}', 'update')->name('api.prospects.update');

            Route::post('/activity', 'store_prospect_and_activity')->name('api.prospects.activity.create');

            //CHECAR Route::post('/activity', 'store_prospect_activity')->name('api.prospects.activity.create');
            //CHECAR Route::get('/companies/contacts/list', 'list_contacts_companies')->name('api.prospects.companies.contacts.list');

            //Route::get('/list', 'index')->name('api.prospects.list');
            //Route::get('/client/{id}', 'show')->name('api.prospects.show');
            //Route::patch('/update/{id}', 'update')->name('api.prospects.update');
            //Route::post('/activity/register', 'store_client_activity')->name('api.prospects.activity.register');
            //Route::get('/companies/contacts/list', 'list_contacts_companies')->name('api.prospects.companies.contacts.list');
        });



        /*
        Route::group(['prefix' => "origins"], function()
        {
            Route::controller(ProspectingSourceController::class)->group(function ()
            {
                //Route::get('/list', 'index')->name('api.prospects.origins');
                //Route::post('/register', 'store')->name('api.prospects.origins.register');
                //Route::patch('/update/{id}', 'update')->name('api.prospects.origins.update');
                //Route::get('/client-origin/{id}', 'show')->name('api.prospects.origins.client_origin');

                Route::group(['prefix' => "mediums"], function()
                {
                    //Route::post('/register', 'store')->name('api.prospects.origins.medium.register');
                    //Route::patch('/update/{id}', 'update')->name('api.prospects.origins.medium.update');
                    //Route::get('/list/{id_client_origin}', 'index')->name('api.prospects.origins.medium.list');
                    //Route::get('/client-origin-medium/{id}', 'show')->name('api.prospects.origins.medium.client_origin_medium');
                });
            });
        });
        */
    });

    Route::group(['prefix' => "prospecting-sources"], function()
    {
        Route::controller(ProspectingSourceController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.prospecting.sources.list');
            Route::get('/{id}', 'show')->whereNumber('id')->name('api.prospecting.sources.show');

            Route::post('/', 'store')->name('api.prospecting.sources.create');
            Route::put('/{id}', 'update')->name('api.prospecting.sources.update');
        });
    });

    Route::group(['prefix' => "prospecting-means"], function()
    {
        Route::controller(ProspectingSourceController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.prospecting.means.list');
            Route::get('/{id}', 'show')->whereNumber('id')->name('api.prospecting.means.show');

            Route::put('/{id}', 'update')->name('api.prospecting.means.update');
            Route::post('/', 'store_prospecting_means')->name('api.prospecting.means.create');
        });
    });

    Route::group(['prefix' => "activities"], function()
    {
        Route::controller(ActivityController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.activities.list');
            Route::get('/{id}', 'show')->name('api.activities.show');
            Route::post('/', 'store')->name('api.activities.create');
            Route::post('/reschedule/{id}', 'store_reschedule')->name('api.activities.reschedule.create');

            //Route::get('/list', 'index')->name('api.activities.list');
            //Route::post('/create', 'store')->name('api.activities.create');
            //Route::get('/activity/{id}', 'show')->name('api.activities.activity');
            //Route::post('/reschedule/create/{id}', 'store_reschedule')->name('api.activities.reschedule.create');
        });

        /*
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
        */

        Route::group(['prefix' => "activity-results"], function()
        {
            Route::controller(ActivityResultController::class)->group(function ()
            {
                Route::get('/', 'index')->name('api.activity.results.list');
                Route::get('/{id}', 'show')->name('api.activity.results.show');
                Route::post('/', 'store')->name('api.activity.results.create');
                Route::put('/{id}', 'update')->name('api.activity.results.update');
            });
        });
    });

    Route::group(['prefix' => "activity-types"], function()
    {
        Route::controller(ActivityTypeController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.activity.types.list');
            Route::get('/{id}', 'show')->name('api.activity.types.show');
            Route::post('/', 'store')->name('api.activity.types.create');
            Route::put('/{id}', 'update')->name('api.activity.types.update');
        });
    });

    Route::group(['prefix' => "activity-subjects"], function()
    {
        Route::controller(ActivitySubjectController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.activity.subjects.list');
            Route::post('/', 'store')->name('api.activity.subjects.create');
            Route::put('/{id}', 'update')->name('api.activity.subjects.update');
            Route::get('/{activity_type_id?}/{id?}', 'show')->name('api.activity.subjects.show');
        });
    });

    Route::group(['prefix' => "tags"], function()
    {
        Route::controller(TagController::class)->group(function ()
        {
            Route::post('/', 'store')->name('api.tags.create');
            Route::put('/{id}', 'update')->name('api.tags.update');
            Route::get('/{type?}', 'index')->where('type', 'tag|list')->name('api.tags.list');
            Route::get('/{id}', 'show')->name('api.tags.show');
            //CHECAR Route::get('/list/all', 'index')->name('api.tags.list.all');

            //Route::get('/tag/{id}', 'show')->name('api.tags.tag');
            //Route::get('/list/{type}', 'index')->name('api.tags.list');
            //Route::get('/list/all', 'index')->name('api.tags.list.all');
            //Route::post('/register', 'store')->name('api.tags.register');
            //Route::patch('/update/{id}', 'update')->name('api.tags.update');
        });
    });

    ///////////NEWS
    Route::group(['prefix' => "products"], function()
    {
        Route::controller(ProductController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.products.list');
            Route::post('/', 'store')->name('api.products.create');
            Route::get('/{id}', 'show')->name('api.products.show');
            Route::put('/{id}', 'update')->name('api.products.update');
            Route::get('/category/{category_id}', 'index')->name('api.products.list.category');

            //Route::get('/list', 'index')->name('api.products.list');
            //Route::post('/create', 'store')->name('api.products.create');
            //Route::get('/product/{id}', 'show')->name('api.products.product');
            //Route::patch('/update/{id}', 'update')->name('api.products.update');
            //Route::get('/list/category/{category_id}', 'index')->name('api.products.list.category');
        });
    });

    Route::group(['prefix' => "categories"], function()
    {
        Route::controller(CategoryController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.categories.list');
            Route::get('/{id}', 'show')->name('api.categories.show');
            Route::post('/', 'store')->name('api.categories.create');
            Route::put('/{id}', 'update')->name('api.categories.update');

            //Route::get('/list', 'index')->name('api.categories.list');
            //Route::post('/create', 'store')->name('api.categories.create');
            //Route::get('/category/{id}', 'show')->name('api.categories.category');
            //Route::patch('/update/{id}', 'update')->name('api.categories.update');

            Route::group(['prefix' => "subcategories"], function()
            {
                Route::get('/{category_id}', 'index')->name('api.categories.subcategories.list');

                //Route::get('/list/{category_id}', 'index')->name('api.categories.subcategories.list');
            });
        });
    });

    Route::group(['prefix' => "currencies"], function()
    {
        Route::controller(CurrencyController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.currencies.list');
            Route::get('/{id}', 'show')->name('api.currencies.show');
            Route::post('/', 'store')->name('api.currencies.create');
            Route::put('/{id}', 'update')->name('api.currencies.update');

            //Route::get('/list', 'index')->name('api.currencies.list');
            //Route::post('/create', 'store')->name('api.currencies.create');
            //Route::get('/currency/{id}', 'show')->name('api.currencies.currency');
            //Route::patch('/update/{id}', 'update')->name('api.currencies.update');
        });
    });

    Route::group(['prefix' => "prices"], function()
    {
        Route::controller(PriceController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.prices.list');
            Route::post('/', 'store')->name('api.prices.create');
            Route::get('/{id}', 'show')->name('api.prices.show');
            Route::put('/{id}', 'update')->name('api.prices.update');
            Route::delete('/{id}', 'destroy')->name('api.prices.delete');

            //Route::get('/list', 'index')->name('api.prices.list');
            //Route::post('/create', 'store')->name('api.prices.create');
            //Route::get('/price/{id}', 'show')->name('api.prices.price');
            //Route::patch('/update/{id}', 'update')->name('api.prices.update');
        });

        /*
        Route::group(['prefix' => "lists"], function()
        {
            Route::controller(PriceListController::class)->group(function ()
            {
                Route::get('/list', 'index')->name('api.prices.lists');
                Route::post('/create', 'store')->name('api.prices.lists.create');
                Route::patch('/update/{id}', 'update')->name('api.prices.lists.update');
                //Route::get('/price-list/{id}', 'show')->name('api.prices.lists.price_list');
            });
        });
        */
    });

    Route::group(['prefix' => "price-lists"], function()
    {
            Route::controller(PriceListController::class)->group(function ()
            {
                Route::get('/', 'index')->name('api.price.lists.list');
                Route::get('/{id}', 'show')->name('api.price.list.show');
                Route::post('/', 'store')->name('api.price.lists.create');
                Route::put('/{id}', 'update')->name('api.price.lists.update');
                Route::delete('/{id}', 'destroy')->name('api.price.lists.delete');
                //Route::get('/price-list/{id}', 'show')->name('api.prices.lists.price_list');
            });
    });

    Route::group(['prefix' => "quotes"], function()
    {
        Route::controller(QuoteController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.quotes.list');
            Route::get('/{id}', 'show')->whereNumber('id')->name('api.quotes.show');
            Route::post('/', 'store')->name('api.quotes.create');
            Route::get('/view', 'document_quote')->name('api.quotes.view');

            //Route::get('/list', 'index')->name('api.quotes.list');
            //Route::post('/create', 'store')->name('api.quotes.create');
            //Route::get('/quote/{id}', 'show')->name('api.quotes.quote');
            //Route::get('/document/view', 'document_quote')->name('api.quotes.view');
            //Route::patch('/update/{id}', 'update')->name('api.quotes.update');
        });
    });

    Route::get('/commons/get-curp', [CommonController::class, 'fetchCurp'])->name('api.fetch.curp');
    Route::get('/commons/get-zip-code/{cp}', [CommonController::class, 'fetchCp'])->name('api.fetch.cp');
});

Route::post('/login', [AuthController::class, 'login']);
//Route::post('/register', [AuthController::class, 'register']);
