<div class="uk-width-1-1">
    <input type="hidden" id="yesno_answer" name="yesno_answer">
    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a href="#">ja</a></li>
        <li><a href="#">nein</a></li>
    </ul>
    <ul class="uk-switcher">
        <li id="answer-yes"></li>
        <li id="answer-no"></li>
    </ul>
</div>

@include('mindyourteam::partials.answer-text', ['placeholder' => 'Möchtest du etwas ergänzen?'])

@push('toes')
<script>
UIkit.util.on('#answer-yes', 'shown', function (e) {
    document.getElementById('yesno_answer').value = "1";
});
UIkit.util.on('#answer-no', 'shown', function (e) {
    document.getElementById('yesno_answer').value = "0";
});
</script>
@endpush