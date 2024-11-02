<?php
  $rootClass = '';
  $rootAttr = '';
  $inputClass = '';
  $inputAttr = '';

  if (isset($disabled) && $disabled) {
    $rootClass .= ' checkbox--disabled';
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
<div class="checkbox<?= $rootClass ?>"<?= $rootAttr ?>>
  <input
    class="checkbox__input<?= $inputClass ?>"
    id="<?= $id ?>"
    type="checkbox"
    value="<?= isset($value) ? $value : '1' ?>"
    <?= $inputAttr ?>
  />
  <label
    class="checkbox__label"
    for="<?= $id ?>"
  >
    <span class="checkbox__box"></span>
    <span class="checkbox__text">
      <?= $label ?>
    </span>
  </label>
</div>

