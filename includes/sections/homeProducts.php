<?php
  $rootClass = '';
  $rootAttr = '';


  $categoryTerm = $props['category'] ?? null;
  $items = $props['items'] ?? [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];


$products = apply_filters('getProducts', [], []);


var_dump($products);


?>


<section>
<div class="products-home">
    <div class="container container-lg">`

        <h2 class="products-section-title fw-400 fs-36 lh-44"><?= $props['title'] ?></h2>
        <p class="products-section-desc fs-400 fs-18 lh-32"><?= $props['description'] ?></p>
        <div class="flex-container">
            <?php
            foreach ($products as $product): ?>
            <?php $img = $product['data']['image_1'] ? $product['data']['image_1']['url'] : "" ?>
                <div class="col">
                    <div class="product">
                        <div class="product-image" style="background-image: url('<?php echo $img ?>')">
<!--                            <img src="--><?php //echo $logoUrl; ?><!--" alt="--><?php //echo $logoAlt; ?><!--" class="product-logo" />-->
                        </div>
                        <div class="product-desc-container">
                            <h3 class="product-name fw-700 fs-14 lh-14">OUR PRODUCT - <?php echo $product['title']; ?></h3>
                            <p class="product-desc color-000030 fw-500 fs-28 lh-36"><?php echo $product['data']['description']; ?></p>
                            <p class="fw-400 fs-16 lh-24"><?php echo $product['data']['texts']['text_1']; ?></p>
                            <a class="link-btn fw-500 fs-16 lh-22" href="<?php echo $product['url']; ?>">
                                Read more
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</section>





