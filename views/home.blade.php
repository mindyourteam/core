@extends('layouts.app')

@section('content')
<div class="uk-container">
    <article class="uk-article uk-margin-top uk-margin-bottom">
        <h1 class="uk-article-title">::AppDev:: Werkzeuge</h1>

        <p>Was möchtest du tun? Bitte wähle eine Funktion über das Hamburgermenü oben links aus.</p>

        @if (config('mindyourteam.feature.product-planning', true))
            <h2>Produktplanung publizieren</h2>
            <p>Veröffentlichen der Eingangsdaten von &amp; nach Confluence.</p>
            <form method="POST" action="{{ route('plan.publish') }}">
                @csrf
                <label for="source">ID der <a target="confluence" href="https://confluence.dw.com/display/~SchettlerO/Produktplanung+2020+-+Quelldaten">Quellseite</a></label>
                <input class="uk-input" type="text" name="source" value="178868289">
                <label for="source">ID der <a target="confluence" href="https://confluence.dw.com/display/~SchettlerO/Produktplanung+2020?src=breadcrumbs-parent">Zielseite</a></label>
                <input class="uk-input" type="text" name="target" value="178865764">
                <button type="submit">Veröffentlichen</button>
            </form>
        @endif
    </article>
</div>
@endsection
