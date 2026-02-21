@extends('layouts.app')

@section('content')
<div class="item-detail">

    <div class="item-image">
        <img src="{{ $item->image }}" width="300">
    </div>

    <div class="item-detail__info">

        <h2 class="item-detail__name">
            {{ $item->name }}
        </h2>

        <p class="item-detail__brand">
            {{ $item->brand_name }}
        </p>

        <p class="item-detail__price">
            ¥{{ number_format($item->price) }}
        </p>

        <p class="item-detail__description">
            {{ $item->description }}
        </p>

        {{-- 購入済み表示 --}}
        @if ($item->purchase)
        <p class="sold">Sold</p>
        @else
        <a href="{{ route('purchase.index', $item->id) }}" class="buy-button">
            購入手続きへ
        </a>
        @endif

    </div>

</div>
@endsection