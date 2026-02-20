@extends('layouts.app')

@section('content')
<h2>マイリスト</h2>

@forelse ($likes as $like)
<div>
    {{ $like->item->name }}

    @if ($like->item->purchase)
    <span>Sold</span>
    @endif
</div>
@empty
<p>該当する商品がありません。</p>
@endforelse

@endsection