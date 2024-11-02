<?php
  $rootClass = '';
  $rootAttr = '';

  $set1 = $props['set_1'] ?? [];
  $set2 = $props['set_2'] ?? [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="<?= $rootClass ?>"<?= $rootAttr ?>>
  <div class="bg-neutral-dark text-neutral-white">
    <div class="wrapper md:flex items-center">
      <div class="md:w-1/2 py-32px md:pt-48px md:pb-96px md:pe-128px relative">
        <div class="hidden lg:block w-px absolute -top-64px -bottom-32px end-96px bg-gradient-to-b from-neutral-white/0 via-neutral-white/40 to-neutral-white/0"></div>
        <div class="hidden lg:block h-px absolute top-0 -start-48px -end-48px bg-gradient-to-r from-neutral-white/0 via-neutral-white/40 to-neutral-white/0"></div>
        <h2
          class="text-40px/1_2 whitespace-pre-line"
        ><?= $set1['title'] ?></h2>
        <p
          class="text-20px/1_6 whitespace-pre-line mt-16px text-neutral-white/80"
        ><?= $set1['text'] ?></p>
      </div>
      <div class="max-w-2/3 md:max-w-auto ms-auto md:w-1/2">
        <div class="relative z-10 md:-mt-24px md:-mb-48px md:-ms-16px">
          <?php get_part('components/picture', [
            'imgClass' => /*tw:*/'block w-full h-auto',
            'sources' => [[
              'src' => $set1['image']['sizes']['square-sm'] ?? $set1['image']['url'],
              'width' => $set1['image']['width'],
              'height' => $set1['image']['height'],
              'alt' => $set1['image']['alt'] ?? '',
            ]],
          ]); ?>
        </div>
      </div>
    </div>
  </div>
  <div>
    <div class="wrapper md:flex items-center flex-row-reverse">
      <div class="md:w-1/2 py-32px md:pt-64px md:pb-48px md:ps-128px">
        <h2
          class="text-32px/1_2 md:text-40px/1_2 whitespace-pre-line"
        ><?= $set2['title'] ?></h2>
        <p
          class="text-20px/1_6 whitespace-pre-line mt-16px text-neutral-dark/70"
        ><?= $set2['text'] ?></p>
      </div>
      <div class="max-w-2/3 md:max-w-auto md:w-1/2">
        <div class="relative z-10 md:-mb-24px md:-mt-96px md:-me-48px">
          <?php get_part('components/picture', [
            'imgClass' => /*tw:*/'block w-full h-auto',
            'sources' => [[
              'src' => $set2['image']['sizes']['square-sm'] ?? $set2['image']['url'],
              'width' => $set2['image']['width'],
              'height' => $set2['image']['height'],
              'alt' => $set2['image']['alt'] ?? '',
            ]],
          ]); ?>
        </div>
      </div>
    </div>
  </div>
</section>