<?php
  $menuItems = apply_filters('getMenuTree', [], 'footer_menu');
  $linksItems = apply_filters('getMenuTree', [], 'footer_links');

  $footerOptions = get_field('footer_options', 'option') ?? [];
  $footerButton = $footerOptions['button'] ?? [];
  $footerButtonAccent = $footerOptions['button_accent'] ?? [];

  $footerSocialItems = $footerOptions['social_links'] ?? '';
  $footerTime = $footerOptions['time'] ?? '';
  $footerCopy = $footerOptions['copy'] ?? '';
?>
<?= $footerOptions['name'] ?>
<?= $footerOptions['address'] ?>
<?= $footerOptions['phone'] ?>

<?php if ($footerButton): ?>

  <?php get_part('components/button', [
    'text' => $footerButton['title'],
    'url' => $footerButton['url'],
    'target' => $footerButton['target'] ?? '_self',
    'theme' => 'darkAlpha',
    'size' => 'small',
  ]); ?>
<?php endif; ?>

<?php get_part('layout/footerMenu', [
        'class' => 'mb-64px',
        'items' => $menuItems,
      ]); ?>

<?php if ($footerSocialItems): ?>
<?php get_part('layout/footerSocial', [
          'items' => $footerSocialItems,
        ]); ?>
<?php endif; ?>
<?php if ($footerButtonAccent): ?>
          
    <?php get_part('components/button', [
      'text' => $footerButtonAccent['title'],
      'url' => $footerButtonAccent['url'],
      'target' => $footerButtonAccent['target'] ?? '_self',
      'theme' => 'red',
      'size' => 'large',
    ]); ?>
<?php endif; ?>

<?php get_part('layout/footerLinks', [
      'class' => 'text-neutral-white',
      'items' => $linksItems,
    ]); ?>

    <div class="mt-24px md:mt-0">
      <p><?= $footerCopy ?></p>
      <p class="mt-4px"><?= __('Projekt i wdrożenie:', 'jcc-solutions') ?> <a href="https://crafton.pl" target="_blank" class="text-neutral-white hover:text-neutral-white/80 transition-colors">Crafton</a></p>
    </div>

