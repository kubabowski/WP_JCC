<?php
  $rootClass = '';
  $rootAttr = '';

  $bgColor = $props['bg_color'] ?? '';

  $rootClass = cx([
    $bgColor === 'gray-light' ? 'bg-neutral-dark/5' : null,
  ]);

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="<?= $rootClass ?>"<?= $rootAttr ?>>
  <div class="wrapper py-96px">
    <div class="max-w-[56rem] mx-auto wysiwyg wysiwyg--root">
      <?= $props['content'] ?>
    </div>
  </div>
</section>