@extends('mindyourteam::layout')

@section('content')
<div class="row">
    <div class="column">
        <h1>::PDP:: Werkzeuge</h1>

        <p>Du bis angemeldet als <strong>{{ $user->name }}</strong> (<a href="{{ route('logout') }}">abmelden</a>).
        Was möchtest du tun?</p>

        <h2>Weitere Funktionen</h2>
        <ul>
            <li><a href="{{ route('wordcloud.form', ['wordcloud' => 1]) }}">
                Gemeinsam eine Wortwolke erstellen</a>
                (<a href="https://confluence.dw.com/pages/viewpage.action?pageId=170739810">
                    Anleitung in Confluence</a>)</li>
            <!--li><a href="{{ route('product', ['productplan' => 1]) }}">
                Produktplanung 2020</a> 
                (<a href="https://confluence.dw.com/display/~SchettlerO/Produktplanung+2020">
                    Ergebnis &amp; Anleitung in Confluence</a>)</li-->
        </ul>
        <h2>Produktplanung publizieren</h2>
        <p>Veröffentlichen der Eingangsdaten von &amp; nach Confluence.</p>
        <form method="POST" action="{{ route('plan.publish') }}">
            @csrf
            <label for="source">ID der <a target="confluence" href="https://confluence.dw.com/display/~SchettlerO/Produktplanung+2020+-+Quelldaten">Quellseite</a></label>
            <input type="text" name="source" value="178868289">
            <label for="source">ID der <a target="confluence" href="https://confluence.dw.com/display/~SchettlerO/Produktplanung+2020?src=breadcrumbs-parent">Zielseite</a></label>
            <input type="text" name="target" value="178865764">
            <button type="submit">Veröffentlichen</button>
        </form>
    </div>
</div>
@endsection