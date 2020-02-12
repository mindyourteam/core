@extends('layout')

@section('content')
<div class="row">
    <div class="column">
        <h1>::PDP:: Werkzeuge</h1>

        <p>Du bis angemeldet als <strong>{{ $user->name }}</strong> (<a href="{{ route('logout') }}">abmelden</a>).</p>

        <p>Was möchtest du tun?</p>

        <ul>
            <li><a href="{{ route('wordcloud.form', ['wordcloud' => 1]) }}">Gemeinsam eine Wortwolke erstellen</a> (<a href="https://confluence.dw.com/pages/viewpage.action?pageId=170739810">Anleitung in Confluence</a>)</li>

            <li><a href="{{ route('product', ['productplan' => 1]) }}">Produktplanung 2020</a> (<a href="https://confluence.dw.com/display/~SchettlerO/Produktplanung+2020">Ergebnis &amp; Anleitung in Confluence</a>)</li>
        </ul>
    </div>
</div>
@endsection