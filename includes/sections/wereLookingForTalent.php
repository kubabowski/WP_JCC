<?php
  $rootClass = '';
  $rootAttr = '';


  $categoryTerm = $props['category'] ?? null;
  $items = $props['items'] ?? [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section>
  
<div class="container container-lg">
    <div class="talent-section">
        <div class="col-1">
            <div class="talent-img" style="background-image: url('<?= $props['image']['url'] ?>')"></div>
        </div>
        <div class="col-2">
            <div class="talent-text">
                <h3 class="talent-header-1 fw-500 fs-20 lh-32 color-000030"><?= $props['header_1'] ?></h3>
                <h4 class="talent-header-2 fs-400 fs-36 lh-44 color-000030"><?= $props['header_2'] ?></h4>
                <p class="talent-desc fw-400 fs-16 lh-24 color-101021"><?= $props['text'] ?></p>
                <a class="btn btn-blue btn-lg fw-500 lh-22 fs-16" href="<?= $props['button']['url'] ?>" target="<?= $props['button']['target'] ?>">
                <?= $props['button']['title'] ?>
                </a>
            </div>
        </div>
    </div>
</div>




</section>





