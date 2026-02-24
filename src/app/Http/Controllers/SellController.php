<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category;

class SellController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('sell.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // ① 画像保存
        $imagePath = $request->file('image')->store('items', 'public');

        // ② 商品作成
        $item = Item::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'brand_name' => $request->brand_name,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        // ③ カテゴリー保存
        $item->categories()->sync($request->categories);

        // ④ 一覧へ戻る
        return redirect()->route('items.index');
    }
}
