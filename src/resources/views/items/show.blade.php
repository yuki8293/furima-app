@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')

<div class="item-detail-container">

    <!-- 左：商品画像 -->
    <div class="item-detail-left">
        @if (Str::startsWith($item->image, 'http'))
        <img src="{{ $item->image }}" alt="{{ $item->name }}">
        @else
        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
        @endif
    </div>

    <!-- 右：商品情報 -->
    <div class="item-detail-right">

        <h2 class="item-name">{{ $item->name }}</h2>

        @if($item->brand_name)
        <p class="item-brand">{{ $item->brand_name }}</p>
        @endif

        <p class="item-price">¥{{ number_format($item->price) }} (税込)</p>

        <!-- いいね・コメント -->
        <div class="item-likes-comments">
            <form action="{{ route('items.like', $item->id) }}" method="POST">
                @csrf
                <button type="submit" class="like-button">
                    ♡ {{ $item->likes->count() }}
                </button>
            </form>

            <a href="#comments" class="comments">
                💭 {{ $item->comments->count() }}
            </a>
        </div>

        <!-- 購入 -->
        @if(!$item->purchase)
        <a href="{{ route('purchase.index', $item->id) }}" class="buy-button">
            購入手続きへ
        </a>
        @else
        <p class="sold">Sold</p>
        @endif

        <!-- 商品説明 -->
        <p class="item-description">
            {{ $item->description }}
        </p>

        <!-- 商品情報 -->
        <div class="item-info">
            <h3>商品情報</h3>

            <p>カテゴリー:
                @foreach($item->categories as $category)
                <span class="category">{{ $category->name }}</span>
                @endforeach
            </p>

            <p>商品の状態: {{ $item->status }}</p>
        </div>

        <!-- コメント -->
        <div class="item-comments" id="comments">
            <h3>コメント({{ $item->comments->count() }})</h3>
            <!-- 出品者 -->
            <div class="item-seller">
                <img
                    src="{{ $item->user->icon ? asset('storage/icons/' . $item->user->icon) : asset('images/default-avatar.png') }}"
                    class="seller-icon"
                    alt="出品者アイコン">
                <span class="seller-name">{{ $item->user->name }}</span>
            </div>
            
            @forelse($item->comments as $comment)

            <div class="comment">
                <img src="{{ $comment->user->icon ?? asset('images/default-avatar.png') }}" class="comment-icon">
                <span class="comment-user">{{ $comment->user->name }}</span>
                <p class="comment-text">{{ $comment->comment }}</p>
            </div>

            @empty
            <p>コメントはまだありません。</p>

            @endforelse
        </div>

        <!-- コメントフォーム -->
        <div class="comment-form">
            <label for="comment">商品へのコメント</label>

            <textarea
                id="comment"
                name="comment"
                rows="3"
                placeholder="コメントを入力してください">
            </textarea>

            <button class="submit-comment">
                コメントを送信する
            </button>
        </div>

    </div>

</div>

@endsection