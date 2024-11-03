<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>

  <ul>
    <?php foreach ($props['items'] as $item): ?>
    <?php
      $hasChildren = count($item['children']) > 0;

      $itemId = $item['ID'];

      $itemLinkClass = ' ' . cx([
        $item['active']
          ? 'fw-500 fs-16 lh-24'
          : 'fw-500 fs-16 lh-24',
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
        class="fw-500 fs-16 lh-24"
        <?= $itemLinkAttr ?>
      >
        <span class="text-16px/1_5"><?= $item['name'] ?></span>
        <?php if ($hasChildren): ?>
          <?php get_icon('chevron-down', 'icon text-14px/1 ms-16px'); ?>
        <?php endif; ?>
      </a>
      <?php if ($hasChildren): ?>
      <ul
        class="<?= cx(['fw-500 fs-16 lh-24 dropdown']) ?>"
      >
        <?php foreach ($item['children'] as $subitem): ?>
        <?php
          $subitemLinkClass = ' ' . cx([
            $subitem['active']
              ? 'fw-500 fs-16 lh-24 active'
              : 'fw-500 fs-16 lh-24',
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

