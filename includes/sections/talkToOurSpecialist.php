<?php




  $rootClass = '';
  $rootAttr = '';

  $items = $props['items'] ?? [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

?>

<div class="container">
    <div class="talk-section">
        <img src="<?= $props['image']['url'] ?>" alt="<?= $props['image']['title'] ?>">
        <div class="text-container">
            <div class="relative">
                <div class="talk-text">
                    <h4 class="h3 fw-700 fs-24 lh-32"><?= $props['header_1'] ?></h4>
                    <h3 class="h4 fw-500 fs-20 lh-32"><?= $props['header_2'] ?></h3>
                    <p class="h5 fw-400 fs-16 lh-24"><?= $props['text'] ?></p>
                    <a class="btn btn-white fw-500 fs-16 lh-22" href="<?= $props['button']['url'] ?>" target="<?= $props['button']['target'] ?>">
                    <?= $props['button']['title'] ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
