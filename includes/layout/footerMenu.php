<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<nav class="<?= $rootClass ?>"<?= $rootAttr ?>>
  <ul class="sm:columns-2 md:columns-3 lg:columns-2 xl:columns-3 gap-32px 2xl:gap-64px">
    <?php foreach ($props['items'] as $item): ?>
    <?php
      $hasChildren = count($item['children']) > 0;

      $itemLinkClass = ' ' . cx([
        $item['active']
          ? 'text-neutral-white font-medium'
          : 'text-neutral-white hover:text-neutral-white/90 transition-colors',
      ]);
    ?>
    <li class="block mb-40px break-inside-avoid">
      <a
        href="<?= $item['url'] ?>"
        target="<?= $item['target'] ?>"
        class="inline-block mb-32px text-20px/1_2<?= $itemLinkClass ?>"
      >
        <span><?= $item['name'] ?></span>
      </a>
      <?php if ($hasChildren): ?>
        <ul>
        <?php foreach ($item['children'] as $subitem): ?>
          <?php
            $subitemLinkClass = ' ' . cx([
              $subitem['active']
                ? 'text-neutral-white/80 font-medium'
                : 'text-neutral-white/40 hover:text-neutral-white/60 transition-colors',
            ]);
          ?>
          <li class="block mb-16px">
            <a
              href="<?= $subitem['url'] ?>"
              target="<?= $subitem['target'] ?>"
              class="text-16px/1_6 <?= $subitemLinkClass ?>"
            >
              <span><?= $subitem['name'] ?></span>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </li>
    <?php endforeach; ?>
  </ul>
</nav>


<footer id="footer">
  <div class="inner top">
    <div class="container">
      <div class="newsletter-text">
        <h3 class="header color-000030 fw-500 fs-28 lh-36"><?php echo $newsletterHeader ?></h3>
        <p class="color-000030 fs-16 lh-24"><?php echo $newsletterDesc ?></p>
      </div>
      <div class="newsletter-input-container">
        <div class="newsletter-input">
            <form id="newsletterForm">
                <input name="email-newsletter" id="emailNewsletter" placeholder="<?php echo $newsletterPlaceHolder ?>" />
                <button class="btn btn-blue btn-lg fw-500 fs-14 lh-24" type="submit">Subscribe</button>
            </form>
            
            <div id="responseMessage"></div>
            
            
        </div>
      </div>
    </div>
  </div>
  <div class="inner bottom">
    <div class="container">
    <div class="col-1">
      <a class="footer-logo" href="#">
        <?php include BASE_PATH . 'assets/images/logo.svg'; ?>
      </a>

      <p>
          <?php echo $footerText; ?>
      </p>
      <div class="flex contact">
          <div class="col-contact-1">
              <div><?php echo $phoneTitle; ?></div>
              <div><?php echo $mailTitle; ?></div>
          </div>
          <div class="col-contact-2">
              <a href="<?php echo $phoneUrl; ?>"><?php echo $phoneValue; ?></a>
              <a href="<?php echo $mailUrl; ?>"><?php echo $mailValue; ?></a>
          </div>
      </div>
      <div>
        <?php foreach($socials as $social): ?>
          <a class="social-icon" href="<?php echo $social['description']; ?>"> 
              <img width="40" height="40" src="<?php echo $social['url']; ?>" alt="<?php echo $social['alt']; ?>"> 
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="col-2">
      <div class="footer-main-content">
        <div class="flex footer-nav">
          <ul>
            
            <li class="footer-nav-title fw-400 fs-12 lh-20">JCC-Solutions</li>
            
            <?php get_part('layout/headerMenu', [
              'class' => '',
              'items' => $menuItems,
            ]); ?>
          </ul>
          <ul>
          <li class="footer-nav-title fw-400 fs-12 lh-20">Our services</li>
            <!-- <?php // foreach ($footerServices as $k => $category): ?>
                <li>
                  <a class="fw-400 fs-14 lh-20" href="<?php echo $category["slug"] ?>">
                    <?php // echo $category["name"] ?>
                  </a>
                  </li>
            <?php // endforeach; //for now ?> -->
            
            <?php foreach ($servicesCategories as $k => $category): ?>
                <li>
                  <a class="fw-400 fs-14 lh-20" href="<?php echo $category["slug"] ?>">
                  <?php echo $category["name"] ?>
                  </a>
                  </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
    </div>
    <div class="bottom-row">
        <div class="container">
          <div><?php echo $footerCopy ?></div>
          <div class="align-center">
            <a class="footer-author fw-500 fs-12 lh-18" href="<?php echo $footerAuthor["url"] ?>"><?php echo $footerAuthor["title"] ?></a>
            <a class="scroll-top" onclick="scrollToTop()">
              <?php include BASE_PATH . 'assets/icons/scroll-top.svg'; ?>
            </a>
          </div>
      </div>
    </div>
  </div>

  
</footer>