@extends('layouts.app')

@include('mindyourteam::partials.question-styles')

@section('content')
<div class="uk-container">
    <article class="uk-article uk-margin-top uk-margin-bottom">

        <ul class="uk-breadcrumb">
            <li><span>Fragen zur Teamkultur</span></li>
        </ul>

        <h1 class="uk-article-title">Fragen zur Teamkultur</h1>

        <p>Diese Fragen stellen wir einmal in der Woche am Mittwoch um 08:30 Uhr<!-- - <a href="">Einstellungen ändern</a> -->.<br class="uk-visible@s">
            <!-- Nur du kannst die privaten Antworten sehen - <a href="">Berechtigungen ändern</a>. -->

        <div class="question next">
            <?php
            $plan = \Carbon\Carbon::parse($next_question->planned_at);
            ?>
            <div class="question-date">
                <div>{{ $plan->day }}.</div>
                <div>{{ $plan->locale('de')->monthName }}</div>
            </div>
            <div class="question-body">
                <p class="prompt">Die nächste Frage, die wir stellen werden:</p>
                <p class="text">{{ $next_question->body }}</p>
            </div>
            <div class="question-change uk-visible@s">
                <div>
                    <a class="uk-button uk-button-primary" 
                            href="{{ route('culture.upcoming') }}">
                        <span class="uk-margin-small-right uk-icon" uk-icon="settings"></span>
                        Ändere die nächsten Fragen
                    </a>
                </div>
                <div class="uk-text-center uk-margin-small-top">
                    <a href="">Fragen pausieren</a>
                </div>
            </div>
            <div class="question-change uk-margin-right uk-hidden@s">
                <a class="uk-button uk-button-primary uk-icon" uk-icon="settings" 
                    href="{{ route('culture.upcoming') }}"></a>
            </div>
        </div>

        @foreach ($questions as $question)
        <div class="question prev">
            <?php
            $plan = \Carbon\Carbon::parse($question->planned_at);
            ?>
            <div class="question-date">
                <div>{{ $plan->day }}.</div>
                <div>{{ $plan->locale('de')->monthName }}</div>
            </div>
            <div class="question-body">
                <p class="text">{{ $question->body }} <a href="{{ route('culture.show', $question) }}">&hellip;</a></p>
                <div class="answers">
                @forelse ($question->answers as $answer)
                    <img class="uk-border-circle" title="{{ $answer->user->name }}" src="{{ $answer->gravatar }}">
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

@push('toes')
@if (Session::has('success'))
<script>
UIkit.notification("<span uk-icon='icon: check'></span> {{ session('success') }}", {
    pos: 'top-right',
    status: 'success'
});
</script>
@endif
@endpush