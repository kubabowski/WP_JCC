<?php
  $items = $props['items'] ?? [];
?>
<div>
  <h3
    class="text-24px/1_2 font-medium mb-24px"
  ><?= __('Pliki do pobrania', 'jcc-solutions') ?></h3>
  <ul class="block">
    <?php foreach ($items as $item): ?>
      <li class="block">
        <a
          class="inline-flex items-center gap-8px text-link hover:text-neutral-dark transition-color"
          href="<?= $item['file']['url'] ?>"
          download="<?= $item['file']['filename'] ?>"
        >
          <?php if ($item['file']['subtype'] === 'pdf'): ?>
            <span
              class="text-24px/1 text-neutral-gray"
            ><?php get_icon('pdf', 'icon'); ?></span>
          <?php endif; ?>
          <span class="font-medium text-16px/1_2"><?= $item['file']['title'] ?? $item['file']['name'] ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
