@extends('layouts.app')
<!-- 商品出品画面のblade -->
@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="item-form-container">

    <h2 class="sell-title">商品の出品</h2>

    <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data" class="sell-form">
        @csrf

        {{-- 商品画像 --}}
        <div class="sell-section">
            <h3 class="sell-section-title">商品画像</h3>

            <div class="sell-image-upload">
                <input type="file" name="image" class="sell-image-input">

                <!-- プレビュー表示用 -->
                <img id="preview" style="max-width:200px; margin-top:10px; display:none;">
            </div>
        </div>


        {{-- 商品の詳細 --}}
        <div class="sell-section">
            <h3 class="sell-section-title">商品の詳細</h3>

            <div class="sell-form-group">
                <label>カテゴリー</label>

                <div class="category-group">
                    @foreach ($categories as $category)
                    <label class="category-item">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                        <span>{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>

            </div>

            <div class="sell-form-group">
                <label>商品の状態</label>
                <select name="status" class="sell-select">
                    <option value="">選択してください</option>
                    <option value="new">良好</option>
                    <option value="good">目立った傷や汚れなし</option>
                    <option value="used">やや傷や汚れあり</option>
                    <option value="bad">状態が悪い</option>
                </select>
            </div>
        </div>


        {{-- 商品名と説明 --}}
        <div class="sell-section">
            <h3 class="sell-section-title">商品名と説明</h3>

            <div class="sell-form-group">
                <label>商品名</label>
                <input type="text" name="name" class="sell-input">
            </div>

            <div class="sell-form-group">
                <label>ブランド名</label>
                <input type="text" name="brand_name" class="sell-input">
            </div>

            <div class="sell-form-group">
                <label>商品の説明</label>
                <textarea name="description" class="sell-textarea"></textarea>
            </div>

            <div class="sell-form-group">
                <label>販売価格</label>
                <input type="number" name="price" class="sell-input">
            </div>
        </div>


        {{-- 出品ボタン --}}
        <div class="sell-submit">
            <button type="submit" class="sell-button">出品する</button>
        </div>

    </form>

</div>

<script>
    document.querySelector('input[name="image"]').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = function(event) {
            const preview = document.getElementById('preview');
            preview.src = event.target.result;
            preview.style.display = 'block';
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection