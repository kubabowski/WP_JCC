<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="<?= $rootClass ?>"<?= $rootAttr ?>>
  <ul class="wrapper flex items-center flex-wrap pt-[2.5rem]">
    <li class="block">
      <a
        href="<?= home_url('/') ?>"
        class="flex items-center justify-center size-24px text-16px/1 text-neutral-red">
        <?php get_icon('home', 'icon'); ?>
      </a>
    </li>
    <?php foreach ($props['items'] as $item) : ?>
    <li class="flex items-center ms-6px">
      <?php get_icon('chevron-right', 'icon text-14px/1 me-6px text-neutral-gray'); ?>
      <?php if (isset($item['url'])) : ?>
      <a
        href="<?= $item['url'] ?>"
        class="text-14px/1_2 text-neutral-gray"
      ><?= $item['title'] ?></a>
      <?php else: ?>
      <span
        class="text-14px/1_2 font-medium text-neutral-dark"
      ><?= $item['title'] ?></span>
      <?php endif; ?>
    </li>
    <?php endforeach; ?>
  </ul>
</section>
