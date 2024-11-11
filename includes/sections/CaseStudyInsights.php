<?php
  $rootClass = '';
  $rootAttr = '';


  $categoryTerm = $props['category'] ?? null;
  $items = $props['items'] ?? [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];


$caseStudies = apply_filters('getCaseStudys', [], []);


$insights = apply_filters('getInsights', [], []);

$services = apply_filters('getServices', [], []);


?>

<section id="homeCaseInsight">
    <div class="casestudy">
        <div class="container">
            <h2 class="h2 fw-400 fs-36 lh-44"><?= $props['title'] ?></h2>
            <div class="inner">
            <div class="col-1">
                <div id="casestudy-swiper" class="swiper mySwiper">
                    <div id="casestudy-pagination" class="swiper-pagination"></div>
                    <div class="swiper-wrapper">

                        <?php foreach($caseStudies as $caseStudy): ?>


                            <div class="swiper-slide">
                                <div class="slide-content">
                                    <div class="case-image" style="background-image: url('<?php echo $caseStudy['data']['image_1']['url']; ?>')"></div>
                                    <div class="case-card-home">
                                        <div class="case-badge fw-700 fs-12 lh-14">CASE STUDY</div>
                                        <h3 class="case-title fw-500 fs-20 lh-28 color-000030"><?php echo $caseStudy['title']; ?></h3>
                                        <div class="case-info">
                                            <p class="case-date fw-500 fs-12 lh-14 color-000030"><?php echo $caseStudy['date']; ?> -</p>
                                            <p class="case-read fw-500 fs-12 lh-14">9 MIN READ</p>
                                        </div>
                                        <h4 class="case-desc color-101021 fw-400 fs-16 lh-24"><?php echo $caseStudy['data']['description']; ?></h4>

                                        <a class="link-btn fw-500 fs-16 lh-22" href="<?php echo $caseStudy['url']; ?>">Read more</a>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-2 insight-col">
            <?php foreach($insights as $insight): ?>

                <div class="insight-card">
                    <div class="case-badge fw-700 fs-12 lh-14">INSIGHTS</div>
                    <h3 class="case-title color-000030 fw-500 fs-20 lh-28"><?php echo $insight['title']; ?></h3>

                    <div class="case-info">
                        <p class="case-date fw-500 fs-12 lh-14 color-000030"><?php echo $insight['date']; ?> -</p>
                        <p class="case-read fw-500 fs-12 lh-14">9 MIN READ</p>
                    </div>
                    <a class="link-btn fw-500 fs-16 lh-22" href="<?php echo $insight['url'] ?>">Read more</a>
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





