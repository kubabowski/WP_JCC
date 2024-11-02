<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="relative<?= $rootClass ?>"<?= $rootAttr ?>>
  <div class="wrapper">
    <div class="relative">
      <?php get_part('components/contentTabs', [
        'active' => sanitize_title($props['tabs'][0]['title']),
        'items' => array_map(function($tab) {
          return [
            'label' => $tab['title'],
            'key' => sanitize_title($tab['title']),
            'content' => get_part('components/contactTabs/contactTabContent', [
              'items' => $tab['content'],
            ], false),
          ];
        }, $props['tabs']),
      ]); ?>
    </div>
  </div>
</section>