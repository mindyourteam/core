@extends('layout')

@section('content')
<div class="row">
    <div class="column">

        <p><a href="{{ route('product', ['productplan' => $product->productplan_id]) }}">&laquo; zurück</a></p>

        <div class="float-right">
            <a href="#" class="icon js-add">+</a>
        </div>
        <h1>Themen in {{ $product->name }}</h1>

        @forelse ($topics as $topic)
        <ul>
            <li>
                <div class="float-right">
                    <a href="#" class="icon" onclick="edit(JSON.parse(document.getElementById('topic-{{ $topic->id }}').dataset.topic))">✎</a>
                </div>
                <span id="topic-{{ $topic->id }}" data-topic="{{ json_encode($topic) }}">
                    <strong>{{ $topic->name }}</strong>: {{ $topic->description }}<br>
                    {{ $topic->roadmap }}, {{ $topic->effort }},
                    {{ $topic->urgent == 'yes' ? '' : 'nicht' }} drigend &amp;
                    {{ $topic->important == 'yes' ? '' : 'nicht' }} wichtig
                </span>
            </li>
        </ul>
        @empty
            <p>- Keine Themen -</p>
        @endforelse
    </div>
</div>
@endsection

@section('footer')
<div id="overlay">
    <form id="overlay-text" onsubmit="save()">
        @csrf
        <div class="float-right close">
            <a href="#" class="icon" onclick="off()">╳</a>
        </div>
        <h4>Thema <em id="orig-topic-name"></em> bearbeiten</h4>
        <fieldset>
            <label for="topic-name">Name</label>
            <input id="topic-name" type="text">
            <label for="topic-description">Beschreibung</label>
            <textarea id="topic-description"></textarea>
            <label for="topic-roadmap">Roadmap</label>
            <select id="topic-roadmap">
                <option>---</option>
                <option>kurzfristig</option>
                <option>mittelfristig</option>
                <option>langfristig</option>
            </select>
            <label for="topic-effort">Aufwand</label>
            <select id="topic-effort">
                <option>---</option>
                <option>2 Wochen</option>
                <option>6 Wochen</option>
                <option>12 Wochen</option>
            </select>
            <label for="topic-eisenhower">Eisenhower-Matrix</label>
            <select id="topic-eisenhower">
                <option value="d0w0">---</option>
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
var topic_id;

function edit(topic) {
    topic_id = topic.id;
    document.getElementById("orig-topic-name").innerHTML = topic.name;
    document.getElementById("topic-name").value = topic.name;
    document.getElementById("topic-description").value = topic.description;
    document.getElementById("topic-roadmap").value = topic.roadmap;
    document.getElementById("topic-effort").value = topic.effort;
    document.getElementById("topic-eisenhower").value 
        = "d" + (topic.urgent == 'yes' ? '1' : '0')
        + "w" + (topic.important == 'yes' ? '1' : '0');
    document.getElementById("overlay").style.display = "block";
}

function off() {
  document.getElementById("overlay").style.display = "none";
}

function save() {
    var data = {
        name: document.getElementById("topic-name").value,
        description: document.getElementById("topic-description").value,
        roadmap: document.getElementById("topic-roadmap").value,
        effort: document.getElementById("topic-effort").value,
        eisenhower: document.getElementById("topic-eisenhower").value
    };
    var csrf = document.getElementById('overlay-text')._token.value;
    fetch("/topic/" +  topic_id, {
        method: "POST", 
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Concent-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Saved:", data);
        var item = document.getElementById("topic-" + data.topic.id);
        item.dataset.topic = JSON.stringify(data.topic);
        item.innerHTML
            = `<strong>${data.topic.name}</strong>: ${data.topic.description}<br>
                    ${data.topic.roadmap}, ${data.topic.effort},
                    ${data.topic.urgent == 'yes' ? '' : 'nicht'} drigend &amp;
                    ${data.topic.important == 'yes' ? '' : 'nicht'} wichtig`;
        off();
    });
}
</script>
@endsection