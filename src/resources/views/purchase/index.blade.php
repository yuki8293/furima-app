@extends('layouts.app')

@section('content')

<h2>購入画面</h2>

<p>{{ $item->name }}</p>
<p>¥{{ $item->price }}</p>

@endsection
