<?php
$rootClass = '';
$rootAttr = '';

$link = $props['link'];

$title = $props['title'];
$title = preg_replace('/{(.*?)}/', "<strong>$1</strong>", $title);

$text = $props['text'];

$footerOptions = get_field('footer_options', 'option') ?? [];
$footerSocialItems = $footerOptions['social_links'] ?? '';

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="relative bg-neutral/5 <?= $rootClass ?>" <?= $rootAttr ?>>
  <div class="py-40px lg:py-[120px] wrapper">
    <?php if (!empty($props['label'])) : ?>
      <div class="flex items-center gap-12px mb-24px ">
        <?php get_icon('slash', 'icon text-neutral-red'); ?>
        <p class="text-16px/1_6 lg:text-20px/1_5 text-neutral-gray">
          <?= $props['label'] ?>
        </p>
      </div>
    <?php endif; ?>
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-24px lg:gap-32px">
      <div class="w-full lg:w-[67%]">
        <h2 class="text-24px/1_4 lg:text-40px/1_4 heading"><?= $title ?></h2>
        <p class="text-16px/1_6 lg:text-20px/1_5 mt-4px"><?= $text ?></p>
      </div>
      <div class="w-full flex lg:justify-end lg:w-[33%] ">

        <ul class="flex gap-4px<?= $rootClass ?>" <?= $rootAttr ?>>
          <?php foreach ($footerSocialItems as $item): ?>
            <li class="block">
              <a
                href="<?= $item['link']['url'] ?>"
                target="<?= $item['link']['target'] ?? '_blank' ?>"
                class="<?= cx([
                          'flex items-center justify-center',
                          'size-56px text-20px/1',
                          'bg-neutral-red hover:hover:bg-neutral-red/80',
                          'transition-colors',
                        ]) ?>"><?php get_icon($item['icon'], 'icon text-white'); ?></a>
            </li>
          <?php endforeach; ?>
        </ul>

      </div>
    </div>
  </div>
</section>