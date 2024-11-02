<?php
  $count = count($props['items']) ?? 0;

  $sizes = cx([
    $count == 1 ? ' min-w-full' : null,
    $count == 2 ? ' min-w-[calc(50%-32px)]' : null,
    $count > 2 ? ' min-w-[calc(33.3333%-32px)]' : null,
  ]);
?>
<div class="flex gap-32px flex-wrap -mt-16px pb-96px mb-96px">
  <?php foreach ($props['items'] as $item) : ?>
    <div class="mt-64px<?= $sizes ?>">
      <h3 class="text-24px/1_2 font-medium"><?= $item['label'] ?></h3>
      <div class="mt-24px">
        <?php foreach ($item['info'] as $info) : ?>
          <div class="flex gap-16px mt-8px first:mt-0">
            <div class="text-20px/1_5 text-neutral/70 font-medium"><?= $info['name'] ?></div>
            <div class="text-20px/1_5 text-neutral/70"><?= $info['wartosc'] ?></div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="mt-20px">
        <p class="text-20px/1_5 font-medium"><?= $item['description'] ?></p>
      </div>
    </div>
  <?php endforeach; ?>
</div>