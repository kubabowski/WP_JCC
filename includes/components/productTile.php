<?php

  $item = $props['item'] ?? [];
  $promotion = $item['promotion'] ?? false;

?>
<?php if ($item) : ?>
  <a
    href="<?= $item['url'] ?>"
    class="p-32px relative group custom-gradient-border"
  >
  <?php if ($promotion): ?>
    <span
      class="flex items-center px-32px py-8px min-h-[3rem] text-16px/1_6 bg-neutral-red text-neutral-white absolute top-0 left-0"
      style="clip-path: polygon(14px 0%, 100% 0%, 100% calc(100% - 14px), calc(100% - 14px) 100%, 0% 100%, 0% 14px);"
    ><?= __('Promocja', 'jcc-solutions') ?></span>
  <?php endif; ?>
    <div class="relative h-0 w-full pt-5/4">
      <?php if ($item['image']): ?>
        <?php get_part('components/picture', [
          'imgClass' => /*tw:*/ 'block absolute top-0 left-0 size-full object-contain',
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
      class="font-medium text-20px/1_6 mt-40px group-hover:text-neutral-red transition-colors"
    ><?= $item['title'] ?></h4>
    <?php /*
          <?= $item['text'] ?>
    */ ?>
  </a>
<?php endif; ?>