<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->likes()->with('item.purchase');

        // 🔥 検索対応
        if ($request->filled('keyword')) {
            $query->whereHas('item', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%');
            });
        }

        $likes = $query->get();

        return view('mypage.index', compact('likes'));
    }
}
