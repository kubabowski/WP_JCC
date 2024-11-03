<?php
  $rootClass = '';
  $rootAttr = '';

 $Services = get_field('servicesOptions', 'option') ?? [];


  $categoryTerm = $props['category'] ?? null;
  $items = $props['items'] ?? [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section>

<div class="hero-categories-spacer-bg" style="background-image: url('<?= $Services['hero_image']['url'] ?>')"></div>
  





</section>





