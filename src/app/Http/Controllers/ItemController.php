<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'recommend');
        $keyword = $request->keyword;

        // まず空のクエリを用意
        $query = Item::query();

        if ($tab === 'mylist') {

            // 🔴 未ログインなら空を返す（ここが追加ポイント）
            if (!Auth::check()) {
                return view('items.index', ['items' => collect()]);
            }

            // ログインしている場合のみいいね商品を取得
            $query->whereHas('likes', function ($q) {
                $q->where('user_id', Auth::id());
            });
        } else {

            if (Auth::check()) {
                $query->where('user_id', '!=', Auth::id());
            }
        }

        // 🔍 検索は共通でかける
        if ($request->filled('keyword')) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        $items = $query->with('purchase')->get();

        return view('items.index', compact('items'));
    }

    public function show($item_id)
    {

        $item = Item::findOrFail($item_id);
        return view('items.show', compact('item'));
    }
}
