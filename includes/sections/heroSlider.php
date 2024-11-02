<?php
  $slider = get_field('heroSlider');

  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

  if (is_array($slider)):
?>
<section class="heroSlider<?= $rootClass ?>" data-hero-slider<?= $rootAttr ?>>
  <div class="heroSlider__inner container">
    <div class="heroSlider__side">
      <div class="heroSlider__images">
        <?php foreach ($slider as $index =>  $item) : ?>
        <?php
          $itemClass = '';
          if ($index === 0) $itemClass .= ' heroSlider__image--active';
        ?>
        <div class="heroSlider__image<?= $itemClass ?>" data-hero-slider-image>
          <img
            class="heroSlider__img"
            src="<?= $item['image']['sizes']['square-lg'] ?>"
            alt="<?= $item['image']['alt'] ?>"
          />
        </div>
        <?php endforeach; ?>
      </div>
      <?php if (count($slider) > 1): ?>
      <div class="heroSlider__arrows">
        <button
          class="heroSlider__arrow heroSlider__arrow--next"
          data-hero-slider-next
        ></button>
        <button
          class="heroSlider__arrow heroSlider__arrow--prev"
          data-hero-slider-prev
        ></button>
      </div>
      <?php endif; ?>
    </div>
    <div class="heroSlider__main">
      <div class="heroSlider__items" data-hero-slider-items>
        <?php foreach ($slider as $index => $item) : ?>
        <?php
          $itemClass = '';
          if ($index === 0) $itemClass .= ' heroSlider__item--active';
        ?>
        <div class="heroSlider__item<?= $itemClass ?>" data-hero-slider-item>
          <?php get_part('components/textBox', [
            'class' => 'heroSlider__text',
            'theme' => 'hero',
            'title' => $item['title'] ?? null,
            'text' => $item['text'] ?? null,
            'button' => $item['button'] ?? null,
          ]); ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php
  endif;