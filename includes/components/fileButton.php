<?php
$item = $props['item'] ?? [];
?>

<?php if ($item) : ?>
  <a
    class="py-24px px-20px inline-flex gap-10px items-center justify-center text-neutral-dark custom-gradient-border"
    download="<?= $item['file']['filename'] ?>"
    href="<?= $item['file']['url'] ?>"
    target="_blank">
    <?php if ($item['file']['subtype'] === 'pdf'): ?>
      <?php get_icon('pdf', 'icon'); ?>
    <?php endif; ?>
    <span class="font-medium text-20px/1 "><?= $item['file']['title']; ?></span>
  </a>
<?php endif; ?>