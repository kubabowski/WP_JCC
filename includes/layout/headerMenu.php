<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<nav class="<?= $rootClass ?>"<?= $rootAttr ?>>
  <ul class="flex gap-8px" data-submenu-parent-items>
    <?php foreach ($props['items'] as $item): ?>
    <?php
      $hasChildren = count($item['children']) > 0;

      $itemId = $item['ID'];

      $itemLinkClass = ' ' . cx([
        $item['active']
          ? 'text-neutral-dark font-medium bg-neutral-dark/5'
          : 'text-neutral-dark/70 hover:text-neutral-dark/100 transition-colors',
      ]);

      $itemLinkAttr = '';
      if ($hasChildren) {
        $itemLinkAttr .= ' data-submenu-parent-link="' . $itemId . '"';
      }
    ?>
    <li class="relative">
      <a
        href="<?= $item['url'] ?>"
        target="<?= $item['target'] ?>"
        class="peer p-8px flex items-center min-h-58px<?= $itemLinkClass ?>"
        <?= $itemLinkAttr ?>
      >
        <span class="text-16px/1_5"><?= $item['name'] ?></span>
        <?php if ($hasChildren): ?>
          <?php get_icon('chevron-down', 'icon text-14px/1 ms-16px'); ?>
        <?php endif; ?>
      </a>
      <?php if ($hasChildren): ?>
      <ul
        class="<?= cx([
          'absolute top-full left-0 p-8px -mx-8px',
          'bg-neutral-white border border-neutral-dark/10',
          'invisible opaticy-0',
          'hover:visible hover:opaticy-100',
          'peer-hover:visible peer-hover:opaticy-100',
          'transition-visibility',
        ]) ?>"
      >
        <?php foreach ($item['children'] as $subitem): ?>
        <?php
          $subitemLinkClass = ' ' . cx([
            $subitem['active']
              ? 'text-neutral-dark font-medium bg-neutral-dark/5'
              : 'text-neutral-dark/70 hover:text-neutral-dark/100 transition-colors',
          ]);
        ?>
        <li>
          <a
            href="<?= $subitem['url'] ?>"
            target="<?= $subitem['target'] ?>"
            class="p-8px flex items-center<?= $subitemLinkClass ?>"
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
