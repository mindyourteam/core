@extends('layout')

@section('content')
<div class="row">
    <div class="column">
        <h1>{{ $wordcloud->title }}</h1>

        <p>Du bis angemeldet als <strong>{{ $user->name }}</strong> (<a href="{{ route('logout') }}">abmelden</a>).</p>

        {!! $wordcloud->instructions !!}

        <form method="POST" action="{{ route('wordcloud.contribute', $wordcloud) }}">
            @csrf
            <fieldset>
                @foreach (range(1, 5) as $i)
                    <label for="word{{ $i }}">Wort {{ $i }}</label>
                    <input name="word[]" type="text" value="{{ count($words) >= $i ? $words[$i-1]->name : '' }}">
                @endforeach
                <button class="button-primary" type="submit">Speichern</button>
            </fieldset>
        </form>

    </div>
</div>
@endsection