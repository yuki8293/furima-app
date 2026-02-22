@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <h2 class="profile-title">プロフィール設定</h2>

    <form method="POST" action="{{ route('mypage.profile.update') }}" class="profile-form" enctype="multipart/form-data">
        @csrf

        {{-- アイコン画像表示とアップロードボタン --}}
        <div class="profile-avatar-section">
            <img class="profile-avatar" src="{{ auth()->user()->icon ?? asset('images/default-avatar.png') }}" alt="">
            <input type="file" name="icon" class="profile-avatar-input">
        </div>

        <div class="form-group">
            <label class="form-label" for="name">ユーザー名</label>
            <input class="form-input" type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}">

            <div class="form__error"> @error('name') {{ $message }} @enderror </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="postcode">郵便番号</label>
            <input class="form-input" type="text" id="postcode" name="postcode" value="{{ old('postcode', auth()->user()->postcode) }}">

            <div class="form__error"> @error('postcode') {{ $message }} @enderror </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="address">住所</label>
            <input class="form-input" type="text" id="address" name="address" value="{{ old('address', auth()->user()->address) }}">

            <div class="form__error"> @error('address') {{ $message }} @enderror </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="building">建物名</label>
            <input class="form-input" type="text" id="building" name="building" value="{{ old('building', auth()->user()->building) }}">

            <div class="form__error"> @error('building') {{ $message }} @enderror </div>
        </div>

        <button type="submit" class="btn btn-submit">更新する</button>
    </form>
</div>
@endsection