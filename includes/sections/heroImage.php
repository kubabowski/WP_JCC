<?php
$rootClass = '';
$rootAttr = '';

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="relative<?= $rootClass ?>" <?= $rootAttr ?>>
  <div class="w-full h-[749px]">
    <img
      class="size-full object-cover"
      src="<?= $props['image']['url'] ?>"
      alt="<?= $props['image']['title'] ?>">
  </div>
  <div class="absolute bottom-[-1px] left-0 w-full z-1">
    <div class="md:fixed right-0 md:translate-y-[calc(-100%-2px)] z-10 flex flex-col items-end gap-[2px] mb-[2px]">
      <?php foreach ($props['menu'] as $item) : ?>
        <div class="relative w-64px h-64px bg-neutral-dark group">
          <a
            href="<?= $item['link']['url'] ?>"
            target="<?= $item['link']['url'] ?>"
            class="<?= cx([
                      'absolute top-0 left-0 bg-neutral-dark flex items-center text-20px/1_5 w-fit',
                      'group-hover:translate-x-[-100%] transition-transform duration-500',
                    ]); ?>">
            <span class="<?= cx([
                            'p-16px pr-0 h-64px text-white whitespace-nowrap',
                            'opacity-0 group-hover:opacity-100 hover:text-white/80',
                            'transition-opacity duration-500',
                          ]); ?>"><?= $item['link']['title'] ?></span>
          </a>
          <span class="absolute top-0 right-0 p-16px flex text-32px text-white">
            <?php get_icon($item['icon'], 'icon') ?>
          </span>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="bg-neutral-dark overflow-hidden">
      <div class="relative wrapper">
        <div class="hidden lg:block absolute top-0 left-[-112px]">
          <img src="<?= THEME_URL ?>/public/images/hero-decor.svg" alt="hero decor" class="">
        </div>
        <div class="flex flex-col md:flex-row gap-24px md:gap-0 py-48px md:items-end justify-between">
          <h1 class="text-48px/1_2 lg:text-72px/1_2 text-white whitespace-pre-line"><?= $props['title'] ?></h1>
          <div class="flex items-center">
            <p class="text-16px/1_25 text-white whitespace-pre-line"><?= $props['text'] ?></p>
            <div class="border-l-[1px] border-white/20 pl-32px ml-32px">
              <?php get_part('components/button', [
                'title' => $props['button']['title'],
                'target' => $props['button']['target'],
                'url' => $props['button']['url'],
                'theme' => 'red',
              ]); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>