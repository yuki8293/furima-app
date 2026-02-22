<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function index($item_id)
    {
        $item = Item::findOrFail($item_id);
        return view('purchase.index', compact('item'));
    }

    public function address($item_id)
    {
        // 例えばユーザー情報と商品情報を渡す
        $item = \App\Models\Item::findOrFail($item_id);
        $user = auth()->user();

        return view('purchase.address', compact('item', 'user'));
    }

    public function updateAddress(Request $request, $item_id)
    {
        $user = auth()->user();
        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        // 更新後は購入画面に戻す
        return redirect()->route('purchase.index', $item_id);
    }

    public function complete(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        // 支払い方法を取得
        $paymentMethod = $request->input('payment_method');

        // 購入処理（簡易サンプル）
        // ここで purchase テーブルに登録する想定
        $item->purchase()->create([
            'user_id' => Auth::id(),
            'payment_method' => $paymentMethod,
            'purchased_at' => now(),
        ]);

        // 一覧ページにリダイレクト
        return redirect()->route('items.index')->with('success', '購入が完了しました！');
    }
}
