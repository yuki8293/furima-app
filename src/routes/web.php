<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LikeController;

// authはログイン必須の意味

// 商品一覧画面
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// 商品詳細画面
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');

// いいね機能（ログインユーザーのみ実行可能）
Route::post('/item/{item}/like', [LikeController::class, 'toggle'])->middleware('auth') // 未ログインはログイン画面へ
->name('items.like');

// 商品購入画面
Route::get('/purchase/{item_id}', [PurchaseController::class, 'index'])->middleware('auth')->name('purchase.index');

// 商品購入完了処理
Route::post('/purchase/{item_id}/complete', [PurchaseController::class, 'complete'])
    ->middleware('auth')
    ->name('purchase.complete');

// 住所変更ページ
Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address'])->middleware('auth')
    ->name('purchase.address');

// 商品購入時の住所変更処理（更新）
Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])
    ->middleware('auth')
    ->name('purchase.address.update');

// 商品出品画面の表示
Route::get('/sell', [SellController::class, 'create'])->name('sell.create');

// 商品出品処理（保存）
Route::post('/sell', [SellController::class, 'store'])->middleware('auth')->name('sell.store');

// プロフィール画面表示
Route::get('/mypage', [MypageController::class, 'index'])->middleware('auth')
    ->name('mypage');

// プロフィール編集画面を表示
Route::get('/mypage/profile', [ProfileController::class, 'edit'])->middleware('auth')
    ->name('mypage.profile');
// プロフィール画面処理（更新）
Route::post('/mypage/profile', [ProfileController::class, 'update'])
    ->middleware('auth')
    ->name('mypage.profile.update');

// ログイン処理
Route::post('/login', [LoginController::class, 'login'])
    ->name('login');

// 会員登録画面表示
Route::get('/register', [RegisterController::class, 'create'])->name('register');

// 会員登録処理
Route::post('/register', [RegisterController::class, 'store']);
