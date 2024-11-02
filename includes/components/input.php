<?php
  $rootClass = '';
  $rootAttr = '';
  $inputClass = '';
  $inputAttr = '';

  $inputId = isset($id) ? $id : $name;

  if (isset($datepicker) && $datepicker) {
    $rootClass .= ' input--datepicker';
  }

  if (isset($search) && $search) {
    $rootClass .= ' input--search';
  }

  if (isset($hideIcons) && $hideIcons) {
    $rootClass .= ' input--hideIcons';
  }

  if (isset($disabled) && $disabled) {
    $rootClass .= ' input--disabled';
    $inputAttr .= ' disabled';
  }

  if (isset($readonly) && $readonly) {
    $rootClass .= ' input--readonly';
    $inputAttr .= ' readonly';
  }

  $directAttrs = ['id', 'name', 'type', 'value', 'placeholder'];
  foreach ($directAttrs as $attrName) {
    if (isset($$attrName)) {
      $inputAttr .= ' ' . $attrName . '="' . $$attrName . '"';
    }
  }

  if (isset($customClass)) $rootClass .= ' ' . $customClass;
  if (isset($customAttr)) $rootAttr .= ' ' . $customAttr;
  if (isset($customInputClass)) $inputClass .= ' ' . $customInputClass;
  if (isset($customInputAttr)) $inputAttr .= ' ' . $customInputAttr;
?>
<div class="input<?= $rootClass ?>"<?= $rootAttr ?>>
  <input
    id="<?= $inputId ?>"
    name="<?= $name ?>"
    class="input__input<?= $inputClass ?>"
    <?= $inputAttr ?>
  />
</div>
