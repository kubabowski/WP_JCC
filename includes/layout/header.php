<?php
  $menuItems = apply_filters('getMenuTree', [], 'header_menu');

  $headerOptions = get_field('header_options', 'option') ?? [];
  $headerButton = $headerOptions['button'] ?? [];
?>
<header
  id="header"
  class="fixed flex flex-col top-0 left-0 w-full h-100vh invisible z-30"
  data-header
>
  <div
    class="absolute top-0 left-0 w-full min-h-header-height invisible"
    data-header-space
    data-scroll-to-header
  ></div>

  <div class="flex-shrink-0 relative visible bg-neutral-white border-b border-border-menu">
    <div class="wrapper 2xl:w-full flex gap-32px items-center h-header-height">
      <a href="<?= home_url('/'); ?>" class="block me-auto">
        <?php get_icon('logo-color', 'icon w-[132px] h-[33px]'); ?>
      </a>

      <?php get_part('layout/headerMenu', [
        'class' => 'hidden xl:flex',
        'items' => $menuItems,
      ]); ?>

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
    </div>
  </div>

  <div class="">
    

    <?php get_part('layout/mobileMenu', [
      'items' => $menuItems,
    ]); ?>

    <?php /* get_part('layout/submenu', [
      'class' => 'header__submenu',
      'items' => $menuItems,
    ]); */ ?>
  </div>
</header>
