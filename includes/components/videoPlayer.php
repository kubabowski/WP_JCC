<?php
  $rootClass = '';
  $rootAttr = '';

  // TODO: refactor later

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<div
  class="videoPlayer<?= $rootClass ?>"
  data-player
  <?= $rootAttr ?>
>
  <div class="videoPlayer__wrapper" data-player-wrapper>
    <img
      class="videoPlayer__thumbnail"
      src="<?= $props['thumbnail']['sizes']['full-hd'] ?>"
      alt="<?= $props['thumbnail']['alt'] ?>"
      data-player-thumbnail
    />
    <div class="videoPlayer__play" data-player-play-btn></div>
    <iframe
      src="<?= $props['url'] ?>?autoplay=1&mute=1"
      class="videoPlayer__video"
      allowfullscreen
      data-player-video
    ></iframe>
  </div>
</div>