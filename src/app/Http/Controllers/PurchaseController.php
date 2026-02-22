<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

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
}
