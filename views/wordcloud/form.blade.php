@extends('layouts.app')

@section('content')
<div class="uk-container">
    <article class="uk-article uk-margin-top uk-margin-bottom">
        <h1 class="uk-article-title">{{ $wordcloud->title }}</h1>

        <blockquote>Eine Anleitung zu dieser Funktion findest du <a
            href="https://confluence.dw.com/pages/viewpage.action?pageId=170739810">in Confluence</a>.</blockquote>

        {!! $wordcloud->instructions !!}

        <form method="POST" action="{{ route('wordcloud.contribute', $wordcloud) }}">
            @csrf
            @foreach (range(1, 5) as $i)
                <label for="word{{ $i }}">Wort {{ $i }}</label>
                <input class="uk-input" name="word[]" type="text" value="{{ count($words) >= $i ? $words[$i-1]->name : '' }}">
            @endforeach
            <button class="uk-button uk-button-primary uk-margin-top" type="submit">Speichern</button>
        </form>

    </article>
</div>
@endsection