<?php
  $rootClass = '';
  $rootAttr = '';

  $items = $props['items'] ?: [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="<?= $rootClass ?>"<?= $rootAttr ?>>
  <div class="wrapper py-96px">
    <div class="max-w-[56rem] mx-auto">
      <?php get_part('components/contentTabs', [
        'active' => sanitize_title($items[0]['label'] ?? 0),
        'items' => array_map(function($item) {
          return [
            'label' => $item['label'],
            'key' => sanitize_title($item['label']),
            'content' => get_part('components/textSectionTab', [
              'content' => $item['content'],
            ], false),
          ];
        }, $items),
      ]); ?>
    </div>
  </div>
</section>