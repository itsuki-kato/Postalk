<?php

use Illuminate\Support\Facades\Route;
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
Route::get('/login',  function () { return view('user/login'); });  // ログイン画面
Route::get('/create', function () { return view('user/create'); }); // ユーザー登録画面
Route::post('/login', [UserController::class, 'login']);            // ログイン
Route::get('/logout', [UserController::class, 'logout']);           // ログアウト
Route::post('/create', [UserController::class, 'create_user']);     // ユーザー登録

// Follow
Route::get('/user/follow_list',   function () { return view('user/follow_list'); })  ->name('user.follow_list');   // フォロー一覧画面
Route::get('/user/follower_list', function () { return view('user/follower_list'); })->name('user.follower_list'); // フォロワー一覧画面
//Route::post('/user/follow',   [UserFollowController::class, 'follow']);                                            // フォロー
Route::post('/user/unfollow', [UserFollowController::class, 'unfollow']);                                          // フォロー解除

// Block
Route::get('/user/block_list', function () { return view('user/block_list'); })->name('user.block_list'); // ブロック一覧画面
//Route::post('/user/block',   [UserBlockController::class, 'block']);                                      // ブロック
//Route::post('/user/unblock', [UserBlockController::class, 'unblock']);                                    // ブロック解除

// Category
Route::post('/user/select_category', [UserCategoryController::class, 'select_category']); // カテゴリ選択

// DM(未実装)
/*
Route::get('/user/dm_list', function () { return view('user/dm_list'); })->name('user.dm_list'); // DM一覧画面
Route::get('/user/dm',      function () { return view('user/dm'); })     ->name('user.dm');      // DM画面
Route::post('/user/{user_id}/apply_dm',   [UserApplyController::class, 'apply']);                // DM申請
Route::post('/user/{user_id}/approve_dm', [UserApplyController::class, 'approve']);              // DM申請承認
Route::post('/user/{user_id}/approve_dm', [UserApplyController::class, 'unapprove']);            // DM申請否認
*/

// Post
Route::get('/post/list', [PostController::class, 'list'])->name('post.list'); // 一覧表示
Route::get('/post', [PostController::class, 'index'])->name('post.index'); // 入力画面
Route::get('/post/{post_id}/edit', [PostController::class, 'editIndex'])->name('post.editIndex'); // 入力画面
Route::post('/post/valid', [PostController::class, 'valid'])->name('post.valid'); // バリデーションと新規作成or編集

// MEMO: User以下にFollowやBlockの上記処理を書くと画面が表示されない。別途検証

// User
Route::get('/user/mypage',     function () { return view('user/mypage'); }) ->name('user.mypage');  // マイページ画面
Route::get('/user/profile',    function () { return view('user/profile'); })->name('user.profile'); // プロフィール画面
Route::get('/user/{user_id}',  function () { return view('user/other'); })  ->name('user.other');   // 他ユーザー画面
Route::post('/user/update_profile', [UserController::class, 'update_user']);                        // プロフィール更新
// Route::post('/user/{user_id}',  [UserController::class, 'get_other_user']);                         // 他ユーザー情報取得

// Admin(未実装)
/*
Route::get('/admin',          function () { return view('admin/top'); });              // TOP画面
Route::get('/admin/category', function () { return view('admin/category'); });         // カテゴリ管理画面
Route::post('/admin/category/create', [CategoryController::class, 'create_category']); // カテゴリ追加
Route::post('/admin/category/update', [CategoryController::class, 'update_category']); // カテゴリ更新
Route::post('/admin/category/delete', [CategoryController::class, 'delete_category']); // カテゴリ削除
*/

// Top
// TODO：middlewareのauthチェックを有効にする。
Route::group(['middleware => auth'], function () {
    Route::get('/', function () { return view('top'); });
});
