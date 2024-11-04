<?php
  $items = $props['items'] ?? [];
?>
<?php foreach ($items as $item): ?>
<div class="mb-40px last:mb-0">
  <h3
    class="font-medium text-18px/1_6 mb-24px"
  ><?= $item['label'] ?></h5>
  <div class="flex gap-64px">
    <?php if ($item['image']): ?>
      <div class="flex-shrink-0 max-w-1/3">
        <?php get_part('components/picture', [
          'imgClass' => /*tw:*/'block w-full h-auto',
          'sources' => [[
            'src' => $item['image']['sizes']['square-lg'] ?? $item['image']['url'],
            'width' => $item['image']['width'],
            'height' => $item['image']['height'],
            'alt' => $item['image']['alt'] ?? __('Schemat produktu', 'jcc-solutions'),
          ]],
        ]); ?>
      </div>
    <?php endif; ?>

    <?php
      $data = $item['data'];
      $data = \ThemeClasses\Controller\Product::parseWysiwyg($data);
    ?>
    <div class="flex-grow min-w-0 wysiwyg">
      <?= $data ?>
    </div>
  </div>
</div>
<?php endforeach; ?>
