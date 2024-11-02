<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

  $noImage = !$props['image'] ?? true;
  $smallText = $props['smallText'] ?? false;
?>
<div
  class="relative flex items-end p-24px lg:p-40px text-white group overflow-hidden<?= cx([
    $noImage ? ' bg-neutral' : '',
  ]); ?><?= $rootClass ?>"
  <?= $rootAttr ?>
>
  <div class="relative lg:translate-y-64px lg:group-hover:translate-y-0 transition-transform duration-300">
    <h3 class="text-20px/1_2 font-medium<?= cx([
      $smallText ? ' lg:text-24px/1_2 font-medium' : ' lg:text-40px/1_2 lg:font-regular',
    ]); ?>"><?= $props['title'] ?></h3>
    <p class="mt-12px text-16px/1_5<?= cx([
      $smallText ? ' lg:text-16px/1_5' : ' lg:text-18px/1_5'
    ]); ?>"><?= $props['text'] ?></p>
    <a href="<?= $props['url'] ?>" class="text-16px/1_5<?= cx([
      ' flex items-center gap-8px mt-40px font-medium lg:opacity-0',
      ' group-hover:opacity-100 hover:text-white/80 transition-all duration-300',
      $smallText ? ' lg:text-18px/1_2' : ' lg:text-20px/1_2',
    ]); ?>">
      <span><?= __('Dowiedz się więcej', 'bud-went'); ?></span>
      <span><?= get_icon('arrow-right'); ?></span>
    </a>
  </div>
  <?php if (isset($props['image'])) : ?>
  <div class="absolute top-0 left-0 w-full h-full z-[-1]">
    <?php get_part('components/picture', [
      'imgClass' => 'absolute top-0 left-0 w-full h-full z-[-1] object-cover w-full h-full',
      'sources' => [[
        'src' => $props['image'],
        'alt' => $props['title'],
      ]],
    ]); ?>
    <div class="w-full h-full bg-gradient-to-b from-black/15 to-black/70"></div>
  </div>
  <?php endif; ?>
</div>
