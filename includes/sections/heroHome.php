<?php
  $slider = get_field('heroHome');

  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];



$slider = $props['hero_slider'];


?>




<div class="hero">
    <div id="hero-swiper" class="swiper mySwiper">
        <div class="swiper-wrapper">
            <?php foreach ($slider as $k => $slide): ?>
                <div class="<?= cx([ 'swiper-slide' ]) ?>">
                    <div class="<?= cx([ 'swiper-inner h-[100%]' ]) ?>" style="background-image: url('<?php echo isset($slide["image"]["url"]) ? $slide["image"]["url"] : ''; ?>')">
                        <div class="text">
                            <div class="container">
                                <h2 class="header fw-500 fs-56 lh-64">
                                    <?php echo isset($slide["header"]) ? $slide["header"] : ''; ?>
                                </h2>

                                <div class="description fw-400 fs-18 lh-30">
                                    <?php echo isset($slide["desc"]) ? $slide["desc"] : ''; ?>
                                </div>

                                <?php if (isset($slide["button"]["title"])): ?>
                                    <a href="<?php echo isset($slide["button"]["url"]) ? $slide["button"]["url"] : '#'; ?>" class="btn btn-blue btn-lg fw-500 fs-16 lh-22">
                                        <?php echo $slide["button"]["title"]; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container">                        
        <div id="hero-pagination" class="swiper-pagination"></div>
    </div>
</div>