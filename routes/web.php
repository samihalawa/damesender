<?php

use App\Http\Controllers\CountSMSAndEmailsController;
use App\Http\Controllers\HistorialPagosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AmazonController;
use App\Http\Controllers\CampaingController;
use App\Http\Controllers\UnsuscribeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

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

Route::post('/amazon/webhook-email-notifications', [AmazonController::class,'emailNotifications']);

Route::get('/send', [MailController::class, 'sendTest']);
Route::resource('/campaing', CampaingController::class);

Route::resource('/historial', HistorialPagosController::class);
Route::resource('/count', CountSMSAndEmailsController::class );
Route::get('/email', [MailController::class, 'index']);
Route::get('/bounced', [MailController::class, 'bounced']);
Route::get('/complaint', [MailController::class, 'complaint']);
Route::get('/unsuscribe/campaing/{id}/{token}', [UnsuscribeController::class, 'unsuscribe']);
Route::get('/unsuscribe/email/{email}', [UnsuscribeController::class, 'deleteEmail']);
Route::resource('/mail', MailController::class);
Route::resource('/sms', SMSController::class);
Route::resource('/users', UserController::class);




Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');