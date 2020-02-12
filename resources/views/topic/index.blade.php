@extends('layout')

@section('content')
<div class="row">
    <div class="column">

        <p><a href="{{ route('product', ['productplan' => $product->productplan_id]) }}">&laquo; zurück</a></p>

        <h1>Themen in {{ $product->name }}</h1>

        @forelse ($topics as $topic)
        <ul>
            <li>{{ $topic->name }}</a></li>
        </ul>
        @empty
            <p>- Keine Themen -</p>
        @endforelse
    </div>
</div>
@endsection