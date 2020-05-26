@extends('layouts.app')

@section('content')
<div class="uk-container">
    <article class="uk-article uk-margin-top uk-margin-bottom upcoming">

        <ul class="uk-breadcrumb">
            <li><a href="{{ route('culture') }}">Fragen zur Teamkultur</a></li>
            <li><span>{{ Str::limit($question->body, 30) }}</span></li>
        </ul>

        <h1 class="uk-article-title">
            <?php
            $count = $question->answers->count();
            $answers = $count == 1 ? 'einer Antwort' : "{$count} Antworten";
            ?>
            <div class="uk-text-meta">{{ ucfirst($question->human_planned_at) }} gestellte Frage zur Teamkultur mit {{ $answers }}:</div>
            {{ $question->body }}
        </h1>

        <?php
        $stats = $question->stats();
        $total = $question->answers->count();
        ?>
        @if ($question->type != 'text' && $total)
            <table class="uk-table uk-table-small  uk-table-justify uk-table-divider">
            <tbody>
            @foreach ($stats as $row)
                <tr>
                    <td class="uk-table-shrink uk-text-lead">{{ round($row->count / $total * 100) }}%</td>
                    <td><strong>{{ $row->answer }}</strong>
                        <div class="uk-margin-top">
                        @forelse ($row->answers as $answer)
                            <div class="uk-thumbnail uk-float-left uk-margin-right small">
                                <img class="uk-border-circle" src="{{ $answer->gravatar }}">
                                <div class="uk-thumbnail-caption uk-text-muted">{{ $answer->user->name }}</div>
                            </div>
                        @empty
                            <p>Keine Antworten</p>
                        @endforelse 
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
            </table>

            <a class="uk-button uk-button-primary" href="{{ route('answer', $question) }}"><span uk-icon="comment"></span> Antworte auf diese Frage</a>


            <?php
            $text_answers = $question->answers->whereNotNull('text_answer');
            $count = $text_answers->count();
            $title = ($count == 1) ? 'Es gab einen Kommentar' : "Es gab {$count} Kommentare";
            ?>

            @if ($count)
                <h2>{{ $title }}</h2>

                @foreach ($question->answers->whereNotNull('text_answer') as $answer)
                    <article class="uk-comment uk-margin-top">
                        <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>
                            <div class="uk-width-auto">
                                <img class="uk-comment-avatar uk-border-circle" src="{{ $answer->gravatar }}">
                            </div>
                            <div class="uk-width-expand">
                                <h4 class="uk-comment-title uk-margin-remove">{{ $answer->user->name }}</h4>
                                <div class="uk-comment-meta uk-margin-remove-top">Antwortete <strong>{{ $answer->answer }}</strong></div>
                            </div>
                        </header>
                        <div class="uk-comment-body">{{ $answer->text_answer }}</div>
                    </article>
                @endforeach
            @endif
        @else
            <p>Keine Antworten.</p>
        @endif

    </article>
</div>
@endsection