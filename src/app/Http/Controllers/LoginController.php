<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'email' => ['ログイン情報が登録されていません'],
        ]);
    }
}
