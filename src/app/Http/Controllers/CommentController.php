<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $item)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'item_id' => $item,
            'comment' => $request->comment,
        ]);

        return back();
    }
}
