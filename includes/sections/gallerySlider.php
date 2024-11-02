<?php
  $rootClass = '';
  $rootAttr = '';

  $items = $props['items'] ?? [];
  $type = $props['type'] ?? 'default';
  $isThin = $type === 'thin';
  $loop = $props['loop'] ?? true;

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section
  class="<?= cx([
    'py-40px md:py-96px',
    !$isThin ? 'md:pt-[40px]' : null, // it should not be related with type
    $isThin ? 'overflow-hidden' : null,
    $rootClass,
  ]) ?>"
  <?= $rootAttr ?>
>
  <div class="wrapper">

    <div
      class="<?= cx([
        $isThin ? 'max-w-[56rem] mx-auto' : null,
        !$isThin ? 'overflow-hidden' : null,
      ]) ?>"
    >

      <div
        class="<?= cx([
          'swiper',
          $isThin ? '-ms-16px md:-ms-32px' : null,
        ]) ?>"
        data-basic-slider
        <?= $isThin ? 'data-basic-slider-thin' : '' ?>
        <?= $loop ? 'data-basic-slider-loop="1"' : '' ?>
      >
        <div class="flex swiper-wrapper">
          <?php foreach ($props['items'] as $item) : ?>
            <div
              class="<?= cx([
                'swiper-slide',
                'flex-shrink-0 w-full flex',
                $isThin ? 'ps-16px md:ps-32px ' : null,
              ]) ?>"
            >
              <div class="flex-shrink-0 w-full h-0 pt-1/2 relative">
                <?php get_part('components/picture', [
                  'imgClass' => /*tw:*/'block absolute top-0 left-0 size-full object-cover',
                  'sources' => [[
                    'src' => $item['image']['sizes']['full-hd'] ?? $item['image']['url'],
                    'width' => $item['image']['width'],
                    'height' => $item['image']['height'],
                    'alt' => $item['image']['alt'] ?? __('Obrazek w galerii', 'bud-went'),
                  ]],
                ]); ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="<?= cx([
          'flex items-center justify-between',
          'mt-24px lg:mt-40px',
          $isThin ? 'ps-32px' : null,
        ]) ?>">
          <button
            class="flex items-center justify-center size-48px lg:size-72px text-[24px] lg:text-[30px] border-neutral border-[1px] transition-opacity"
            data-basic-slider-prev
          ><?php get_icon('arrow-left', 'icon',); ?></button>
          <div class="flex flex-col gap-[1px] size-[60px]">
            <div class="text-16px/1_2 font-bold mr-auto" data-basic-slider-current>01</div>
            <div class="mx-auto">
              <?php get_icon('slash', 'icon stroke-neutral/20', 'style="stroke-width:1px"'); ?>
            </div>
            <div class="text-16px/1_2 ml-auto" data-basic-slider-total>01</div>
          </div>
          <button
            class="flex items-center justify-center size-48px lg:size-72px text-[24px] lg:text-[30px] border-neutral border-[1px] transition-opacity"
            data-basic-slider-next
          ><?php get_icon('arrow-right', 'icon'); ?></button>
        </div>
      </div>
    </div>
  </div>
</section>