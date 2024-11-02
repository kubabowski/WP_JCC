<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<ul class="flex gap-4px<?= $rootClass ?>"<?= $rootAttr ?>>
  <?php foreach ($props['items'] as $item): ?>
  <li class="block">
    <a
      href="<?= $item['link']['url'] ?>"
      target="<?= $item['link']['target'] ?? '_blank' ?>"
      class="<?= cx([
        'flex items-center justify-center',
        'size-56px text-20px/1',
        'bg-neutral-white/10 hover:bg-neutral-white/15',
        'transition-colors',
      ]) ?>"
    ><?php get_icon($item['icon'], 'icon'); ?></a>
  </li>
  <?php endforeach; ?>
</ul>