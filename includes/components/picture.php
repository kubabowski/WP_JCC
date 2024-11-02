<?php
  $imgClass = '';
  $imgAttr = '';

  if (isset($props['imgClass'])) $imgClass .= ' ' . $props['imgClass'];
  if (isset($props['imgAttr'])) $imgAttr .= ' ' . $props['imgAttr'];

  if (isset($props['lazy']) && $props['lazy']) $imgAttr .= ' loading="lazy"';
  $default = array_pop($props['sources']);
?>
<picture>
  <?php foreach ($props['sources'] as $source): ?>
  <source
    media="<?= $source['media'] ?>"
    srcset="<?= $source['src'] ?>"
    width="<?= $source['width'] ?>"
    height="<?= $source['height'] ?>"
  >
  <?php endforeach; ?>
  <img
    src="<?= $default['src'] ?>"
    width="<?= $default['width'] ?>"
    height="<?= $default['height'] ?>"
    alt="<?= $default['alt'] ?? $props['alt'] ?? 'image' ?>"
    class="<?= $imgClass ?>"
    <?= $imgAttr ?>
  >
</picture>
