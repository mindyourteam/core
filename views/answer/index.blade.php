@extends('layouts.app')

@section('content')
<div class="uk-container">
    <article class="uk-article uk-margin-top uk-margin-bottom">

        <ul class="uk-breadcrumb">
            <li><a href="{{ route('culture') }}">Fragen zur Teamkultur</a></li>
            <li><span>Antworten</span></li>
        </ul>

        <h1 class="uk-article-title">{{ $question->body }}</h1>

        @if ($my_answer)
            <p class="uk-text-meta">Du hast diese Frage am {{ (new \Carbon\Carbon($my_answer->created_at))->toDateString() }} beantwortet.</p>
        @endif

        <form method="POST" action="{{ route('answer.store') }}">
            @csrf
            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <fieldset class="uk-fieldset uk-grid-small" uk-grid>
                @include('mindyourteam::partials.answer-' . $question->type)
                <div class="uk-width-1-1">
                    <input class="uk-button uk-button-primary uk-margin-top" type="submit" value="Speichern">
                </div>
            </fieldset>
        </form>

    </article>
</div>
@endsection