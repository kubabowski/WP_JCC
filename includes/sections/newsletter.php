<?php
  $rootClass = '';
  $rootAttr = '';

  $title = $props['title'] ?? '';
  $title = preg_replace('/{(.*?)}/', "<strong>$1</strong>", $title);

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

?>


<div class="inner top">
    <div class="container">
      <div class="newsletter-text">
        <h3 class="header color-000030 fw-500 fs-28 lh-36"><?= $props['title'] ?></h3>
        <p class="color-000030 fs-16 lh-24"><?= $props['desc'] ?></p>
      </div>
      <div class="newsletter-input-container">
        <div class="newsletter-input">
            <!-- <form id="newsletterForm">
                <input name="email-newsletter" id="emailNewsletter" placeholder="<?php // echo $newsletterPlaceHolder ?>" />
                <button class="btn btn-blue btn-lg fw-500 fs-14 lh-24" type="submit">Subscribe</button>
            </form>
            
            <div id="responseMessage"></div> -->
            
            
        </div>
      </div>
    </div>
  </div>