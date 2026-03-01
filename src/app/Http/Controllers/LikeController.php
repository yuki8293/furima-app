<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Item $item)
    {
        $like = $item->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
        } else {
            $item->likes()->create([
                'user_id' => Auth::id(),
            ]);
        }

        return back();
    }
}
