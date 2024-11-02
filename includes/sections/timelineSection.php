<?php
  $rootClass = '';
  $rootAttr = '';

  $items = $props['items'] ?? [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="bg-neutral-dark/5<?= $rootClass ?>"<?= $rootAttr ?>>
  <div class="wrapper py-96px">
    <div class="max-w-[63rem] mx-auto">
      <h2 class="text-40px/1_2 text-center mb-48px"><?= $props['title'] ?></h2>
      <div class="block relative pt-32px">
        <div class="w-px h-full bg-border-gray absolute start-0 md:start-1/2"></div>
        <?php foreach ($items as $itemIndex => $item): ?>
          <div class="<?= cx([
            'md:w-1/2 mt-24px relative',
            $itemIndex % 2 === 0
              ? 'md:me-auto ps-32px md:ps-0 md:pe-[10%] md:text-right'
              : 'md:ms-auto ps-32px md:ps-[10%] md:text-left',
          ]) ?>">
            <div class="<?= cx([
              'size-16px bg-border-gray -mx-8px mt-4px',
              'transform rotate-45 absolute top-0',
              $itemIndex % 2 === 0
                ? 'start-0 md:start-auto md:end-0'
                : 'start-0'
            ]) ?>"></div>
            <h3 class="text-20px/1_2 font-medium mb-16px"><?= $item['label'] ?></h3>
            <p class="text-18px/1_6 text-neutral-dark/70"><?= $item['text'] ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>