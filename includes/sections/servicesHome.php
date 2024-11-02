<?php
  $rootClass = '';
  $rootAttr = '';


  $categoryTerm = $props['category'] ?? null;
  $items = $props['items'] ?? [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section>
  


<?php



// $titlesServices = array_map(function($categoryTitle) {
//     return isset($categoryTitle->title) ? $categoryTitle->title : '';
// }, $servicesCategories);


$services = apply_filters('getServices', [], []);
// var_dump($services);

$servicesCategories = apply_filters('getServicesCategories', [], [ 
    'category' => $categoryTerm ? $categoryTerm->slug : null,
]);

foreach ($servicesCategories as $term) {
    // Retrieve the image URL stored in the custom field 'tax_image'.
    $image_url = get_term_meta($term->term_id, 'tax_image', true);

    // Add the image URL to the term object.
    $term->image_url = $image_url ? $image_url : null; // Use null or a placeholder if no image is set.
}

// Debug to see the updated terms with images.
var_dump($servicesCategories);

$servicesByCategory = [];
foreach ($services as $service) {
    $serviceCategoryId = $service['service-category'];
    
    if (!isset($servicesByCategory[$serviceCategoryId])) {
        $servicesByCategory[$serviceCategoryId] = [];
    }

    $servicesByCategory[$serviceCategoryId][] = $service;
}

// var_dump($servicesCategories);
// var_dump($servicesByCategory);
// var_dump($services);

?>


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
                    <!-- <div id="services-prev" class="swiper-button-prev"></div>
                    <div id="services-next" class="swiper-button-next"></div> -->
                </div>
                    <a class="link-btnxx fw-500 fs-16 lh-22" href="<?= $props['link']['url'] ?>">
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

                                <div id="<?= cx(['category-accordion-',$category->term_id]) ?>" class="<?= cx(['accordion-container accordion-services']) ?>">
                                <?php if (!empty($servicesByCategory)): ?>
                                    <?php foreach ($servicesByCategory as $k => $categoryItem): ?>
                                        
                                        <?php if ($category->term_id == (int)$categoryItem[0]['service-category']): ?>
                                            <div class="<?= cx(['ac']) ?>">
                                                <div class="<?= cx(['ac-header']) ?>">
                                                    <button type="<?= cx(['button']) ?>" class="<?= cx(['ac-trigger fw-500 fs-20 lh-24 color-101021']) ?>">
                                                        <?= $categoryItem[0]['title'] ?>
                                                    </button>
                                                </div>
                                                <div class="<?= cx(['ac-panel']) ?>">
                                                    <p class="<?= cx(['ac-text fw-400 fs-16 lh-24 color-101021']) ?>">
                                                    <?= $categoryItem[0]['desc'] ?>
                                                        <span>
                                                            <a class="<?= cx(['link-btnxx']) ?>" href="<?= $categoryItem[0]['url'] ?>">
                                                            <?= __('Produkty', 'jcc-solutions') ?>
                                                            </a>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </div>
                            </div>
                            <div class="<?= cx(['col-2']) ?>">
                                
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>

</section>


<div id="my-element">Hello World</div>



