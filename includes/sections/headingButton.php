<?php
$rootClass = '';
$rootAttr = '';

$link = $props['link'];

$title = $props['title'];
$title = preg_replace('/{(.*?)}/', "<strong>$1</strong>", $title);

$text = $props['text'];

$button = $props['button'] ?: [];
$buttonAccent = $props['button_accent'] ?: [];

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="relative bg-neutral/5 <?= $rootClass ?>" <?= $rootAttr ?>>
  <div class="py-40px lg:py-[120px] wrapper">
    <?php if (!empty($props['label'])) : ?>
      <div class="flex items-center gap-8px mb-24px ">
        <?php get_icon('slash', 'icon text-neutral-red'); ?>
        <p class="text-16px/1_6 lg:text-20px/1_5"><?= $props['label'] ?><?php if ($link): ?>
          <a
            href="<?= $link['url'] ?>"
            target="<?= $link['target'] ?? '_blank' ?>"
            class="font-medium hover:text-neutral-red transition-colors"><?= $link['title'] ?></a>
        <?php endif; ?>
        </p>
      </div>
    <?php endif; ?>
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-24px lg:gap-32px">
      <div class="w-full lg:w-[60%]">
        <h2 class="text-24px/1_4 lg:text-40px/1_4 heading"><?= $title ?></h2>
        <p class="text-16px/1_6 lg:text-20px/1_5 mt-4px"><?= $text ?></p>
      </div>
      <div class="w-full lg:w-[40%] flex lg:justify-end gap-20px [&_.custom-gradient-border]:after:bg-[#f3f3f3]">
        <?php if ($button): ?>
          <?php get_part('components/button', [
            'text' => $button['title'],
            'url' => $button['url'],
            'target' => $button['target'],
            'theme' => 'default',
          ]); ?>
        <?php endif; ?>
        <?php if ($buttonAccent): ?>
          <?php get_part('components/button', [
            'text' => $buttonAccent['title'],
            'url' => $buttonAccent['url'],
            'target' => $buttonAccent['target'],
            'theme' => 'red',
          ]); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>