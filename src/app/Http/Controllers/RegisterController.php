<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // 会員登録画面を表示
    public function create()
    {
        return view('auth.register'); // Bladeの登録フォーム
    }

    // 登録処理
    public function store(RegisterRequest $request)
    {
        // バリデーション済みのデータ取得
        $validated = $request->validated();

        // ユーザー作成
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 作成後にログイン
        Auth::login($user);

        // マイページにリダイレクト
        return redirect()->route('mypage');
    }
}
