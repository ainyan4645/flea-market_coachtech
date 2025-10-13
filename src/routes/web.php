<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MypageController;

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


/** ゲストアクセス可能 **/

/* 商品一覧画面(TOP) */
Route::get('/', [ItemController::class, 'index']);

/* 商品詳細画面 */
Route::get('/item', function() {
    return view('item.detail');
});

// Route::get('/item/{item}', [ItemController::class, 'detail']);



/** ゲストユーザ **/
Route::middleware('guest')->group(function () {
    /* 会員登録画面 */
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);
    /* ログイン画面 */
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginValid']);
});


// Fortifyが /login POST を担当


/** ログインユーザのみ **/
Route::middleware(['auth'])->group(function () {
    /* 商品購入画面 */
    Route::get('/purchase', function() {
    return view('purchase.confirm');
    });

    /* 住所変更ページ */
    Route::get('/purchase/address', function() {
        return view('purchase.address');
    });

    /* 商品出品画面 */
    Route::get('/sell', [ItemController::class, 'sell'])->name('sell');

    /* プロフィール画面 */
    Route::get('/mypage', [MypageController::class, 'mypage'])->name('mypage');

    /* プロフィール編集画面 */
    Route::get('/mypage/profile', [MypageController::class, 'mypageEdit'])->name('mypage.edit');
    Route::post('mypage/profile/update', [MypageController::class, 'update'])->name('mypage.update');
});