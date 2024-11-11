<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=2.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php wp_title(); ?></title>
  <?php /*
  <title><?= $siteTitle ?></title>
  <meta name="description" content="<?= $siteDesc ?>">
  */ ?>

  <?php
    // https://realfavicongenerator.net/
    $faviconUrl = THEME_URL . '/public/images/favicon/';
  ?>
  <link rel="apple-touch-icon" sizes="180x180" href="<?= $faviconUrl ?>apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= $faviconUrl ?>favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= $faviconUrl ?>favicon-16x16.png">
  <link rel="manifest" href="<?= $faviconUrl ?>site.webmanifest">
  <link rel="mask-icon" href="<?= $faviconUrl ?>safari-pinned-tab.svg" color="#00654a">
  <link rel="shortcut icon" href="<?= $faviconUrl ?>favicon.ico">
  <meta name="apple-mobile-web-app-title" content="G20">
  <meta name="application-name" content="G20">
  <meta name="msapplication-TileColor" content="#00654a">
  <meta name="msapplication-config" content="<?= $faviconUrl ?>browserconfig.xml">
  <meta name="theme-color" content="#00654a">
<!--  <script src="--><?//= THEME_URL.'public/dist/core.js' ?><!--"></script>-->

  <?php wp_head(); ?>

  <?php if (defined('GOOGLE_ANALYTICS_ID')): ?>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?= GOOGLE_ANALYTICS_ID ?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '<?= GOOGLE_ANALYTICS_ID ?>');
  </script>
  <?php endif; ?>
  <?php if (is_user_logged_in()): ?>
  <!-- auto hide wp admin bar -->
  <style>
    #wpadminbar {
      opacity: 0;
      transform: translateY(-24px);
      transition: opacity 0.2s, transform 0.2s;
    }
    #wpadminbar:hover {
      opacity: 1;
      transform: translateY(0);
    }
    html {
      margin-top: 0 !important;
    }
  </style>
  <?php endif; ?>
</head>
<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <?php
    get_part('layout/icons');
    get_part('layout/header');
