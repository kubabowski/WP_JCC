<?php
  $rootClass = '';
  $rootAttr = '';


  $categoryTerm = $props['category'] ?? null;
  $items = $props['items'] ?? [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

    $products = apply_filters('getProducts', [], []);

    $services = apply_filters('getServices', [], []);



//apply_filters('getMenuTree', [], 'header_menu');
    // var_dump($services);

    $servicesCategories = apply_filters('getServicesCategories', [], [
        'category' => $categoryTerm ? $categoryTerm->slug : null,
    ]);

    foreach ($servicesCategories as $term) {
        $image_id = get_term_meta($term->term_id, 'tax_image', true);
        $image_url = wp_get_attachment_url($image_id);

        $term->image_url = $image_url ? $image_url : null;
    }

//
//error_log(print_r($services, true));
//error_log(print_r($servicesCategories, true));

?>

<section>
<div id="homeServices" class="services">
    <div class="container">
        <h3 class="h5 fw-900 fs-20 lh-32 color-000030"><?= $props['title'] ?></h3>
        <h3 class="h2 header fw-400 fs-36 lh-44 color-000030"><?= $props['header'] ?></h3>

        <div class="nav-row">
            <div class="col-1">
                <div thumbsSlider="" id="services-swiper-thumbs" class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($servicesCategories as $k => $category): ?>
                            <div class="<?= cx(['swiper-slide cat-tab']) ?>" >
                                <h4 class="<?= cx(['cat-name fw-500 fs-16 lh-20']) ?>" ><?= esc_html($category->name) ?> </h4>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-2 flex-between align-center">
                <div class="flex">
                     <div id="services-prev" class="swiper-button-prev"></div>
                    <div id="services-next" class="swiper-button-next"></div>
                </div>
                <a class="link-btn fw-500 fs-16 lh-22" href="<?= $props['link']['url'] ?>">
                    <?= $props['link']['title'] ?>
                </a>
            </div>
        </div>


        <div id="services-swiper" class="swiper mySwiper">
            <div class="swiper-wrapper">

                <?php foreach ($servicesCategories as $k => $category): ?>

                    <div class="<?= cx(['swiper-slide']) ?>" >
                        <div class="<?= cx(['slide-content']) ?>">
                            <div class="<?= cx(['col-1']) ?>">

                                <div id="accordion-services-<?php echo $category->term_id ?>" class="<?= cx(['accordion-container accordion-services']) ?>">

                                    <?php foreach ($services as $k => $serviceItem): ?>
                                        <?php if ($category->term_id == (int)$serviceItem['item-category'][0]->term_id): ?>
                                            <div class="<?= cx(['ac']) ?>">

                                                <div class="<?= cx(['ac-header']) ?>">
                                                    <button type="<?= cx(['button']) ?>" class="<?= cx(['ac-trigger fw-500 fs-20 lh-24 color-101021']) ?>">
                                                        <?= $serviceItem['title'] ?>
                                                    </button>
                                                </div>
                                                <div class="<?= cx(['ac-panel']) ?>">
                                                    <p class="<?= cx(['ac-text fw-400 fs-16 lh-24 color-101021']) ?>">
                                                        <?= strip_tags($serviceItem['desc']) ?>
                                                        <span>
                                                            <a class="<?= cx(['link-btn']) ?>" href="<?= $serviceItem['url'] ?>">
                                                            <?= __('Produkty', 'jcc-solutions') ?>
                                                            </a>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                            <div class="<?= cx(['col-2']) ?>">
                                <div class="<?= cx(['cat-tab']) ?>" >
                                    <img
                                    class="<?= cx(['services-img']) ?>"
                                    src="<?= $category->image_url ?>"
                                >
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>

</section>


