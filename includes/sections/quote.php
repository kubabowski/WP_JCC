<?php
$rootClass = '';
$rootAttr = '';

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

?>
<section class="<?= $rootClass ?>" <?= $rootAttr ?>>
  <div class="wrapper">
    <blockquote class="relative max-w-[882px] mx-auto">
      <span class="<?= cx([
                      'absolute -top-32px lg:top-20px -left-16px lg:-left-4px lg:-translate-x-full lg:-translate-y-full -z-10',
                      'text-neutral-red text-[65px] ',
                      'opacity-15 lg:opacity-100 pointer-events-none'
                    ]) ?>"><?php get_icon('quote', 'icon'); ?></span>
      <p class="text-24px/1_2 md:text-32px/1_2 italic font font-[300] "><?= $props['text']; ?></p>

      <?php if (isset($props['author'])) : ?>
        <footer class="mt-24px flex flex-row items-center text-16px/1_6 text-neutral-dark">
          <hr class="w-32px border-neutral-dark mr-16px"><?= $props['author']; ?>
        </footer>
      <?php endif; ?>
    </blockquote>
  </div>
</section>