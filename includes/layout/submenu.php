<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<nav class="submenu<?= $rootClass ?>" data-submenu<?= $rootAttr ?>>
  <ul class="submenu__items" data-submenu-items>
    <?php foreach ($props['items'] as $item): ?>
    <?php
      if (!isset($item['children']) || !is_array($item['children']) || count($item['children']) <= 0) continue;

      $itemClass = '';
      if (isset($item['active'])) $itemClass .= ' submenu__item--active';
    ?>
    <li
      class="submenu__item<?= $itemClass ?>"
      data-submenu-item="<?= $item['ID'] ?>"
    >
      <div class="submenu__inner container">
        <?php get_part('components/textBox', [
          'class' => 'submenu__info',
          'title' => $item['name'],
          'text' => $item['text'] ?? null,
          'button' => [
            'url' => $item['url'],
            'target' => $item['target'],
            'text' => __('Visit page', 'center3'),
            'theme' => 'outline',
          ],
        ]); ?>
        <nav class="submenu__menu">
          <ul class="submenu__subitems">
          <?php foreach ($item['children'] as $subitem): ?>
            <?php
              $subitemClass = '';
              if (isset($subitem['active'])) $subitemClass .= ' submenu__item--active';
            ?>
            <li class="submenu__subitem<?= $subitemClass ?>">
              <a
                href="<?= $subitem['url'] ?>"
                target="<?= $subitem['target'] ?>"
                class="submenu__sublink"
              >
                <span><?= $subitem['name'] ?></span>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </nav>
      </div>
    </li>
    <?php endforeach; ?>
  </ul>
</nav>
