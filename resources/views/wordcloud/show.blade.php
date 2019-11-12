@extends('layout')

@section('content')
<div class="row">
    <div class="column">
        <h1>{{ $wordcloud->title }}</h1>

        <p>Hier ist die Wortwolke:</p>

        <p class="cloud">
            {!! $cloud->render() !!}
        </p>

        <p>Psst! Wenn du magst, kannst du deine Eingaben noch <a href="{{ route('wordcloud.form', $wordcloud) }}">ändern</a>.</p> 
    </div>
</div>
@endsection