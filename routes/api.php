<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ClientController;

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
    Route::post('/users/register', [UserController::class, 'store'])->name('api.users.register');
    Route::post('/companies/register', [UserController::class, 'store'])->name('api.users.companies.register');
    Route::post('/companies/users/register', [UserController::class, 'store'])->name('api.users.companies.users.register');

    Route::get('/users/list', [UserController::class, 'index'])->name('api.users.list');
    Route::get('/companies/list', [UserController::class, 'listCompanies'])->name('api.users.companies.list');
    Route::get('/companies/users/list/{user_id}', [UserController::class, 'listCompaniesUsers'])->name('api.users.companies.users.list');

    Route::get('/clients/list/{user_id}', [ClientController::class, 'index'])->name('api.clients.list');
    Route::post('/clients/register', [ClientController::class, 'store'])->name('api.clients.register');
});

Route::post('/login', [AuthController::class, 'login']);
//Route::post('/register', [AuthController::class, 'register']);
