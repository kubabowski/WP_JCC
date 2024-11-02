<?php
  $rootClass = '';
  $rootAttr = '';
  $inputClass = '';
  $inputAttr = '';
  $rootLabelClass = '';

  if (isset($disabled) && $disabled) {
    $rootClass .= ' radio--disabled';
    $inputAttr .= ' disabled';
  }

  if (isset($checked) && $checked) {
    $inputAttr .= ' checked';
  }

  if (isset($name)) {
    $inputAttr .= ' name="' . $name . '"';
  }

  if (isset($customClass)) $rootClass .= ' ' . $customClass;
  if (isset($customAttr)) $rootAttr .= ' ' . $customAttr;
  if (isset($customInputClass)) $inputClass .= ' ' . $customInputClass;
  if (isset($customInputAttr)) $inputAttr .= ' ' . $customInputAttr;
?>
<div class="radio<?= $rootClass ?>"<?= $rootAttr ?>>
  <input
    class="radio__input<?= $inputClass ?>"
    id="<?= $id ?>"
    type="radio"
    value="<?= isset($value) ? $value : '1' ?>"
    <?= $inputAttr ?>
  />
  <label
    class="radio__label<?= $rootLabelClass ?>"
    for="<?= $id ?>"
  >
    <span class="radio__box"></span>
    <span class="radio__text">
      <?= $label ?>
    </span>
  </label>
</div>

