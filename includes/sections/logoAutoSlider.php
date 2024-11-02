<?php
$rootClass = '';
$rootAttr = '';

if (isset($props['reversed']) && $props['reversed']) $rootAttr .= ' dir="rtl"';

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

$partners = get_field('partners_options', 'option');
?>
<section class="relative<?= $rootClass ?>" <?= $rootAttr ?> data-logo-auto-slider>
  <div class="swiper" data-logo-auto-slider-slider>
    <div class="swiper-wrapper flex py-40px ease-linear">
      <?php foreach ($partners as $partner) : ?>
        <div class="swiper-slide h-[54px] px-40px shrink-0 group">
          <?php if ($partner['link'] && $partner['link']['url']) : ?>
            <a href="<?= $partner['link']['url'] ?>" target="<?= $partner['link']['target'] ?>">
            <?php endif; ?>
            <img
              class="<?= cx([
                        'w-100 h-100 object-fit',
                        'grayscale opacity-15 group-hover:grayscale-0 group-hover:opacity-100',
                        'transition-all duration-300',
                      ]); ?>"
              src="<?= $partner['image']['url'] ?>"
              alt="<?= $partner['image']['title'] ?>">
            <?php if ($partner['link'] && $partner['link']['url']) : ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>