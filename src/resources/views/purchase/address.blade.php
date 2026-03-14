@extends('layouts.app')

<!-- 送付先住所変更画面のBladeファイル -->

@section('css')
<link rel="stylesheet" href="{{ asset('css/address-change.css') }}">
@endsection

@section('content')
<div class="address-change-container">

    <h2 class="address-change-title">住所の変更</h2>

    <!-- フォーム1つ、ルート2つで正しく動作 -->
    <form action="{{ route('purchase.address.update', $item->id) }}" method="POST" class="address-change-form">
        @csrf
        <div class="address-change-field">
            <label for="postcode" class="address-change-label">郵便番号</label>
            <input type="text" id="postcode" name="postcode" value="{{ $user->postcode }}" class="address-change-input">
        </div>

        <div class="address-change-field">
            <label for="address" class="address-change-label">住所</label>
            <input type="text" id="address" name="address" value="{{ $user->address }}" class="address-change-input">
        </div>

        <div class="address-change-field">
            <label for="building" class="address-change-label">建物名</label>
            <input type="text" id="building" name="building" value="{{ $user->building }}" class="address-change-input">
        </div>

        <div class="address-change-action">
            <button type="submit" class="address-change-submit-btn">更新する</button>
        </div>

    </form>
</div>
@endsection