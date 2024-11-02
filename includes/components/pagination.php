<?php
  $rootClass = '';
  $rootAttr = '';

  $page = $props['page'] ?? 1;
  $pages = $props['pages'] ?? 1;

  $rootClass = cx([
    'flex items-center justify-center',
    'relative min-h-40px px-40px',
  ]);

  $arrowClass = cx([
    'flex items-center justify-center',
    'size-40px text-20px/1',
    'border border-neutral-dark/20 text-neutral-dark/40',
    'absolute',
    '[&[href]]:hover:text-neutral-dark',
    'transition-colors',
  ]);

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<div class="<?= $rootClass ?>"<?= $rootAttr ?>>
  <form
    action="<?= add_query_arg([]) ?>"
    method="get"
    class="flex-shrink-0 flex items-center gap-12px text-16px/1_6 text-center"
    autocomplete="off"
  >
    <input
      name="page"
      value="<?= $page ?>"
      aria-label="<?= __('Wpisz numer strony i zatwierdz Enterem', 'bud-went') ?>"
      class="size-40px text-center border border-border-gray py-8px px-4px"
      <?= $pages === 1 ? 'readonly' : '' ?>
    >
    <span><?= __('z', 'bud-went') ?> <?= $pages ?></span>
  </form>
  <a
    <?php if ($page > 1): ?>
      href="<?= add_query_arg('page', $page - 1) ?>"
    <?php endif; ?>
    aria-lable="<?= __('Poprzednia strona', 'bud-went') ?>"
    class="<?= cx([
      $arrowClass,
      'top-0 left-0',
    ]) ?>"
    <?= $page === 1 ? 'disabled' : '' ?>
  ><?php get_icon('long-arrow-left', 'icon'); ?></a>
  <a
    <?php if ($page < $pages): ?>
      href="<?= add_query_arg('page', $page + 1) ?>"
    <?php endif; ?>
    aria-lable="<?= __('Następna strona', 'bud-went') ?>"
    class="<?= cx([
      $arrowClass,
      'top-0 right-0',
    ]) ?>"
    <?= $page === $pages ? 'disabled' : '' ?>
  ><?php get_icon('long-arrow-right', 'icon'); ?></a>
</div>
