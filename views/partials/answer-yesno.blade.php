<?php
// https://codepen.io/chsyu/pen/bGNRgLQ
?>
<div class="uk-width-1-1">
    <label class="uk-switch" for="yesno_answer">
        <input type="checkbox" id="yesno_answer" name="yesno_answer" value="1"{{ isset($my_answer) && $my_answer->yesno_answer ? ' checked' : '' }}>
        <div class="uk-switch-slider"></div>
    </label>
</div>

@include('mindyourteam::partials.answer-text', ['placeholder' => 'Möchtest du etwas ergänzen?'])

@push('head')
<style>
.uk-switch {
  position: relative;
  display: inline-block;
  height: 34px;
  width: 60px;
}
/* Hide default HTML checkbox */
.uk-switch input {
  display:none;
}
/* Slider */
.uk-switch-slider {
  background-color: rgba(0,0,0,0.22);
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  border-radius: 500px;
  bottom: 0;
  cursor: pointer;
  transition-property: background-color;
  transition-duration: .2s;
  box-shadow: inset 0 0 2px rgba(0,0,0,0.07);
}
/* Switch pointer */
.uk-switch-slider:before {
  content: '';
  background-color: #fff;
  position: absolute;
  width: 30px;
  height: 30px;
  left: 2px;
  bottom: 2px;
  border-radius: 50%;
  transition-property: transform, box-shadow;
	transition-duration: .2s;
}
/* Slider active color */
input:checked + .uk-switch-slider {
  background-color: #39f !important;
}
/* Pointer active animation */
input:checked + .uk-switch-slider:before {
  transform: translateX(26px);
}
</style>
@endpush