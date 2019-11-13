@extends('layout')

@section('content')
<div class="row">
    <div class="column">
        <h1>{{ $wordcloud->title }}</h1>

        <p>Hier ist die Wortwolke:</p>

        <p class="cloud">
            {!! $cloud->render() !!}
        </p>

        <table>
            <thead>
                <tr><th>Wort</th><th>Anzahl</th></tr>
            </thead>
            <tbody>
            @foreach ($sorted as $word)
                <tr>
                    <td>{{ $word->word }}</td>
                    <td>{{ $word->count }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <p>Psst! Wenn du magst, kannst du deine Eingaben noch <a href="{{ route('wordcloud.form', $wordcloud) }}">ändern</a>.</p> 
    </div>
</div>
@endsection