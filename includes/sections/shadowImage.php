<?php
$rootClass = '';
$rootAttr = '';

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

?>
<section class="<?= $rootClass ?>" <?= $rootAttr ?>>
  <div class="wrapper pb-24px lg:pb-64px relative ">
    <?php get_part('components/picture', [
      'imgClass' => /*tw:*/ 'block size-full max-w-[904px] object-cover',
      'sources' => [[
        'src' => $props['image']['sizes']['square-lg'] ?? $props['image']['url'],
        'width' => $props['image']['width'],
        'height' => $props['image']['height'],
        'alt' => $props['image']['alt'] ?? __('Zdjęcie', 'bud-went'),
      ]],
    ]); ?>
    <div class="<?= cx([
                  'absolute bottom-0 -right-12px lg:right-0 -z-10',
                  'w-full max-w-[55%] ',
                  'bg-neutral-dark pointer-events-none'
                ]) ?>"><span class="block pb-[70%]"></span></div>
  </div>
</section>