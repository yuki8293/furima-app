@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">

@section('content')

<div class="purchase-page">

    {{-- 左側：商品情報＋配送先＋支払い選択 --}}
    <div class="purchase-left">

        {{-- 商品情報 --}}
        <div class="item-info">
            <img src="{{ $item->image }}" class="purchase-item-image">
            <h2 class="purchase-item-name">{{ $item->name }}</h2>
            <p class="purchase-item-price">¥{{ number_format($item->price) }}</p>
        </div>

        {{-- 支払い方法選択（左側でも確認用） --}}
        <div class="payment">
            <h3>支払い方法</h3>
            <select name="payment_method" class="payment-select">
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
            <a href="{{ route('purchase.address', $item->id) }}" class="address-change-btn">変更する</a>
        </div>

    </div>

    {{-- 右側：購入ボックス（商品代金・支払い方法・購入ボタン） --}}
    <div class="purchase-right">

        <form id="purchase-form" action="{{ route('purchase.complete', $item->id) }}" method="POST">
            @csrf

            <div class="purchase-summary-box">

                {{-- 商品代金 --}}
                <div class="summary-box">
                    <div class="summary-label">商品代金</div>
                    <div class="summary-value">¥{{ number_format($item->price) }}</div>
                </div>

                {{-- 支払い方法 --}}
                <div class="summary-box">
                    <div class="summary-label">支払い方法</div>
                    <div class="summary-value">
                        <span id="selected-payment">未選択</span>
                    </div>
                </div>

                {{-- 購入ボタン --}}
                <div class="purchase-btn-wrapper">
                    <button type="submit" class="purchase-btn">購入する</button>
                </div>

            </div>
        </form>
    </div>

</div>
<script>
    const paymentSelect = document.querySelector('.payment-select');
    const selectedPayment = document.getElementById('selected-payment');

    paymentSelect.addEventListener('change', function() {
        let value = paymentSelect.value;
        if (value === 'convenience') value = 'コンビニ払い';
        if (value === 'card') value = 'カード払い';
        selectedPayment.textContent = value || '未選択';
    });
</script>

@endsection