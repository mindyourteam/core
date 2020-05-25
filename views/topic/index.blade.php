@extends('layouts.app')

@section('content')
<div class="uk-container">
    <article class="uk-article uk-margin-top uk-margin-bottom">
        <p><a href="{{ route('product', ['productplan' => $product->productplan_id]) }}">&laquo; zurück</a></p>

        <div class="float-right">
            <a href="#" class="icon" onclick="create()">+</a>
        </div>
        <h1 class="uk-article-title">Themen in {{ $product->name }}</h1>

        @forelse ($epics as $epic)
        <ul id="epics">
            <li>
                <div class="float-right">
                    <a href="#" class="icon" onclick="edit(JSON.parse(document.getElementById('epic-{{ $epic->id }}').dataset.epic))">✎</a>
                </div>
                <span id="epic-{{ $epic->id }}" data-epic="{{ json_encode($epic) }}">
                    <strong>{{ $epic->name }}</strong>: {{ $epic->description }}<br>
                    {{ $epic->roadmap }}, {{ $epic->effort }},
                    {{ $epic->urgent == 'yes' ? '' : 'nicht' }} drigend &amp;
                    {{ $epic->important == 'yes' ? '' : 'nicht' }} wichtig
                </span>
            </li>
        </ul>
        @empty
            <ul id="epics"></ul>
            <p id="empty">- Keine Themen -</p>
        @endforelse
    </article>
</div>
@endsection

@section('footer')
<div id="overlay">
    <form id="overlay-text" onsubmit="save()">
        @csrf
        <div class="float-right close">
            <a href="#" class="icon" onclick="off()">╳</a>
        </div>
        <h4>Thema <em id="orig-epic-name"></em> <span id="verb"></span></h4>
        <fieldset>
            <label for="epic-name">Name</label>
            <input id="epic-name" type="text">
            <label for="epic-description">Beschreibung</label>
            <textarea id="epic-description"></textarea>
            <label for="epic-roadmap">Roadmap</label>
            <select id="epic-roadmap">
                <option>---</option>
                <option>kurzfristig</option>
                <option>mittelfristig</option>
                <option>langfristig</option>
            </select>
            <label for="epic-effort">Aufwand</label>
            <select id="epic-effort">
                <option>---</option>
                <option>2 Wochen</option>
                <option>6 Wochen</option>
                <option>12 Wochen</option>
            </select>
            <label for="epic-eisenhower">Eisenhower-Matrix</label>
            <select id="epic-eisenhower">
                <option>---</option>
                <option value="d1w1">dringend &amp; wichtig</option>
                <option value="d1w0">dringend &amp; nicht wichtig</option>
                <option value="d0w1">nicht dringend &amp; wichtig</option>
                <option value="d0w0">nicht dringend &amp; nicht wichtig</option>
            </select>
            <input class="button-primary" type="submit" value="Speichern">
        </fieldset>
    </form>
</div>
<script>
var epic_id;

function create() {
    epic_id = null;
    document.getElementById("orig-epic-name").innerHTML = "";
    document.getElementById("verb").innerHTML = "anlegen";
    document.getElementById("epic-name").value = "";
    document.getElementById("epic-description").value = "";
    document.getElementById("epic-roadmap").value = "---";
    document.getElementById("epic-effort").value = "---";
    document.getElementById("epic-eisenhower").value = "---";
    document.getElementById("overlay").style.display = "block";
}

function edit(epic) {
    epic_id = epic.id;
    document.getElementById("orig-epic-name").innerHTML = epic.name;
    document.getElementById("verb").innerHTML = "bearbeiten";
    document.getElementById("epic-name").value = epic.name;
    document.getElementById("epic-description").value = epic.description;
    document.getElementById("epic-roadmap").value = epic.roadmap;
    document.getElementById("epic-effort").value = epic.effort;
    document.getElementById("epic-eisenhower").value 
        = "d" + (epic.urgent == 'yes' ? '1' : '0')
        + "w" + (epic.important == 'yes' ? '1' : '0');
    document.getElementById("overlay").style.display = "block";
}

function off() {
  document.getElementById("overlay").style.display = "none";
}

function item_text(epic) {
    return `<strong>${epic.name}</strong>: ${epic.description}<br>
        ${epic.roadmap}, ${epic.effort},
        ${epic.urgent == 'yes' ? '' : 'nicht'} drigend &amp;
        ${epic.important == 'yes' ? '' : 'nicht'} wichtig`;
}

function save() {
    var data = {
        name: document.getElementById("epic-name").value,
        description: document.getElementById("epic-description").value,
        roadmap: document.getElementById("epic-roadmap").value,
        effort: document.getElementById("epic-effort").value,
        eisenhower: document.getElementById("epic-eisenhower").value
    };
    var csrf = document.getElementById('overlay-text')._token.value;

    var method, url;
    if (epic_id) {
        method = "PUT";
        url = "/epic/" +  epic_id;
    }
    else {
        method = "POST";
        url = "/epic/{{ $product->id }}";
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
        var item = document.getElementById("epic-" + data.epic.id);

        if (item) {
            item.dataset.epic = JSON.stringify(data.epic);
            item.innerHTML = item_text(data.epic);
        }
        else {
            var li = document.createElement("LI");
            li.innerHTML = `<div class="float-right">
                    <a href="#" class="icon" onclick="edit(JSON.parse(document.getElementById('epic-${data.epic.id}').dataset.epic))">✎</a>
                </div>
                <span id="epic-${data.epic.id}" data-epic="${JSON.stringify(data.epic)}">
                    ${item_text(data.epic)}
                </span>`;
            document.getElementById("epics").appendChild(li);
            document.getElementById("empty").style.display = "none";   
        }
        off();
    });
}
</script>
@endsection