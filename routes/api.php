<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|URL: http://damesender.local/api/

| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('throttle:60')->post('/domain-purchase', [HomeController::class, 'sendEmail'])->name('sendEmail');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
