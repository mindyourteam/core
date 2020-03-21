@extends('layouts.app')

@section('content')
<div class="uk-container">
    <article class="uk-article uk-margin-top uk-margin-bottom">
        <h1 class="uk-article-title">{{ $wordcloud->title }}</h1>

        <p>Hier ist die Wortwolke:</p>

        <div class="uk-card uk-card-default uk-card-body cloud">
            {!! $cloud->render() !!}
        </div>

        <p>Und hier sind die einzelnen Rollen:</p>

        <table class="uk-table uk-table-divider">
            <thead>
                <tr><td>#</td><th>Wort</th><th>Anzahl</th><th>Nutzer</th></tr>
            </thead>
            <tbody>
            @foreach ($sorted as $i => $word)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $word->name }}</td>
                    <td>{{ $word->users_count }}</td>
                    <td>{{ $word->users->map(function ($user) { return $user->name; })->join(', ') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <p>Psst! Wenn du magst, kannst du deine Eingaben noch <a href="{{ route('wordcloud.form', $wordcloud) }}">ändern</a>.</p> 
    </article>
</div>
@endsection