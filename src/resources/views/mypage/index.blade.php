@extends('layouts.app')
<!-- ここはマイページ・プロフィール画面のblade -->
@section('content')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

<!-- 全体レイアウト用クラス名 -->
<div class="mypage-container">

    <!-- ユーザー情報 -->
    <div class="mypage-user-info">

        <!-- アイコンがあればその画像を使う。なければデフォルト画像を使うという意味 -->
        <!-- Auth::user()->icon ? A : Bは三項演算子条件 ? trueのとき : falseのとき -->
        <img
            src="{{ Auth::user()->icon 
        ? asset('storage/icons/' . Auth::user()->icon) 
        : asset('images/default-avatar.png') 
    }}"
            alt="アイコン"
            class="mypage-user-icon">
        <h2 class="mypage-user-name">{{ Auth::user()->name }}</h2>
        <a href="{{ route('mypage.profile') }}" class="mypage-edit-btn">プロフィールを編集</a>
    </div>

    <!-- タブ切り替え -->
    <div class="mypage-tabs">
        <a href="{{ route('mypage') }}?tab=sell" class="mypage-tab {{ request('tab') == 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ route('mypage') }}?tab=buy" class="mypage-tab {{ request('tab') == 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>

    <!-- 商品一覧 -->
    <div class="mypage-items">
        @php
        $tab = request('tab') ?? 'buy'; // デフォルトは購入タブ
        @endphp

        @if($tab === 'sell')
        @forelse ($sellItems as $item)
        <div class="mypage-item">
            <a href="{{ route('items.show', $item->id) }}">
                <img src="{{ $item->image }}" alt="{{ $item->name }}" class="mypage-item-image">
                <p class="mypage-item-name">{{ $item->name }}</p>
                <p class="mypage-item-price">¥{{ number_format($item->price) }}</p>
                @if ($item->purchase)
                <span class="sold">Sold</span>
                @endif
            </a>
        </div>
        @empty
        <p>出品した商品はありません。</p>
        @endforelse
        @elseif($tab === 'buy')
        @forelse ($buyItems as $item)
        <div class="mypage-item">
            <a href="{{ route('items.show', $item->id) }}">
                <img src="{{ $item->image }}" alt="{{ $item->name }}" class="mypage-item-image">
                <p class="mypage-item-name">{{ $item->name }}</p>
                <p class="mypage-item-price">¥{{ number_format($item->price) }}</p>
            </a>
        </div>
        @empty
        <p>購入した商品はありません。</p>
        @endforelse
        @endif
    </div>

</div>

@endsection