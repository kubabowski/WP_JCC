<?php
  $menuItems = apply_filters('getMenuTree', [], 'footer_menu');
  $linksItems = apply_filters('getMenuTree', [], 'footer_links');

  $footerOptions = get_field('footer_options', 'option') ?? [];
  $footerButton = $footerOptions['button'] ?? [];
  $footerButtonAccent = $footerOptions['button_accent'] ?? [];

  $footerSocialItems = $footerOptions['social_links'] ?? '';
  $footerTime = $footerOptions['time'] ?? '';
  $footerCopy = $footerOptions['copy'] ?? '';

  // var_dump($footerOptions);
?>

<footer id="footer">

<?php
  get_part('sections/newsletter', [
    'title' => $footerOptions['newsletter_header'],
    'desc' => $footerOptions['newsletter_desc'],
  ]);
?>






<div class="inner bottom">
    <div class="container">
      <div class="col-1">
        <a class="footer-logo w-[80px] h-[35px] relative" href="/">
          <?php get_icon('logo-white', 'icon w-[80px] h-[35px] absolute logo-white'); ?>
        </a>
        
        <p>
            <?= $footerOptions['text'] ?>
        </p>

        <div class="flex contact">
            <div class="col-contact-1">
                <div>Phone</div>
                <div>Mail</div>
            </div>
            <div class="col-contact-2">
                <a href="tel:<?= $footerOptions['phone'] ?>"><?= $footerOptions['phone'] ?></a>
                <a href="mailto:<?= $footerOptions['mail'] ?>"><?= $footerOptions['mail'] ?></a>
            </div>
        </div>
        <div>
          <?php foreach($footerOptions['socials'] as $social): ?>
            <a class="social-icon" href="<?= $social['description']; ?>"> 
                <img width="40" height="40" src="<?= $social['url']; ?>" alt="<?= $social['alt']; ?>"> 
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
                    <a class="fw-400 fs-14 lh-20" href="<?php //echo $category["slug"] ?>">
                      <?php // echo $category["name"] ?>
                    </a>
                    </li>
              <?php // endforeach; //for now ?> -->
              
              <?php // foreach ($servicesCategories as $k => $category): ?>
                  <li>
                    <a class="fw-400 fs-14 lh-20" href="<?php //echo $category["slug"] ?>">
                    <?php // echo $category["name"] ?>s
                    </a>
                    </li>
              <?php // endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="bottom-row">
        <div class="container">
          <div><?= $footerOptions['copyright'] ?></div>
          <div class="align-center">
            <a class="footer-author fw-500 fs-12 lh-18" href="<?= $footerOptions['author']['url'] ?>"><?= $footerOptions['author']['title'] ?></a>
            <a class="scroll-top" onclick="scrollToTop()">
              <?php // include BASE_PATH . 'assets/icons/scroll-top.svg'; ?>
            </a>
          </div>
      </div>
    </div>
  </div>

















<?php 
// get_part('layout/footerMenu', [
//         'class' => 'mb-64px',
//         'items' => $menuItems,
//       ]); 
      
      ?>

<?php if ($footerSocialItems): ?>
  <?php
  //  get_part('layout/footerSocial', [
  //           'items' => $footerSocialItems,
  //         ]); 
          ?>
<?php endif; ?>


          
  

</footer>
