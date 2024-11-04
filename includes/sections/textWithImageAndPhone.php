<?php
$rootClass = '';
$rootAttr = '';

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>

<section
  class="<?= cx([
            'relative bg-neutral-dark/5',
          ]); ?><?= $rootClass ?>"
  <?= $rootAttr ?>>
  <div class="wrapper">
    <div class="<?= cx([
                  'flex flex-col md:flex-row items-center md:gap-48px lg:gap-96px ',
                ]); ?>">

      <div class="flex-none relative py-40px md:w-[41%]">
        <h2
          class="<?= cx([
                    'text-36px/1_2 md:text-40px/1_2  whitespace-pre-line text-neutral',
                  ]); ?>"><?= $props['title'] ?>
        </h2>
        <p
          class="<?= cx([
                    'text-20px/1_5 mt-16px text-neutral/70',
                  ]); ?>"><?= $props['text'] ?>
        </p>

        <?php if ($props['phone']): ?>
          <a
            href="tel:<?= $props['phone'] ?>"
            class="inline-flex items-center gap-16px group mt-32px">
            <span
              class="<?= cx([
                        'flex items-center justify-center size-[68px] text-32px/1',
                        'bg-neutral-dark/5 group-hover:bg-neutral-dark/30',
                        'transition-colors',
                      ]) ?>"><?php get_icon('phone', 'icon'); ?></span>
            <span class="text-24px/1_2 font-medium"><?= $props['phone'] ?></span>
          </a>
        <?php endif; ?>
      </div>
      <div class="<?= cx([
                    'relative w-full',
                  ]) ?>">
        <?php get_part('components/picture', [
          'imgClass' => /*tw:*/'block w-full h-auto md:-my-36px md:h-[571px] object-cover',
          'sources' => [[
            'src' => $props['image']['sizes']['square-lg'] ?? $props['image']['url'],
            'width' => $props['image']['width'],
            'height' => $props['image']['height'],
            'alt' => $props['image']['alt'] ?? __('Zdjęcie produktu', 'jcc-solutions'),
          ]],
        ]); ?>
      </div>
    </div>
  </div>
</section>