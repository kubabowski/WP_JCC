<?php
  $rootClass = '';
  $rootAttr = '';

  $items = $props['items'] ?? [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section id="trust_quality_innovation">
  
    <div class="container">
        <div class="trust-section">
            <div class="col-1">
                <h3 class="h2 color-000030 fw-400 fs-36 lh-44"><?= $props['header_1'] ?></h3>
                <div class="line"></div>
                <p class="h6 color-000030 fw-400 fs-14 lh-14"><?= $props['text_1'] ?></p>
                <p class="h6 badge color-000030 fw-400 fs-14 lh-14"><?= $props['text_2'] ?></p>
                <p class="color-000030 fw-400 lh-96 fs-96"><?= $props['text_3'] ?></p>
            </div>

            <div class="col-2">
                <h3 class="h2 color-000030 fw-400 fs-36 lh-44"><?= $props['header_2'] ?></h3>
                <p class="h5 color-101021 fw-400 fs-16 lh-24"><?= $props['text_4'] ?></p>
                <a class="btn btn-blue btn-lg fw-500 fs-16 lh-22" 
                    href="<?= $props['button']['url'] ?>" 
                    target="<?= $props['button']['target'] ?>">
                    <?= $props['button']['title'] ?>
                </a>
            </div>
        </div>
    </div>

</section>


<?php

// error_log('Applying getProducts filter');



// $itemsProducts = apply_filters('getProducts', [], [
// ]);
// var_dump($itemsProducts);

// var_dump("======================================");

// $itemsServices = apply_filters('getServices', [], [
//     'per_page' => 4,
    
// ]);
// var_dump($itemsServices);


// $serviceController = new \ThemeClasses\Controller\Service();
// $services = $serviceController->getPosts([], [
//     'per_page' => 4,
// ]);
// var_dump($services);
?>