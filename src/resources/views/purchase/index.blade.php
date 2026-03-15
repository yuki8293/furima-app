@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection


@section('content')

<div class="purchase-container">

    {{-- 左側 --}}
    <div class="purchase-left">

        {{-- 商品情報 --}}
        <div class="item-info">
            <img src="{{ $item->image }}" class="purchase-item-image">
            <div class="item-text">
                <h2 class="purchase-item-name">{{ $item->name }}</h2>
                <p class="purchase-item-price">¥{{ number_format($item->price) }}</p>
            </div>
        </div>

        {{-- 支払い方法 --}}
        <div class="payment">
            <h3>支払い方法</h3>
            <select name="payment_method" class="payment-select" form="purchase-form">
                <option value="">選択してください</option>
                <option value="convenience">コンビニ払い</option>
                <option value="card">カード払い</option>
            </select>
        </div>

        {{-- 配送先 --}}
        <div class="address">
            <div class="address-header">
                <h3>配送先</h3>
                <a href="{{ route('purchase.address', $item->id) }}" class="address-change-btn">変更する</a>
            </div>
            <p>
                〒{{ Auth::user()->postcode }}<br>
                {{ Auth::user()->address }}<br>
                {{ Auth::user()->building }}
            </p>
        </div>

    </div>

    {{-- 右側 --}}
    <div class="purchase-right">

        <form id="purchase-form" action="{{ route('purchase.complete', $item->id) }}" method="POST">
            @csrf

            <div class="purchase-summary-box">

                <div class="summary-box">
                    <div class="summary-label">商品代金</div>
                    <div class="summary-value">¥{{ number_format($item->price) }}</div>
                </div>

                <div class="summary-box">
                    <div class="summary-label">支払い方法</div>
                    <div class="summary-value">
                        <span id="selected-payment">未選択</span>
                    </div>
                </div>

                <!-- hidden input で配送先情報をフォームに含める -->
                <input type="hidden" name="address" value="〒{{ Auth::user()->postcode }} {{ Auth::user()->address }} {{ Auth::user()->building }}">

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