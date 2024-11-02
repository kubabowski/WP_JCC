<?php
  $rootClass = '';
  $rootAttr = '';
  $inputClass = '';
  $inputAttr = '';

  $inputId = isset($id) ? $id : $name;
  $inputValue = isset($value) ? $value : '';

  if (isset($hideIcons) && $hideIcons) {
    $rootClass .= ' textarea--hideIcons';
  }

  if (isset($disabled) && $disabled) {
    $rootClass .= ' textarea--disabled';
    $inputAttr .= ' disabled';
  }

  if (isset($readonly) && $readonly) {
    $rootClass .= ' textarea--readonly';
    $inputAttr .= ' readonly';
  }

  $directAttrs = ['id', 'name', 'placeholder', 'rows'];
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
<div class="textarea<?= $rootClass ?>"<?= $rootAttr ?>>
  <textarea
    id="<?= $inputId ?>"
    name="<?= $name ?>"
    class="textarea__input<?= $inputClass ?>"
    <?= $inputAttr ?>
  ><?= $inputValue ?></textarea>
</div>
