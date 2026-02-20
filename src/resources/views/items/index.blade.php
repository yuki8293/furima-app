@extends('layouts.app')

@section('content')

<div>
    <a href="{{ route('items.index', ['tab' => 'recommend', 'keyword' => request('keyword')]) }}">
        おすすめ
    </a>

    @auth
    <a href="{{ route('items.index', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}">
        マイリスト
    </a>
    @endauth
</div>

@forelse ($items as $item)
<div>
    <img src="{{ $item->image }}" width="150">

    <p>{{ $item->name }}</p>

    @if ($item->purchase)
    <span style="color:red;">Sold</span>
    @endif
</div>
@empty
<p>該当する商品がありません。</p>
@endforelse

@endsection