<?php
  $items = $props['items'] ?? [];

  $keyPrefix = wp_unique_id('product-characteristic-');
  $activeKey = $keyPrefix . '-' . 0;
?>
<div
  class="grid grid-cols-2 gap-64px"
  data-tabs="<?= $keyPrefix ?>"
>
  <ul class="block">
    <?php foreach ($items as $itemIndex => $item): ?>
      <?php
        $tabKey = $keyPrefix . '-' . $itemIndex;
        $isActive = ($tabKey === $activeKey);
      ?>
      <li class="flex text-16px/1_6">
        <span class="flex-shrink size-4px rounded-1/2 bg-current mt-[0.65em] me-4px"></span>
        <button
          class="<?= cx([
            'text-16px/1_6 underline hover:text-neutral-red transition-colors',
            'data-[active]:text-neutral-red',
          ]) ?>"
          data-tabs-nav-item="<?= $tabKey ?>"
          id="<?= $tabKey ?>-head"
          aria-controls="<?= $tabKey ?>-body"
          aria-selected="<?= ($isActive ? 'true' : 'false') ?>"
          <?= $isActive ? 'data-active' : '' ?>
        ><?= $item['label'] ?></button>
      </li>
    <?php endforeach; ?>
  </ul>

  <div
    class="block relative overflow-hidden"
    data-tabs-items
  >
    <?php foreach ($items as $itemIndex => $item): ?>
      <?php
        $tabKey = $keyPrefix . '-' . $itemIndex;
        $isActive = ($tabKey === $activeKey);
      ?>
      <div
        class="<?= cx([
          'block top-0 left-0 w-full',
          'absolute invisible opacity-0',
          'data-[active]:relative data-[active]:visible data-[active]:opacity-100',
          'transition-visibility',
        ]) ?>"
        data-tabs-item="<?= $tabKey ?>"
        id="<?= $tabKey ?>-body"
        aria-labelledby="<?= $tabKey ?>-head"
        <?= $isActive ? 'data-active' : '' ?>
      >
        <?php get_part('components/picture', [
          'imgClass' => /*tw:*/'block w-full h-auto',
          'sources' => [[
            'src' => $item['chart']['sizes']['square-lg'] ?? $item['chart']['url'],
            'width' => $item['chart']['width'],
            'height' => $item['chart']['height'],
            'alt' => $item['chart']['alt'] ?? __('Wykres charakterystyki', 'bud-went'),
          ]],
        ]); ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>
