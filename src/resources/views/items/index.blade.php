@extends('layouts.app')

@section('content')
<h2>商品一覧</h2>

@foreach ($items as $item)
<div>
    <img src="{{ $item->image }}" width="150">

    <p>{{ $item->name }}</p>

    @if ($item->purchase)
    <span style="color:red;">Sold</span>
    @endif
</div>
@endforeach

@endsection