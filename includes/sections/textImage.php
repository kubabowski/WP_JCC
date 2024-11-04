<?php
  $rootClass = '';
  $rootAttr = '';

  $bgColor = $props['bg_color'] ?? '';
  $isDark = $bgColor === 'dark';

  $isReversed = $props['reversed'] ?? false;

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section
  class="<?= cx([
    'relative py-40px md:py-[120px]',
    $isDark ? 'bg-neutral text-white' : 'bg-neutral/5'
  ]); ?><?= $rootClass ?>"
  <?= $rootAttr ?>
>
  <div class="wrapper">
    <div class="<?= cx([
      'flex flex-col md:items-start gap-24px md:gap-48px lg:gap-96px',
      $isReversed ? 'md:flex-row-reverse' : 'md:flex-row'
    ]); ?>">
      <div class="<?= cx([
        'relative md:-my-[151px] w-full',
        $isReversed ? 'md:w-[68%]' : 'md:w-[49%]'
      ]) ?>">
        <?php get_part('components/picture', [
          'imgClass' => /*tw:*/'block w-full h-auto md:h-[600px] object-cover',
          'sources' => [[
            'src' => $props['image']['sizes']['square-lg'] ?? $props['image']['url'],
            'width' => $props['image']['width'],
            'height' => $props['image']['height'],
            'alt' => $props['image']['alt'] ?? __('Schemat produktu', 'jcc-solutions'),
          ]],
        ]); ?>
      </div>
      <div class="relative md:w-[55%]">
        <h2
          class="<?= cx([
            'text-48px/1_2 md:text-72px/1_2 whitespace-pre-line',
            $isDark ? 'text-white' : 'text-neutral'
          ]); ?>"
        ><?= $props['title'] ?></h2>
        <p
          class="<?= cx([
            'text-20px/1_5 max-w-[440px] mt-24px md:mt-40px',
            $isDark ? 'text-white/50' : 'text-neutral/70'
          ]); ?>"
        ><?= $props['text'] ?></p>
        <div class="flex items-center gap-32px mt-24px md:mt-72px">
          <div class="<?= cx([
            (isset($props['link']) && !empty($props['link'])) ? 'pr-32px border-r-[1px]' : '!border-none',
            $isDark ? 'border-white/10' : 'border-neutral/10'
          ]) ?>">
            <?php get_part('components/button', [
              'text' => $props['button']['title'],
              'url' => $props['button']['url'],
              'theme' => 'red',
            ]); ?>
          </div>
          <?php if (isset($props['link'])) : ?>
            <a href="<?= $props['link']['url'] ?? '#' ?>" class="<?= cx([
              'underline',
              $isDark ? 'text-white hover:text-white/90' : 'text-neutral hover:text-neutral/80'
            ]) ?>"><?= $props['link']['title'] ?? '' ?></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>