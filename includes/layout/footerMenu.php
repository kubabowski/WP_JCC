<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<nav class="<?= $rootClass ?>"<?= $rootAttr ?>>
  <ul class="sm:columns-2 md:columns-3 lg:columns-2 xl:columns-3 gap-32px 2xl:gap-64px">
    <?php foreach ($props['items'] as $item): ?>
    <?php
      $hasChildren = count($item['children']) > 0;

      $itemLinkClass = ' ' . cx([
        $item['active']
          ? 'text-neutral-white font-medium'
          : 'text-neutral-white hover:text-neutral-white/90 transition-colors',
      ]);
    ?>
    <li class="block mb-40px break-inside-avoid">
      <a
        href="<?= $item['url'] ?>"
        target="<?= $item['target'] ?>"
        class="inline-block mb-32px text-20px/1_2<?= $itemLinkClass ?>"
      >
        <span><?= $item['name'] ?></span>
      </a>
      <?php if ($hasChildren): ?>
        <ul>
        <?php foreach ($item['children'] as $subitem): ?>
          <?php
            $subitemLinkClass = ' ' . cx([
              $subitem['active']
                ? 'text-neutral-white/80 font-medium'
                : 'text-neutral-white/40 hover:text-neutral-white/60 transition-colors',
            ]);
          ?>
          <li class="block mb-16px">
            <a
              href="<?= $subitem['url'] ?>"
              target="<?= $subitem['target'] ?>"
              class="text-16px/1_6 <?= $subitemLinkClass ?>"
            >
              <span><?= $subitem['name'] ?></span>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </li>
    <?php endforeach; ?>
  </ul>
</nav>