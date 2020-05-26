<?php
if (empty($placeholder)) {
    $placeholder = 'Deine Antwort&hellip;';
}
?>
<div class="uk-width-1-1">
    <textarea name="text_answer" class="uk-textarea" placeholder="{{ $placeholder }}">{{ $my_answer->text_answer }}</textarea>
</div>
