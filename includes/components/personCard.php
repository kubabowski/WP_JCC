<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<div class="personCard<?= $rootClass ?>"<?= $rootAttr ?>>
  <div class="personCard__inner">
    <div class="personCard__image">
      <img src="<?= $props['image'] ?>" class="personCard__avatar" />
    </div>
    <div class="personCard__content">
      <h3 class="personCard__title"><?= $props['title'] ?></h3>
      <p class="personCard__description"><?= $props['description'] ?></p>
    </div>
  </div>
</div>
