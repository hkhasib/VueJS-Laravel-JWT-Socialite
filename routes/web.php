<?php

use App\Http\Controllers\User\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/try-google',[AuthController::class,'redirectGoogle']);
Route::get('/auth/google/call-back',[AuthController::class,'callbackGoogle']);

Route::get('/try-twitter',[AuthController::class,'redirectTwitter']);
Route::get('/auth/twitter/call-back',[AuthController::class,'callbackTwitter']);

Route::get('/', function () {
    return view('welcome');
});
