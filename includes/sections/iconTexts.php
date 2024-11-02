<?php
$rootClass = '';
$rootAttr = '';

$items = $props['items'];

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="<?= $rootClass ?>" <?= $rootAttr ?>>
  <div class="wrapper py-96px">
    <div class="grid md:grid-cols-2 gap-32px">
      <?php foreach ($items as $item): ?>
        <div class="p-24px custom-gradient-border--no-hover">
          <div class="mb-24px text-[4rem]/1 md:text-[5rem]/1 text-neutral-gray">
            <?php get_icon($item['icon'] ?? 'empty', 'icon'); ?>
          </div>
          <p
            class="text-18px/1_6 md:text-20px/1_6 whitespace-pre-line"><?= $item['text'] ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>