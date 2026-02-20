<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| 商品一覧（トップ）
|--------------------------------------------------------------------------
*/

Route::get('/', [ItemController::class, 'index'])->name('items.index');

/*
|--------------------------------------------------------------------------
| 商品詳細
|--------------------------------------------------------------------------
*/
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');

/*
|--------------------------------------------------------------------------
| 商品購入
|--------------------------------------------------------------------------
*/
Route::get('/purchase/{item_id}', [PurchaseController::class, 'index'])->name('purchase.index');

/*
|--------------------------------------------------------------------------
| 送付先住所変更
|--------------------------------------------------------------------------
*/
Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address'])
    ->name('purchase.address');
// ※ 設計書の i{tem_id} は typo → {item_id} に修正

/*
|--------------------------------------------------------------------------
| 商品出品
|--------------------------------------------------------------------------
*/
Route::get('/sell', [SellController::class, 'create'])->name('sell.create');

/*
|--------------------------------------------------------------------------
| マイページ
|--------------------------------------------------------------------------
*/
Route::get('/mypage', [MypageController::class, 'index'])->middleware('auth')
    ->name('mypage');
// /mypage?page=buy  /mypage?page=sell → 同じ '/mypage' でOK（クエリパラメータで分岐）

/*
|--------------------------------------------------------------------------
| プロフィール編集（設定）
|--------------------------------------------------------------------------
*/
Route::get('/mypage/profile', [ProfileController::class, 'edit'])->middleware('auth')
    ->name('mypage.profile');


Route::post('/login', [LoginController::class, 'login'])
    ->name('login');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
