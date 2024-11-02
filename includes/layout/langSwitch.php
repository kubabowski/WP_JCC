<?php
  $rootClass = '';
  $rootAttr = '';

  $langs = apply_filters('getLangs', null);

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<div class="langSwitch<?= $rootClass ?>"<?= $rootAttr ?>>
  <?php foreach ($langs['others'] as $lang): ?>
  <a
    href="<?= $lang['url'] ?>"
    class="langSwitch__lang"
    data-lang="<?= $lang['slug'] ?>"
  >
    <?= $lang['name'] ?>
  </a>
  <?php endforeach; ?>
</div>
