<?php

  namespace ThemeClasses\Settings;

  class Theme
  {
    public function __construct()
    {
      add_action('wp_loaded', [$this, 'registerScripts']);
      add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    public function registerScripts()
    {
      $distPath = THEME_URL . '/public/dist/';

      wp_register_style('theme_core_front_style', $distPath . 'core.css', [], '2024-09-10', false);
      wp_register_script('theme_core_front_script', $distPath . 'core.js', [], '2024-09-10', true);
    }

    public function enqueueScripts()
    {
      // dequeue gutenberg block library CSS
      wp_dequeue_style('wp-block-library');
      wp_dequeue_style('wp-block-library-theme');

      // enqueue theme css & js
      wp_enqueue_style('theme_core_front_style');
      wp_enqueue_script('theme_core_front_script');
    }
  }
