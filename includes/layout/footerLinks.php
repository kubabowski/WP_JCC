<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<nav class="<?= $rootClass ?>"<?= $rootAttr ?>>
  <ul class="flex items-center gap-16px xl:gap-32px">
    <?php foreach ($props['items'] as $itemIndex => $item): ?>
    <li class="flex items-center gap-16px xl:gap-32px">
      <?php if ($itemIndex !== 0): ?>
        <?php get_icon('menu-separator', 'icon text-18px opacity-20'); ?>
      <?php endif; ?>
      <a
        href="<?= $item['url'] ?>"
        target="<?= $item['target'] ?>"
        class="underline text-neutral-white hover:text-neutral-white/80 transition-colors"
      ><?= $item['name'] ?></a>
    </li>
    <?php endforeach; ?>
  </ul>
</nav>