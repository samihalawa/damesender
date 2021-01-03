<?php

use App\Http\Controllers\CountSMSAndEmailsController;
use App\Http\Controllers\HistorialPagosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SMSController;

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
Route::get('/send', [MailController::class, 'sendTest']);
Route::get('/', [MailController::class, 'index']);

Route::resource('/historial', HistorialPagosController::class);
Route::resource('/count', CountSMSAndEmailsController::class );
Route::resource('/email', MailController::class);
Route::resource('/sms', SMSController::class);

