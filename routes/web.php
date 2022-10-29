<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\PostController;
use App\Http\Controllers\Front\CategoryController;

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

// UserLogin
Route::get('/login', function () { return view('user/login'); }); // ログイン画面
Route::post('/login', [UserController::class, 'login']);          // ログイン

// UserLogout
Route::get('/logout', [UserController::class, 'logout_user']); // ログアウト

// UserCreate
Route::get('/create', function () { return view('user/create'); }); // ユーザー登録画面
Route::post('/create', [UserController::class, 'create_user']);     // ユーザー登録

// Top
// TODO：middlewareのauthチェックを有効にする。
Route::group(['middleware => auth'], function () {
    Route::get('/', function () { return view('top'); });
    Route::get('/{user_id}', function () { return view('user/top'); })->name('user.top');
});

// Post
Route::get('/post', [PostController::class, 'index']); // 入力画面
Route::post('/post/create', [PostController::class, 'create']); // 新規作成
Route::get('/post/{post_id}/edit', [PostController::class, 'edit_index']); // 入力画面(編集)
Route::post('/post/{post_id}/edit', [PostController::class, 'edit']); // 編集保存

// Admin
/*
Route::get('/root', function () { return view('admin/login'); }); // 管理者ログイン画面
Route::post('/root', [AdminController::class, 'login']);          // 管理者ログイン
Route::get('/root/category', [CategoryController::class, 'index']);
*/
