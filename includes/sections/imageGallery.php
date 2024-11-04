<?php
$rootClass = '';
$rootAttr = '';

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

?>
<section class="<?= $rootClass ?> my-40px md:my-[80px]" <?= $rootAttr ?>>
  <div class="wrapper">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-32px">
      <?php foreach ($props['images'] as $image) :  ?>

        <?php get_part('components/picture', [
          'imgClass' => /*tw:*/ 'block size-full object-cover',
          'sources' => [[
            'src' => $image['sizes']['square-lg'] ?? $image['url'],
            'width' => $image['width'],
            'height' => $image['height'],
            'alt' => $image['alt'] ?? __('Zdjęcie', 'jcc-solutions'),
          ]],
        ]); ?>

      <?php endforeach; ?>
    </div>

  </div>
</section>