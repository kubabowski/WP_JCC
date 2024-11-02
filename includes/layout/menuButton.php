<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<div class="menuButton<?= $rootClass ?>"<?= $rootAttr ?>>
  <span class="menuButton__bars">
    <span class="menuButton__bar menuButton__bar--1"></span>
    <span class="menuButton__bar menuButton__bar--2"></span>
    <span class="menuButton__bar menuButton__bar--3"></span>
  </span>
</div>