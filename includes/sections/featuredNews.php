<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

  $data = get_field('archive_options', 'option');
  $items = $data['knowledge_base']['posts'];
?>
<section class="relative pb-48px<?= $rootClass ?>"<?= $rootAttr ?>>
  <div class="wrapper">
    <div class="flex flex-col md:flex-row md:h-[580px]">
      <?php get_part('components/newsCard', [
        'class' => 'lg:w-[55%]',
        'title' => $items[0]->post_title,
        'text' => get_field('description', $items[0]->ID),
        'image' => get_the_post_thumbnail_url($items[0]->ID),
        'url' => get_permalink($items[0]->ID),
      ]); ?>
      <div class="flex flex-col lg:w-[45%]">
        <?php get_part('components/newsCard', [
          'class' => 'h-[50%]',
          'title' => $items[1]->post_title,
          'text' => get_field('description', $items[1]->ID),
          'image' => get_the_post_thumbnail_url($items[1]->ID),
          'url' => get_permalink($items[1]->ID),
          'smallText' => true,
        ]); ?>
        <?php get_part('components/newsCard', [
          'class' => 'h-[50%]',
          'title' => $items[2]->post_title,
          'text' => get_field('description', $items[2]->ID),
          'url' => get_permalink($items[2]->ID),
          'smallText' => true,
        ]); ?>
      </div>
    </div>
  </div>
</section>