<?php

use Carbon\Carbon;
use App\Jobs\Logger;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestQueueEmails;

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

//Route::get('sendSMS', [TwilioSMSController::class, 'index']);

Route::get('/', function () {
    //return view('welcome');
    //Logger::dispatch();
    //Logger::dispatch()->onQueue('secondary');
    //Logger::dispatch()->delay(Carbon::today()->addMinutes(20));
});

Route::get('sending-queue-emails', [TestQueueEmails::class,'sendTestEmails']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
