<?php
  $rootClass = '';
  $rootAttr = '';

  $page = $props['page'] ?? 1;
  $backLink = get_post_type_archive_link('knowledge');

  $items = apply_filters('getKnowledges', [], [
    'with_pages'  => true,
    'page' => $page,
    'per_page' => 9,
  ]);

  $pages = $items['pages'] ?? 1;

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="pb-[5rem]<?= $rootClass ?>" <?= $rootAttr ?>>
  <div class="wrapper">
    <div class="flex flex-wrap gap-32px -mt-32px">
      <?php foreach ($items['items'] as $item) : ?>
        <div class="w-full lg:w-[calc(33.3333%-2rem)] lg:max-w-[33.3333%] flex-grow mt-32px group">
          <div class="w-full h-[271px] md:group-hover:h-[228px] transition-all">
            <?php get_part('components/picture', [
              'imgClass' => /*tw:*/'block w-full h-full object-cover',
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
              href="<?= $item['url'] ?>"
            >
              <span><?= __('Czytaj cały artykuł', 'bud-went') ?></span>
              <span><?= get_icon('arrow-right', 'icon') ?></span>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php get_part('components/pagination', [
      'class' => 'mt-32px',
      'page' => $page,
      'pages' => $pages,
    ]); ?>
  </div>
</section>