<?php
if (empty($placeholder)) {
    $placeholder = 'Deine Antwort&hellip;';
}
?>
<div class="uk-width-1-1">
    <textarea name="text_answer" class="uk-textarea" placeholder="{{ $placeholder }}">{{ isset($my_answer) ? $my_answer->text_answer : '' }}</textarea>
</div>
