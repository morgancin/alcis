<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SmsController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\PipelineController;
use App\Http\Controllers\Api\ProspectController;
use App\Http\Controllers\Api\PriceListController;
use App\Http\Controllers\Api\PaymentTermController;
use App\Http\Controllers\Api\ActivityTypeController;
use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\Api\PipelineStageController;
use App\Http\Controllers\Api\ActivityResultController;
use App\Http\Controllers\Api\ActivitySubjectController;
use App\Http\Controllers\Api\WhatsappTemplateController;
use App\Http\Controllers\Api\ProspectingSourceController;

//use App\Http\Controllers\Api\PriceController;

Route::group(['middleware' => ['auth:sanctum']], function()
{
    Route::controller(UserController::class)->group(function ()
    {
        Route::group(['prefix' => "users"], function()
        {
            Route::get('/', 'index')->name('api.users.list');
            Route::get('/{id}', 'show')->whereNumber('id')->name('api.users.show');
            Route::post('/', 'store')->name('api.users.create');
            Route::put('/{id}', 'update')->name('api.users.update');
            Route::delete('/{id}', 'destroy')->name('api.users.delete');

            Route::get('/roles', 'roles')->name('api.users.roles.list');
            Route::get('/permissions', 'permissions')->name('api.users.permissions.list');
        });
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
            Route::get('/{id}', 'show')->whereNumber('id')->name('api.companies.show');
            Route::put('/{id}', 'update')->name('api.companies.update');
            Route::get('/', 'index')->name('api.companies.list');
            Route::delete('/{id}', 'destroy')->name('api.companies.delete');
        });
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
        });
    });

    //Route::post('/activity-prospect', [ProspectController::class, 'store_prospect_and_activity'])->name('api.activity-prospect.create');

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
            Route::get('/{id}', 'show_prospecting_means')->whereNumber('id')->name('api.prospecting.means.show');

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
            Route::post('/{id_activity}/end', 'store_end_activity')->name('api.activities.end.create');
            //Route::put('/{id_activity}/start', 'store_end_activity')->name('api.activities.start');
            //Route::post('/reschedule/{id}', 'store_reschedule')->name('api.activities.reschedule.create');
        });
    });

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
            Route::get('/{id}', 'show')->name('api.activity.subjects.show');
        });
    });

    Route::group(['prefix' => "tags"], function()
    {
        Route::controller(TagController::class)->group(function ()
        {
            Route::post('/', 'store')->name('api.tags.create');
            Route::put('/{id}', 'update')->name('api.tags.update');
            Route::get('/', 'index')->name('api.tags.list');
            Route::get('/{id}', 'show')->name('api.tags.show');
        });
    });

    Route::group(['prefix' => "teams"], function()
    {
        Route::controller(TeamController::class)->group(function ()
        {
            Route::post('/', 'store')->name('api.teams.create');
            Route::put('/{id}', 'update')->name('api.teams.update');
            Route::get('/', 'index')->name('api.teams.list');
            Route::get('/{id}', 'show')->name('api.teams.show');
        });
    });

    Route::group(['prefix' => "leads"], function()
    {
        Route::controller(LeadController::class)->group(function ()
        {
            Route::post('/', 'store')->name('api.leads.create');
            Route::put('/{id}', 'update')->name('api.leads.update');
            Route::get('/', 'index')->name('api.leads.list');
            Route::get('/{id}', 'show')->name('api.leads.show');
        });
    });

    Route::group(['prefix' => "payment-methods"], function()
    {
        Route::controller(PaymentMethodController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.payment.methods.list');
            Route::get('/{id}', 'show')->whereNumber('id')->name('api.payment.methods.show');

            Route::post('/', 'store')->name('api.payment.methods.create');
            Route::put('/{id}', 'update')->name('api.payment.methods.update');
        });
    });

    Route::group(['prefix' => "payment-terms"], function()
    {
        Route::controller(PaymentTermController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.payment.terms.list');
            Route::get('/{id}', 'show')->whereNumber('id')->name('api.payment.terms.show');

            Route::post('/', 'store')->name('api.payment.terms.create');
            Route::put('/{id}', 'update')->name('api.payment.terms.update');
        });
    });

    Route::group(['prefix' => "whatsapp-templates"], function()
    {
        Route::controller(WhatsappTemplateController::class)->group(function ()
        {
            Route::post('/', 'store')->name('api.whatsapp.template.create');
            Route::put('/{id}', 'update')->name('api.whatsapp.template.update');
            Route::get('/', 'index')->name('api.whatsapp.template.list');
            Route::get('/{id}', 'show')->name('api.whatsapp.template.show');
        });
    });

    Route::group(['prefix' => "tag-list"], function()
    {
        Route::controller(TagController::class)->group(function ()
        {
            Route::post('/', 'store')->name('api.tag.list.create');
            Route::put('/{id}', 'update')->name('api.tag.list.update');
            //Route::get('/{type?}', 'index')->where('type', 'tag|list')->name('api.tags.list');
            //Route::get('/{id}', 'show')->name('api.tags.show');
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
        });
    });

    Route::group(['prefix' => "subcategories"], function()
    {
        Route::controller(CategoryController::class)->group(function ()
        {
            Route::get('/{category_id}', 'index')->name('api.subcategories.list');
            //Route::get('/list/{category_id}', 'index')->name('api.subcategories.list');
        });
    });

    Route::group(['prefix' => "pipelines"], function()
    {
        Route::controller(PipelineController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.pipelines.list');
            Route::get('/{id}', 'show')->name('api.pipelines.show');
            Route::post('/', 'store')->name('api.pipelines.create');
            //Route::put('/{id}', 'update')->name('api.pipelines.update');
        });

        Route::controller(PipelineStageController::class)->group(function ()
        {
            Route::get('/{id_pipeline}/stages', 'index')->name('api.pipelines.stages.list');
            Route::get('/{id_pipeline}/stages/{id_pipeline_stage}/prospects', 'index')->name('api.pipelines.stages.prospects.list');
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
        });
    });

    /*
    Route::group(['prefix' => "prices"], function()
    {
        Route::controller(PriceController::class)->group(function ()
        {
            Route::get('/', 'index')->name('api.prices.list');
            Route::post('/', 'store')->name('api.prices.create');
            Route::get('/{id}', 'show')->name('api.prices.show');
            Route::put('/{id}', 'update')->name('api.prices.update');
            Route::delete('/{id}', 'destroy')->name('api.prices.delete');
        });
    });
    */

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
        });
    });

    Route::group(['prefix' => "product-image"], function()
    {
        Route::controller(ProductController::class)->group(function ()
        {
            Route::post('/', 'uploadProductImage')->name('api.upload.product.image');
            Route::delete('/{image_src}', 'deleteProductImage')->name('api.delete.product.image');
        });
    });

    Route::get('/commons/get-curp', [CommonController::class, 'fetchCurp'])->name('api.fetch.curp');
    Route::get('/commons/get-zip-code/{cp}', [CommonController::class, 'fetchCp'])->name('api.fetch.cp');
});

Route::get('/product-image/{attachment}', function($attachment) {
    return response()->file(storage_path("app/public/products_images/$attachment"));
});

Route::post('send-sms', [SmsController::class, 'sendMessage'])->name('send.sms');
Route::post('/login', [AuthController::class, 'login']);
//Route::post('/register', [AuthController::class, 'register']);
