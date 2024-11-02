<?php
  $rootClass = '';
  $rootAttr = '';
  $inputClass = '';
  $inputAttr = '';

  $isMultiple = isset($props['multiple']) && $props['multiple'];
  $withSearch = isset($props['search']) && $props['search'];

  $defaultSelectedSuffix = $props['selectedSuffix'] ?? 'Selected options';
  $defaultSearchPlaceholder = $props['searchPlaceholder'] ?? 'Search';
  $defaultNoResults = $props['noResultsText'] ?? 'No results';

  $inputId = $props['id'] ?? $props['name'];
  $inputValue = $props['value'] ?? '';

  if (isset($props['native']) && $props['native']) {
    $rootAttr .= ' data-native="1"';
  } else {
    $rootAttr .= ' data-custom-select';
    $inputAttr .= ' data-custom-select-input';
  }

  if ($withSearch) {
    $rootClass .= ' select--search';
    $rootAttr .= ' data-custom-select-search="' . $defaultSearchPlaceholder . '"';
    $rootAttr .= ' data-custom-select-no-results="' . $defaultNoResults . '"';
  }

  if ($isMultiple) {
    $rootClass .= ' select--multiple'; // not used
    $rootAttr .= ' data-custom-select-multiple="' . $defaultSelectedSuffix . '"';
    $inputAttr .= ' multiple';
  }

  if (isset($props['selectAll'])) $rootAttr .= ' data-custom-select-all="' . $props['selectAll'] . '"';
  if (isset($props['placeholder'])) $rootAttr .= ' data-custom-select-placeholder="' . $props['placeholder'] . '"';

  if (isset($props['disabled']) && $props['disabled']) {
    $rootClass .= ' select--disabled';
    $inputAttr .= ' disabled';
  }

  $directAttrs = ['id', 'name'];
  foreach ($directAttrs as $attrName) {
    if (isset($props[$attrName])) {
      $inputAttr .= ' ' . $attrName . '="' . $props[$attrName] . '"';
    }
  }

  // if (isset($label)) array_unshift($options, [ 'value' => '', 'label' => '' ]);

  $rootClass .= ' select--' . (isset($props['theme']) ? $props['theme'] : 'default');
  if (isset($props['theme'])) $rootAttr .= ' data-custom-select-theme="' . $props['theme'] . '"';

  $errorMessage = isset($props['error']) ? $props['error'] : '';
  if ($errorMessage !== '') $inputClass .= ' error';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
  if (isset($props['inputClass'])) $inputClass .= ' ' . $props['inputClass'];
  if (isset($props['inputAttr'])) $inputAttr .= ' ' . $props['inputAttr'];

  $inputValues = $isMultiple ? explode(',', $inputValue) : [$inputValue];

  $inputOptions = $props['options'] ?? [];
  if (!$isMultiple) {
    $emptyOption = [ 'value' => '', 'label' => '' ];
    $attrParts = explode(' ', $inputAttr);
    if (in_array('required', $attrParts) || in_array('data-conditional-required', $attrParts)) {
      $emptyOption = array_merge($emptyOption, [ 'empty' => true, 'disabled' => true ]);
    }
    $inputOptions = array_merge([$emptyOption], $inputOptions);
  }
?>
<div
  class="select<?= $rootClass ?>"
  data-input-label="select--filled"
  <?= $rootAttr ?>
>
  <select
    id="<?= $inputId ?>"
    name="<?= $props['name'] ?>"
    class="select__select<?= $inputClass ?>"
    data-input-label-input
    <?= $inputAttr ?>
  >
    <?php foreach ($inputOptions as $option): ?>
    <?php
      $optionAttr = '';
      if (in_array($option['value'], $inputValues)) $optionAttr .= ' selected="selected"';
      if (isset($option['disabled'])) $optionAttr .= ' disabled="disabled"';
      if (isset($option['empty'])) $optionAttr .= ' data-empty="1"';
      if (isset($option['neverHide'])) $optionAttr .= ' data-never-hide="1"';
    ?>
    <option
      value="<?= $option['value'] ?>"
      class="select__option"
      <?= $optionAttr ?>
    ><?= $option['label'] ?></option>
    <?php endforeach; ?>
  </select>
  <?php get_icon('chevron-down', 'icon select__icon'); ?>
  <span class="select__line"></span>
  <?php /*
  <?php if (isset($props['label'])): ?>
  <label
    for="<?= $inputId ?>"
    class="select__label"
  ><?= $props['label'] ?></label>
  <?php endif; ?>
  <span class="input__error"><?= $errorMessage ?></span>
  */ ?>
</div>
