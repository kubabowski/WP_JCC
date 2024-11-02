<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<div
  class="<?= cx([
    'absolute top-0 right-0 h-full w-[15rem]',
    'bg-neutral-white border-s border-border-menu',
    'transition-all',
    'opacity-0 transform translate-x-full',
    'data-[active]:visible data-[active]:opacity-100 data-[active]:translate-x-0',
    $rootClass,
  ]) ?>"
  data-mobile-menu
  <?= $rootAttr ?>
>
  <div class="overflow-x-hidden overflow-y-auto">
    <ul class="py-24px" data-mobile-menu-items>
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
          $itemLinkAttr .= ' data-mobile-menu-link="' . $itemId . '"';
        }
      ?>
      <li data-mobile-menu-item="<?= $itemId ?>">
        <a
          href="<?= $item['url'] ?>"
          target="<?= $item['target'] ?>"
          class="py-8px px-16px flex items-center min-h-40px<?= $itemLinkClass ?>"
          <?= $itemLinkAttr ?>
        >
          <span class="text-16px/1_5"><?= $item['name'] ?></span>
          <?php /* if ($hasChildren): ?>
            <?php get_icon('chevron-down', 'icon text-14px/1 ms-16px'); ?>
          <?php endif; */ ?>
        </a>
        <?php /* if ($hasChildren): ?>
        <ul
          class="<?= cx([
            'invisible opaticy-0 h-0',
            'data-[active]:visible data-[active]:opaticy-100 data-[active]:h-auto',
          ]) ?>"
          data-mobile-menu-subitems="<?= $itemId ?>"
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
              <span class="text-16px/1_5"><?= $subitem['name'] ?></span>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; */ ?>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
