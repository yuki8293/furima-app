<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    // プロフィール編集画面表示(route→GET/mypage/profile)
    public function edit()
    {
        return view('mypage.profile');
    }

    // プロフィール更新処理(route→POST/mypage/profile)
    public function update(ProfileRequest $request)
    {

        $user = auth()->user();
        $validated = $request->validated();

        // ユーザー情報更新
        $user->name = $validated['name'];
        $user->postcode = $validated['postcode'];
        $user->address = $validated['address'];
        $user->building = $validated['building'];

        // アイコン画像があれば保存
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $user->icon = basename($path);
        }

        $user->save();

        //トップ画面に戻る
        return redirect()->route('items.index');
    }
}
