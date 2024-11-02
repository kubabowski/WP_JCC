<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="relative bg-default/5 py-48px<?= $rootClass ?>"<?= $rootAttr ?>>
  <div class="wrapper">
    <div class="flex">
      <?php get_part('components/picture', [
        'imgClass' => /*tw:*/'block h-auto',
        'sources' => [[
          'src' => $props['image']['sizes']['square-lg'] ?? $props['image']['url'],
          'width' => $props['image']['width'],
          'height' => $props['image']['height'],
          'alt' => $props['image']['alt'] ?? __('Obrazek', 'bud-went'),
        ]],
      ]); ?>
    </div>
  </div>
</section>