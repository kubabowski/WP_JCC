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

            <?php get_part('components/langSwitcher', [
              'class' => 'header-lang',
            ]); ?>

            <?php if ($headerButton): ?>
              <a
                href="<?= $headerButton['url'] ?>"
                class="<?= cx([' btn btn-blue fw-500 fs-16 ']) ?>"
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