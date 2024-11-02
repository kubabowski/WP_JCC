<?php
  $rootClass = '';
  $rootAttr = '';

  $items = apply_filters('getKnowledges', [], [
    'with_pages'  => false,
  ]);

  $button = $props['button'] ?: [
    'title' => __('Pokaż wszystkie artykuły', 'bud-went'),
    'url' => get_post_type_archive_link('knowledge'),
  ];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="<?= $rootClass ?>"<?= $rootAttr ?>>
  <div class="wrapper">
    <div class="py-40px md:pt-[80px] md:pb-96px">
      <h2 class="text-48px/1_2 lg:text-72px/1_2"><?= $props['title'] ?></h2>
      <div class="flex items-center gap-[45px] mt-24px lg:mt-[45px]">
        <div class="hidden md:block w-full h-[1px] bg-neutral"></div>
        <?php get_part('components/button', [
          'class' => /*tw:*/'whitespace-nowrap md:mt-0',
          'text' => $button['title'],
          'url' => $button['url'],
          'theme' => 'dark',
        ]); ?>
      </div>
      <div class="swiper -mx-16px mt-40px md:mt-[81px] overflow-hidden" data-basic-slider>
        <div class="swiper-wrapper flex">
          <?php foreach ($items['items'] as $item) : ?>
            <div class="swiper-slide px-16px min-w-full lg:min-w-[33.3333%] group">
              <div class="w-full h-[271px] md:group-hover:h-[228px] transition-all">
                <?php get_part('components/picture', [
                  'imgClass' => /*tw:*/'block size-full object-cover',
                  'sources' => [[
                    'src' => $item['image'],
                    'width' => 384,
                    'height' => 271,
                    'alt' => 'thumbnail',
                  ]],
                ]); ?>
              </div>
              <div class="flex flex-col mt-24px overflow-hidden">
                <h3 class="text-24px/1_2 font-medium"><?= $item['title'] ?></h3>
                <p class="text-18px/1_5 text-neutral-gray mt-[21px]"><?= $item['text'] ?></p>
                <a
                  class="<?= cx([
                    'flex items-center gap-8px text-16px/1_2 font-medium mt-24px md:translate-y-[43px] w-fit',
                    'group-hover:translate-y-0 hover:text-neutral/80 transition-transform',
                  ]) ?>"
                  href="<?= $item['url'] ?>"
                >
                  <span><?= __('Czytaj cały artykuł', 'bud-went') ?></span>
                  <span><?= get_icon('arrow-right', 'icon') ?></span>
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="flex items-center justify-between mt-48px md:mt-24px lg:mt-40px mx-16px">
          <div class="relative">
            <button
              class="flex items-center justify-center size-48px lg:size-72px text-[24px] lg:text-[30px] border-neutral border-[1px] transition-opacity"
              data-basic-slider-prev
            >
              <?php get_icon('arrow-left', 'icon'); ?>
            </button>
          </div>
          <div class="flex flex-col gap-[1px] size-[60px]">
            <div class="text-16px/1_2 font-bold mr-auto" data-basic-slider-current></div>
            <div class="mx-auto">
              <?php get_icon('slash', 'icon text-neutral/20'); ?>
            </div>
            <div class="text-16px/1_2 ml-auto" data-basic-slider-total></div>
          </div>
          <div class="relative">
            <button
              class="flex items-center justify-center size-48px lg:size-72px text-[24px] lg:text-[30px] border-neutral border-[1px] transition-opacity"
              data-basic-slider-next
            >
              <?php get_icon('arrow-right', 'icon'); ?>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>