@extends('layouts.app')

@section('content')

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

<div class="items">
    @forelse ($items as $item)

    <a href="{{ route('items.show', $item->id) }}" class="item">
        <img src="{{ $item->image }}" width="150">

        <p class="item-name">{{ $item->name }}</p>

        @if ($item->purchase)
        <span class="sold">Sold</span>
        @endif
    </a>
    @empty
    <p>該当する商品がありません。</p>
    @endforelse
</div>
@endsection