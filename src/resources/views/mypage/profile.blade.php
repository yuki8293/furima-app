@extends('layouts.app')
<!-- これはプロフィール編集画面のビューファイル -->

@section('css')
<!-- プロフィール編集画面用のCSS -->
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <!-- タイトル -->
    <h2 class="profile-title">プロフィール設定</h2>

    <!-- プロフィール編集フォーム -->
    <form method="POST" action="{{ route('mypage.profile.update') }}" class="profile-form" enctype="multipart/form-data">
        @csrf

        <!-- auth()->user() → ログイン中のユーザー情報を取得する -->
        <!-- アイコン画像を表示＆変更 -->
        <div class="profile-avatar-section">
            <img id="avatar-preview" class="profile-avatar" src="{{ auth()->user()->icon ? asset('storage/icons/' . auth()->user()->icon) : asset('images/default-avatar.png') }}" alt="">

            <!-- 見た目のボタン -->
            <label for="avatar-input" class="select-image-btn">
                画像を選択する
            </label>

            <!-- 本当のファイル選択ボタンinput -->
            <input id="avatar-input" type="file" name="icon" class="profile-avatar-input">
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

<script>
    const avatarInput = document.getElementById('avatar-input');
    const avatarPreview = document.getElementById('avatar-preview');

    avatarInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.src = e.target.result; // プレビュー更新
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection