@extends('layouts.app')

@section('content')

<div class="purchase">

    {{-- 商品情報 --}}
    <div class="item-info">
        <img src="{{ $item->image }}" width="150">

        <h2>{{ $item->name }}</h2>

        <p>¥{{ number_format($item->price) }}</p>
    </div>


    {{-- 支払い方法 --}}
    <div class="payment">
        <h3>支払い方法</h3>

        <select name="payment_method">
            <option value="">選択してください</option>
            <option value="convenience">コンビニ払い</option>
            <option value="card">カード払い</option>
        </select>
    </div>


    {{-- 配送先 --}}
    <div class="address">
        <h3>配送先</h3>

        <p>
            〒{{ Auth::user()->postcode }}<br>
            {{ Auth::user()->address }}<br>
            {{ Auth::user()->building }}
        </p>

        <a href="{{ route('purchase.address', $item->id) }}">
            変更する
        </a>
    </div>


    {{-- 購入ボタン --}}
    <div class="purchase-button">
        <button>購入する</button>
    </div>

</div>

@endsection