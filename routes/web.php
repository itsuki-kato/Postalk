<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\UserController;

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

// login
Route::get('/login', [UserController::class, 'login']);

// Top
// TODO：middlewareのauthチェックを有効にする。
Route::group(['middleware => auth'], function () {
    Route::get('/', function () { return view('top'); });
});
