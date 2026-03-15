@extends('layouts.app')
<!-- こちら商品一覧画面のblade -->
@section('content')

@section('css')
<!-- 商品一覧画面用のCSS -->
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

<div class="tabs">
    <a class="tab tab-recommend" href="{{ route('items.index', ['tab' => 'recommend', 'keyword' => request('keyword')]) }}">
        おすすめ
    </a>

    @auth
    <a class="tab tab-mylist" href="{{ route('items.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}">
        マイリスト
    </a>
    @endauth
</div>

<div class="items-list-container">
    @forelse ($items as $item)

    <a href="{{ route('items.show', $item->id) }}" class="item">

        <div class="item-image-wrapper">
            <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" width="150">

            @if ($item->purchase)
            <span class="sold">Sold</span>
            @endif
        </div>

        <p class="item-name">{{ $item->name }}</p>

    </a>
    @empty
    <p>該当する商品がありません。</p>
    @endforelse
</div>
@endsection