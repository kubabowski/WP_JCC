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

      $dropdownClass = '';
      $itemLinkAttr = '';
      if ($hasChildren) {
        $itemLinkAttr .= ' data-submenu-parent-link="' . $itemId . '"';
        $dropdownClass .= ' dropdown';
      }
    ?>
    <li class="relative <?php echo $dropdownClass ?>">
      <a
        href="<?= $item['url'] ?>"
        target="<?= $item['target'] ?>"
        class="fw-500 fs-16 lh-24"
        <?= $itemLinkAttr ?>
      >
        <span class="text-16px/1_5"><?= $item['name'] ?></span>
        <?php if ($hasChildren): ?>
          <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.786133 1L4.78613 5L8.78613 1" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        <?php endif; ?>
      </a>
      <?php if ($hasChildren): ?>
      <ul class="<?=  cx(['nav-dropdown-content']) ?>">
        <?php foreach ($item['children'] as $subitem): ?>
        <?php
          $subitemLinkClass = ' ' . cx(['fw-500 fs-16 lh-24']);
        ?>
        <li>
          <a
            href="<?= $subitem['url'] ?>"
            target="<?= $subitem['target'] ?>"
            class="<?= $subitemLinkClass ?>"
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

