@extends('layouts.app')

@push('head')
<style>
.question {
    width: 100%;
    padding: 20px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: stretch;
}
.question.prev {
    border: solid 1px #ddd;
    border-radius: 4px;
}
.question-date {
    width: 4em;
    border-right: solid 1px #ddd;
    padding-right: 20px;
}
.question-date div {
    text-align: right;
    font-weight: bold;
}
.question-body {
    flex: 4;
    padding-left: 20px;
}
.question-body .prompt {
    margin-bottom: 0px;
}
.question-body .text {
    margin-top: 0px;
}
.question.next .question-body .text {
    font-weight: bold;
    font-size: 1.2em;
}
.answers p {
    font-size: 0.9em;
    color: #888;
}
</style>
@endpush

@section('content')
<div class="uk-container">
    <article class="uk-article uk-margin-top uk-margin-bottom">
        <h1 class="uk-article-title">Fragen zur Teamkultur</h1>

        <p>Diese Fragen stellen wir einmal in der Woche Mittwoch um 08:30 Uhr - <a href="">Einstellungen ändern</a><br>
            Nur du kannst die privaten Antworten sehen - <a href="">Berechtigungen ändern</a> 

        <div class="question next">
            <?php
            $plan = \Carbon\Carbon::parse($next_question->planned_at);
            ?>
            <div class="question-date">
                <div>{{ $plan->day }}</div>
                <div>{{ $plan->locale('de')->monthName }}</div>
            </div>
            <div class="question-body">
                <p class="prompt">Die nächste Frage, die wir stellen werden:</p>
                <p class="text">{{ $next_question->body }}</p>
            </div>
            <div class="question-change uk-visible@s">
                <div>
                    <button class="uk-button uk-button-primary">
                        <span class="uk-margin-small-right uk-icon" uk-icon="settings"></span>
                        Ändere die nächsten Fragen
                    </button>
                </div>
                <div class="uk-text-center uk-margin-small-top">
                    <a href="">Fragen pausieren</a>
                </div>
            </div>
            <div class="question-change uk-margin-right uk-hidden@s">
                <button class="uk-button uk-button-primary uk-icon" uk-icon="settings"></button>
            </div>
        </div>

        @foreach ($questions as $question)
        <div class="question prev">
            <?php
            $plan = \Carbon\Carbon::parse($question->planned_at);
            ?>
            <div class="question-date">
                <div>{{ $plan->day }}</div>
                <div>{{ $plan->locale('de')->monthName }}</div>
            </div>
            <div class="question-body">
                <p class="text">{{ $question->body }}</p>
                <div class="answers">
                @forelse ($question->answers as $answer)
                    <span>{{ $answer->user->name }}</span>
                @empty
                    <p>Keine Antworten</p>
                @endforelse 
                </div>
            </div>
        </div>
        @endforeach

        {{ $questions->links() }}
    </article>
</div>
@endsection