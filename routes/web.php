<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\UserCategoryController;
use App\Http\Controllers\Front\UserFollowController;
use App\Http\Controllers\Front\UserDmApplyController;
use App\Http\Controllers\Front\UserBlockController;
use App\Http\Controllers\Front\PostController;

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

// Auth
Auth::routes();


// Post
Route::get('/post/list', [PostController::class, 'list'])->name('post.list'); // 一覧表示
Route::get('/post', [PostController::class, 'index'])->name('post.index'); // 入力画面
Route::get('/post/{post_id}/edit', [PostController::class, 'editIndex'])->name('post.editIndex'); // 入力画面
Route::post('/post/store_post', [PostController::class, 'store'])->name('post.store'); // 新規作成or編集
Route::post('/post/favorite', [PostController::class, 'favorite'])->name('post.favorite'); // 投稿お気に入り登録

// Follow

Route::get('/user/follow_list',   function () { return view('user/follow_list'); })  ->name('user.follow_list');   // フォロー一覧画面
Route::get('/user/follower_list', function () { return view('user/follower_list'); })->name('user.follower_list'); // フォロワー一覧画面
Route::post('/user/follow_user',   [UserFollowController::class, 'follow'])->name('user.follow');                                            // フォロー
Route::post('/user/unfollow_user', [UserFollowController::class, 'unfollow'])->name('user.unfollow');                                          // フォロー解除

// Block
Route::get('/user/block_list', function () { return view('user/block_list'); })->name('user.block_list'); // ブロック一覧画面
//Route::post('/user/block',   [UserBlockController::class, 'block']);                                      // ブロック
//Route::post('/user/unblock', [UserBlockController::class, 'unblock']);                                    // ブロック解除

// Category
Route::post('/user/select_category', [UserCategoryController::class, 'select_category']); // カテゴリ選択

// User
Route::get('/user/mypage',     function () { return view('user/mypage'); }) ->name('user.mypage');  // マイページ画面
Route::get('/user/profile',    function () { return view('user/profile'); })->name('user.profile'); // プロフィール画面
Route::get('/user/{user_id}',  function () { return view('user/other'); })  ->name('user.other');   // 他ユーザー画面
Route::post('/user/update_profile', [UserController::class, 'update_user']);                        // プロフィール更新

// Route::post('/user/{user_id}',  [UserController::class, 'get_other_user']);                         // 他ユーザー情報取得

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () { return view('user/mypage'); }) ->name('user.mypage');
});
