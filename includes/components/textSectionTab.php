<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<div class="wysiwyg wysiwyg--root<?= $rootClass ?>"<?= $rootAttr ?>>
  <?= $props['content'] ?>
</div>
