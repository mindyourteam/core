@extends('layouts.app')

@include('mindyourteam::partials.question-styles')

@push('head')
<style>
@-webkit-keyframes yellow-fade {
  from {
    background: #89E3C1;
  }
  to {
    background: #fff;
  }
}
@-moz-keyframes yellow-fade {
  from {
    background: #89E3C1;
  }
  to {
    background: #fff;
  }
}
@keyframes yellow-fade {
  from {
    background: #89E3C1;
  }
  to {
    background: #fff;
  }
}
.updated {
  -webkit-animation: yellow-fade 1s ease-in-out 0s;
  -moz-animation: yellow-fade 1s ease-in-out 0s;
  -o-animation: yellow-fade 1s ease-in-out 0s;
  animation: yellow-fade 1s ease-in-out 0s;
}
</style>
@endpush

@section('content')
<div class="uk-container">
    <article class="uk-article uk-margin-top uk-margin-bottom upcoming">

        <ul class="uk-breadcrumb">
            <li><a href="{{ route('culture') }}">Fragen zur Teamkultur</a></li>
            <li><span>Nächste Fragen</span></li>
        </ul>

        <h1 class="uk-article-title">Nächste Fragen</h1>

        <div class="uk-margin-large-bottom">
            <a class="uk-float-right uk-button uk-button-primary" href="#" onclick="create()">
                <span class="uk-margin-small-right uk-icon" uk-icon="plus-circle"></span>
                Neue Frage
            </a>

            <p>Diese Fragen stellen wir einmal in der Woche Mittwoch um 08:30 Uhr.<!-- - <a href="">Einstellungen ändern</a>.<br class="uk-visible@s">
                Nur du kannst die privaten Antworten sehen - <a href="">Berechtigungen ändern</a>. -->
        </div>

        @forelse ($questions as $i => $question)
        <div class="question prev">
            <?php
            $plan = \Carbon\Carbon::parse($question->planned_at);
            $seq = $questions->firstItem() + $i;
            ?>
            <div class="question-date">
                <div>{{ $plan->day }}.</div>
                <div>{{ $plan->locale('de')->monthName }}</div>
            </div>
            <div class="question-body"
                    id="question-{{ $question->id }}" 
                    data-question="{{ json_encode($question) }}"
                    data-seq="{{ $seq }}">
                <div class="type">{{ $question->printable_type }}</div>
                <p class="text">{{ $question->body }}</p>
                <p class="action">
                @if ($seq == 1)
                    <a href="#" onclick="edit(JSON.parse(document.getElementById('question-{{ $question->id }}').dataset.question))">Bearbeite</a> 
                    diese Frage oder <a href="#" onclick="del({{ $question->id }})">lösche</a> sie.
                @else
                    Stelle diese Frage <a href="#" onclick="next({{ $question->id }})">als nächstes</a>,
                    <a href="#" onclick="edit(JSON.parse(document.getElementById('question-{{ $question->id }}').dataset.question))">bearbeite</a> 
                    oder <a href="#" onclick="del({{ $question->id }})">lösche</a> sie.
                @endif
                </p>
            </div>
        </div>
        @empty
        <div class="question prev">
            <p id="empty">- Keine Fragen -</p>
        </div>
        @endforelse

        {{ $questions->links() }}
    </article>
</div>
@endsection

@section('footer')
<div id="overlay" uk-modal>
    <form id="overlay-text" class="uk-modal-dialog uk-modal-body" onsubmit="save(event)">
        @csrf
        <h2>Frage <span id="verb"></span></h2>
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <fieldset class="uk-fieldset uk-grid-small" uk-grid>
            <div class="uk-width-1-1">
                <label for="question-body" class="uk-form-label">Frage</label>
                <textarea id="question-body" class="uk-textarea"></textarea>
            </div>
            <div class="uk-width-1-1">
                <label for="question-type" class="uk-form-label">Typ</label>
                <select id="question-type" class="uk-select">
                    <option>---</option>
                    <option value="yesno">Ja/Nein</option>
                    <option value="1to5">Wertung (1..5)</option>
                    <option value="1to10">Punkte (1..10)</option>
                    <option value="text">Freitext</option>
                </select>
            </div>
            <div class="uk-width-1-2@s">
                <label for="question-min" class="uk-form-label">Text für den kleinsten Wert</label>
                <input id="question-min" type="text" class="uk-input">
            </div>
            <div class="uk-width-1-2@s">
                <label for="question-max" class="uk-form-label">Text für den größten Wert</label>
                <input id="question-max" type="text" class="uk-input">
            </div>
            <div class="uk-width-1-1">
                <input class="uk-button uk-button-primary uk-margin-top" type="submit" value="Speichern">
            </div>
        </fieldset>
    </form>
</div>
<script src="/vendor/mindyourteam/upcoming.js"></script>
@endsection