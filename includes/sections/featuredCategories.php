<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="relative py-40px lg:py-[80px]<?= $rootClass ?>"<?= $rootAttr ?>>
  <div class="flex wrapper flex-col gap-24px lg:gap-0 lg:flex-row lg:items-end lg:justify-between">
    <h2 class="text-48px/1_2 lg:text-72px/1_2 whitespace-pre-line"><?= $props['title'] ?></h2>
    <div class="relative">
      <?php get_part('components/button', [
        'title' => $props['button']['title'],
        'target' => $props['button']['target'],
        'url' => $props['button']['url'],
        'theme' => 'dark',
      ]); ?>
    </div>
  </div>
  <div class="flex flex-col-reverse lg:flex-row gap-32px mt-[80px] wrapper">
    <div class="flex flex-col gap-32px min-w-[40%]">
      <?php foreach ($props['categories'] as $category) : ?>
        <div class="border-b-[1px] border-border-gray pb-32px last:border-b-0">
          <a
            href="<?= $category['link']['url'] ?>"
            target="<?= $category['link']['target'] ?>"
            class="relative flex items-center gap-24px py-16px group"
          >
            <div class="flex text-32px">
              <?php
                get_icon(
                  $category['icon'],
                  'icon fill-transparent stroke-default/70 group-hover:stroke-default transition-all',
                );
              ?>
            </div>
            <h3 class="text-36px/1_2 lg:text-40px/1_2 text-neutral/70 group-hover:text-neutral transition-colors">
              <?= $category['link']['title'] ?>
            </h3>
            <span class="<?= cx([
              'absolute top-[50%] right-0 translate-y-[-50%] text-32px opacity-0',
              'group-hover:opacity-100 transition-opacity',
            ]); ?>">
              <?php get_icon(
                'arrow-right',
                'icon icon--transparent',
                'style="stroke-width: 1px"'
              ); ?>
            </span>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="relative -mr-wrapper-space">
      <img
        class="w-[100%] h-[100%] object-cover"
        src="<?= $props['image']['url'] ?>"
        alt="<?= $props['image']['title'] ?>"
      >
    </div>
  </div>
</section>