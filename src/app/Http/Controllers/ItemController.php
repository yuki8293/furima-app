<?php
// 詳細画面のコントローラ
// bladeはshow.blade.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // 商品一覧ページを表示
    public function index(Request $request)
    {
        // 今どのタブが選ばれているか取得
        $tab = $request->input('tab', 'recommend');
        // 検索キーワードを取得
        $keyword = $request->keyword;

        // まず空のクエリを用意
        $query = Item::query();

        // 「マイリスト」タブが押された場合
        if ($tab === 'mylist') {

            // 未ログインの場合は商品を表示しない
            if (!Auth::check()) {
                return view('items.index', ['items' => collect()]);
            }

            // ログインしている場合のみいいね商品を取得
            $query->whereHas('likes', function ($q) {
                $q->where('user_id', Auth::id());
            });
        } else {
            // おすすめタグ ログインしている時は自分が出品した商品を除外
            if (Auth::check()) {
                $query->where('user_id', '!=', Auth::id());
            }
        }

        // 検索キーワードが入力されている時
        if ($request->filled('keyword')) {
            // 商品名にキーワードが含まれている商品だけ取得
            $query->where('name', 'like', "%{$keyword}%");
        }
        // 商品データを取得
        // purchaseも一緒に取得（購入済みか判定
        $items = $query->with('purchase')->get();

        return view('items.index', compact('items'));
    }
    // 商品一覧ページにデータを渡して表示

    // 商品詳細ページを表示
    public function show($item_id)
    {
        // URLで渡されたIDの商品を取得
        // 商品が存在しない場合は404エラー
        // withを使ってN+1問題を防ぐ
        $item = Item::with(['categories', 'comments.user', 'likes', 'user'])
            ->findOrFail($item_id);

        // 商品データを詳細ページに渡す
        return view('items.show', compact('item'));
    }
}
