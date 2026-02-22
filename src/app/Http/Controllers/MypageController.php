<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        // 出品した商品
        $sellItems = Item::where('user_id', Auth::id())->get();

        // 購入した商品（purchaseテーブルとリレーションしている想定）
        $buyItems = Auth::user()->purchases()->with('item')->get()->pluck('item');

        return view('mypage.index', compact('sellItems', 'buyItems'));
    }
}
