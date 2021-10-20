<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\UserController;

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

Route::get('/', [App\Http\Controllers\routeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class,'logout']);
Route::get('/auth/callback',[App\Http\Controllers\Auth\LoginController::class,'handleProviderCallback']);