<?php
  $itemsIds = $props['items'] ?? [];

  $items = $itemsIds
    ? apply_filters('getProducts', [], [
      'post__in' => $itemsIds,
      'per_page' => 4,
    ])
    : [];
?>
<div>
  <h3
    class="text-24px/1_2 font-medium mb-24px"
  ><?= __('Zobacz także', 'jcc-solutions') ?></h3>
  <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-32px">
    <?php foreach ($items as $item): ?>
      <a
        href="<?= $item['url'] ?>"
        class="p-32px border border-neutral-dark/10"
      >
        <div class="relative h-0 w-full pt-5/4">
          <?php if ($item['image']): ?>
            <?php get_part('components/picture', [
              'imgClass' => /*tw:*/'block absolute top-0 left-0 size-full object-contain',
              'sources' => [[
                'src' => $item['image']['sizes']['square-sm'] ?? $item['image']['url'],
                'width' => $item['image']['width'],
                'height' => $item['image']['height'],
                'alt' => $item['image']['alt'] ?? __('Zdjęcie produktu', 'jcc-solutions'),
              ]],
            ]); ?>
          <?php endif; ?>
        </div>
        <h4
          class="font-medium text-20px/1_6 mt-40px"
        ><?= $item['title'] ?></h4>
        <?php /*
        <?= $item['text'] ?>
        */ ?>
      </a>
    <?php endforeach; ?>
  </div>
</div>
