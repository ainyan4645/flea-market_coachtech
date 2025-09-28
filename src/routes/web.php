<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

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

Route::get('/', [ItemController::class, 'index']);



// Route::get('/item/{item}', [ItemController::class, 'detail']);

Route::get('/item', function() {
    return view('item.detail');
});

Route::get('/purchase', function() {
    return view('purchase.confirm');
});






// Route::get('/register', function() {
//     return view('auth.register');
// })->middleware('guest')->name('register');