<?php
$rootClass = '';
$rootAttr = '';

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

$title = $props['title'] ?? '';

$items = apply_filters('getKnowledges', [], [
  'with_pages'  => false,
  'per_page' => 3,
  'post__not_in' => [get_the_ID()],
]);

$button = $props['button'] ?: [
  'title' => __('Pokaż wszystkie artykuły', 'jcc-solutions'),
  'url' => get_post_type_archive_link('knowledge'),
];

?>
<section class="<?= $rootClass ?> py-48px md:pt-96px md:pb-[120px] bg-neutral-dark/5" <?= $rootAttr ?>>

  <div class="wrapper">
    <header class="flex flex-col gap-36px">
      <?php if ($title) : ?>
        <h1 class="text-48px/1_2 md:text-72px/1_2"><?= $title; ?></h1>
      <?php endif; ?>

      <div class="flex items-center gap-[45px]">
        <div class="hidden md:block w-full h-[1px] bg-neutral"></div>
        <?php get_part('components/button', [
          'class' => /*tw:*/ 'whitespace-nowrap md:mt-0',
          'text' => $button['title'],
          'url' => $button['url'],
          'theme' => 'dark',
        ]); ?>
      </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-32px mt-40px md:mt-[80px]">
      <?php foreach ($items['items'] as $item) : ?>
        <div class="w-full flex-grow group">
          <div class="w-full h-[271px] md:group-hover:h-[228px] transition-all">
            <?php get_part('components/picture', [
              'imgClass' => /*tw:*/ 'block w-full h-full object-cover',
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
                        'flex items-center gap-8px text-16px/1_2 font-medium mt-24px lg:translate-y-[43px] w-fit',
                        'group-hover:translate-y-0 hover:text-neutral/80 transition-transform',
                      ]) ?>"
              href="<?= $item['url'] ?>">
              <span><?= __('Czytaj cały artykuł', 'jcc-solutions') ?></span>
              <span><?= get_icon('arrow-right', 'icon') ?></span>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>

</section>