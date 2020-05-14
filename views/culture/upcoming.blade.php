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
        <h1 class="uk-article-title">Fragen zur Teamkultur</h1>

        <p>Diese Fragen stellen wir einmal in der Woche Mittwoch um 08:30 Uhr - <a href="">Einstellungen ändern</a>.<br class="uk-visible@s">
            Nur du kannst die privaten Antworten sehen - <a href="">Berechtigungen ändern</a>.

        @forelse ($questions as $question)
        <div class="question prev">
            <?php
            $plan = \Carbon\Carbon::parse($question->planned_at);
            ?>
            <div class="question-date">
                <div>{{ $plan->day }}.</div>
                <div>{{ $plan->locale('de')->monthName }}</div>
            </div>
            <div class="question-body"
                    id="question-{{ $question->id }}" 
                    data-question="{{ json_encode($question) }}">
                <div class="type">{{ $question->printable_type }}</div>
                <p class="text">{{ $question->body }}</p>
                <p class="action">Stelle diese Frage <a href="">als nächstes</a>, 
                    <a href="#" onclick="edit(JSON.parse(document.getElementById('question-{{ $question->id }}').dataset.question))">bearbeite</a> 
                    oder <a href="">lösche</a> sie.</p>
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
<div id="overlay" ok-modal>
    <form id="overlay-text" class="uk-modal-dialog uk-modal-body" onsubmit="save()">
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
<script>
var question_id;

function create() {
    question_id = null;
    document.getElementById("verb").innerHTML = "anlegen";
    document.getElementById("question-name").value = "";
    document.getElementById("question-description").value = "";
    document.getElementById("question-roadmap").value = "---";
    document.getElementById("question-effort").value = "---";
    document.getElementById("question-eisenhower").value = "---";

    UIkit.modal(document.getElementById("overlay")).show();
}

function edit(question) {
    question_id = question.id;
    document.getElementById("verb").innerHTML = "bearbeiten";
    document.getElementById("question-body").value = question.body;
    document.getElementById("question-type").value = question.type;
    document.getElementById("question-min").value = question.min;
    document.getElementById("question-max").value = question.max;

    UIkit.modal(document.getElementById("overlay")).show();
}

function off() {
    UIkit.modal(document.getElementById("overlay")).hide();
}

function item_text(question) {
    return `<div class="type">${question.printable_type}</div>
            <p class="text">${question.body}</p>
            <p class="action">Stelle diese Frage <a href="">als nächstes</a>, 
                <a href="#" onclick="edit(JSON.parse(document.getElementById('question-${question.id}').dataset.question))">bearbeite</a> 
                oder <a href="">lösche</a> sie.</p>`;
}

function save() {
    const data = {
        body: document.getElementById("question-body").value,
        type: document.getElementById("question-type").value,
        min: document.getElementById("question-min").value,
        max: document.getElementById("question-max").value
    };
    const csrf = document.getElementById('overlay-text')._token.value;

    let method, url;
    if (question_id) {
        method = "PUT";
        url = "/culture/" +  question_id;
    }
    else {
        method = "POST";
        url = "/culture/{{ $question->id }}";
    }
    
    fetch(url, {
        method: method, 
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Concent-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Saved:", data);

        const updated = document.getElementsByClassName('updated');
        for (let el of updated) {
            el.classList.remove('updated');
        }

        const item = document.getElementById("question-" + data.question.id);

        if (item) {
            item.dataset.question = JSON.stringify(data.question);
            item.innerHTML = item_text(data.question);

            item.parentElement.classList.add('updated');
            UIkit.notification(`<span uk-icon='icon: check'></span> ${data.message}`, {
                pos: 'top-right',
                status: 'success'
            });
        }
        else {
            const li = document.createElement("LI");
            li.innerHTML = `<div class="float-right">
                    <a href="#" class="icon" onclick="edit(JSON.parse(document.getElementById('question-${data.question.id}').dataset.question))">✎</a>
                </div>
                <span id="question-${data.question.id}" data-question="${JSON.stringify(data.question)}">
                    ${item_text(data.question)}
                </span>`;

            li.classList.add('updated');
            document.getElementById("questions").appendChild(li);
            document.getElementById("empty").style.display = "none";   
        }
        off();
    });
}
</script>
@endsection