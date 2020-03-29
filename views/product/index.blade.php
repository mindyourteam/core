@extends('layouts.app')

@section('content')
<div class="uk-container">
    <article class="uk-article uk-margin-top uk-margin-bottom">
        <h1 class="uk-article-title">Produkte in {{ $productplan->name }}</h1>

        <blockquote>Die aus deinen Eingaben erzeugte Seite und eine Anleitung findest du <a
            href="https://confluence.dw.com/display/~SchettlerO/Produktplanung+2020">
            in Confluence</a>.</blockquote>

        @foreach ($products as $product)
        <ul>
            <li><a href="{{ route('topic', ['product' => $product]) }}">{{ $product->name }}</a></li>
        </ul>
        @endforeach
    </article>
</div>
@endsection