<?php
  $menuItems = apply_filters('getMenuTree', [], 'header_menu');

  $headerOptions = get_field('header_options', 'option') ?? [];
  $headerButton = $headerOptions['button'] ?? [];
?>

<header
  id="header"
  class=""
  data-header
>

<div class="container">
    <nav>
        <div class="nav-container">
            <a class="header-logo w-[80px] h-[35px] relative" href="/">
              <?php get_icon('logo-color', 'icon w-[80px] h-[35px] absolute logo-color'); ?>
              <?php get_icon('logo-white', 'icon w-[80px] h-[35px] absolute logo-white'); ?>
            </a>
            
            <?php get_part('layout/headerMenu', [
              'class' => '',
              'items' => $menuItems,
            ]); ?>
            
        </div>
        <div class="nav-btns">
            <a class="lang-choose" href=#>
                <?php get_icon('lang-pl', 'icon w-[80px] h-[35px]'); ?>
                <?php get_icon('lang-en', 'icon w-[80px] h-[35px]'); ?>
                <span class="fw-500 fs-14 lh-24px">PL</span>
            </a>
            <?php if ($headerButton): ?>
              <a
                href="<?= $headerButton['url'] ?>"
                class="<?= cx([
                  'hidden md:flex items-center',
                  'min-h-[66px] px-20px py-8px',
                  'text-16px/1_25 font-medium',
                  'custom-gradient-border',
                  'transition-colors ',
                ]) ?>"
              ><?= $headerButton['title'] ?></a>
            <?php endif; ?>
            <button
              type="button"
              class=""
              data-mobile-menu-button
            ><?php get_icon('menu', 'icon'); ?></button>

            <?php get_part('layout/mobileMenu', [
              'items' => $menuItems,
            ]); ?>
        </div>
    </nav>
</div>

</header>