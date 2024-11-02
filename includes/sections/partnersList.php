<?php
$rootClass = '';
$rootAttr = '';

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

$partners = get_field('partners_options', 'option');
?>
<section class="relative pb-96px<?= $rootClass ?>" <?= $rootAttr ?>>
  <div class="wrapper">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-32px gap-y-48px">
      <?php foreach ($partners as $partner) : ?>
        <div class="flex flex-col lg:flex-row text-center lg:text-left items-center gap-16px min-w-[calc(50%-32px)]">
          <div class="py-10px w-[40%]">
            <img src="<?= $partner['image']['url'] ?>" alt="<?= $partner['title'] ?>" class="w-full h-full object-cover">
          </div>
          <div class="w-full h-[1px] lg:w-[1px] lg:h-full bg-gradient-to-r lg:bg-gradient-to-b from-neutral-white/0 via-neutral/40 to-neutral-white/0"></div>
          <div class="w-[60%]">
            <h3 class="text-18px/1_5 font-medium"><?= $partner['title'] ?></h3>
            <?php if ($partner['link'] && $partner['link']['url']) : ?>
              <a
                class="text-16px/1_5 text-neutral/70 font-medium underline hover:text-neutral/50 transition-colors"
                href="<?= $partner['link']['url'] ?>"
                target="<?= $partner['link']['target'] ?>">
                <?= $partner['link']['title'] ?>
              </a>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>