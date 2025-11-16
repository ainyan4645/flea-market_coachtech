<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;

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

/* 商品一覧画面(TOP) */
Route::get('/', [ItemController::class, 'index'])->name('item.index');

/* 商品詳細画面 */
Route::get('/item/{item_id}', [ItemController::class, 'detail'])->name('item.detail');


/** ゲストユーザ **/
Route::middleware('guest')->group(function () {
    /* 会員登録画面 */
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);
    /* ログイン画面 */
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginValid']);
});


/** ログインユーザのみ **/
Route::middleware(['auth'])->group(function () {
    /* 商品詳細画面 */
    Route::post('/item/{item_id}/favorite', [ItemController::class, 'favorite'])->name('product.favorite');
    Route::post('/item/{item_id}/comment', [ItemController::class, 'comment'])->name('item.comment');

    /* 商品購入画面 */
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'confirm'])->name('purchase.confirm');
    Route::post('/purchase/payment_method/update/{item_id}', [PurchaseController::class, 'updatePayment'])->name('purchase.updatePayment');

    /* 決済画面 */
    Route::post('/purchase/checkout/{item_id}', [PurchaseController::class, 'checkout'])->name('purchase.checkout');

    /* 住所変更ページ */
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress'])->name('purchase.address');
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');

    /* 商品出品画面 */
    Route::get('/sell', [ItemController::class, 'sell'])->name('sell');
    Route::post('/sell/store', [ItemController::class, 'store'])->name('sell.store');

    /* プロフィール画面 */
    Route::get('/mypage', [MypageController::class, 'mypage'])->name('mypage');

    /* プロフィール編集画面 */
    Route::get('/mypage/profile', [MypageController::class, 'mypageEdit'])->name('mypage.edit');
    Route::put('/mypage/profile/update', [MypageController::class, 'update'])->name('mypage.update');
});