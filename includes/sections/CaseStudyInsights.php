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
    // $image_url = get_term_meta($term->term_id, 'tax_image', true);
    $image_id = get_term_meta($term->term_id, 'tax_image', true);
    
    $image_url = wp_get_attachment_url($image_id);

    // Add the image URL to the term object.
    $term->image_url = $image_url ? $image_url : null; // Use null or a placeholder if no image is set.
}

// Debug to see the updated terms with images.
// var_dump($servicesCategories);

$servicesByCategory = [];
foreach ($services as $service) {
    $serviceCategoryId = $service['service-category'];
    
    if (!isset($servicesByCategory[$serviceCategoryId])) {
        $servicesByCategory[$serviceCategoryId] = [];
    }

    $servicesByCategory[$serviceCategoryId][] = $service;
}

?>


<div class="casestudy">
    <div class="container">
        <h2 class="h2 fw-400 fs-36 lh-44"><?= $props['title'] ?></h2>
        <div class="inner">
        <div class="col-1">
            <div id="casestudy-swiper" class="swiper mySwiper">
                <div id="casestudy-pagination" class="swiper-pagination"></div>
                <div class="swiper-wrapper">

                    <?php foreach($caseStudyData as $caseStudy): ?>
                        <?php 
                            $title = $caseStudy['acf']['title'];
                            $desc = $caseStudy['acf']['desc'];
                            $date = $caseStudy['acf']['date'];
                            $imageUrl = isset($caseStudy['acf']['image']['url']) ? $caseStudy['acf']['image']['url'] : '';
                            $link = $caseStudy['link'];
                        ?>

                        <div class="swiper-slide">
                            <div class="slide-content">
                                <div class="case-image" style="background-image: url('<?php echo $imageUrl; ?>')"></div>
                                <div class="case-card-home">
                                    <div class="case-badge fw-700 fs-12 lh-14">CASE STUDY</div>
                                    <h3 class="case-title fw-500 fs-20 lh-28 color-000030"><?php echo $title; ?></h3>
                                    <div class="case-info">
                                        <p class="case-date fw-500 fs-12 lh-14 color-000030"><?php echo $date; ?> -</p>
                                        <p class="case-read fw-500 fs-12 lh-14">9 MIN READ</p>
                                    </div>
                                    <h4 class="case-desc color-101021 fw-400 fs-16 lh-24"><?php echo $desc; ?></h4>
                                    
                                    <a class="link-btn fw-500 fs-16 lh-22" href="<?php echo $link; ?>">Read more</a>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-2 insight-col">
        <?php foreach($insightsData as $insight): ?>
            <?php 
                $title = $insight['acf']['title'];
                $desc = $insight['acf']['desc'];
                $date = $insight['acf']['date'];
                $link = $insight['link'];
            ?>
            <div class="insight-card">
                <div class="case-badge fw-700 fs-12 lh-14">INSIGHTS</div>
                <h3 class="case-title color-000030 fw-500 fs-20 lh-28"><?php echo $title; ?></h3>
                
                <div class="case-info">
                    <p class="case-date fw-500 fs-12 lh-14 color-000030"><?php echo $date; ?> -</p>
                    <p class="case-read fw-500 fs-12 lh-14">9 MIN READ</p>
                </div>
                <a class="link-btn fw-500 fs-16 lh-22" href="<?php echo $link; ?>">Read more</a>
            </div>
        <?php endforeach; ?>
        </div>
        </div>
        <div class="inner">
        <div class="col-1 nav-col">
            <div class="swiper-nav">
            <div id="study-prev" class="swiper-button-prev"></div>
            <div id="study-next" class="swiper-button-next"></div>
            </div>
            <a href="#" class="link-btn fw-500 fs-16 lh-22">All case study</a>
        </div>
        <div class="col-2 nav-col">
            <a href="#" class="link-btn fw-500 fs-16 lh-22">All insights</a>
        </div>
        </div>
    </div>
</div>

</section>





