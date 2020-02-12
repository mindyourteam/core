@extends('layout')

@section('content')
<div class="row">
    <div class="column">
        <h1>Produkte in {{ $productplan->name }}</h1>

        @foreach ($products as $product)
        <ul>
            <li><a href="{{ route('topic', ['product' => $product]) }}">{{ $product->name }}</a></li>
        </ul>
        @endforeach
    </div>
</div>
@endsection