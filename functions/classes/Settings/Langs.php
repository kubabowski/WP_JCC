<?php

  namespace ThemeClasses\Settings;

  class Langs
  {
    public static $textDomain = THEME_DOMAIN; // theme name

    public function __construct()
    {
      add_action('after_setup_theme', [$this, 'setTextdomain']);
      add_filter('getMoFilePath', [$this, 'getMoFilePath']);
      add_filter('getCurrentLang', [$this, 'getCurrentLang']);
      add_filter('getDefaultLang', [$this, 'getDefaultLang']);
      add_filter('getLangs', [$this, 'getLangs']);
    }

    public function setTextdomain()
    {
      // load_theme_textdomain(static::$postTypeName, get_template_directory() . '/langs');
      load_theme_textdomain(static::$textDomain); // default wp-content/languages/themes
    }

    // public function getMoFilePath($locale = 'en_US')
    public function getMoFilePath($locale = DEFAULT_LOCALE)
    {
      // return get_template_directory() . '/langs/'. $locale . '.mo';
      return WP_CONTENT_DIR . '/languages/themes/' . static::$textDomain . '-' . $locale . '.mo';
    }

    public function getCurrentLang($lang)
    {
      return function_exists('pll_current_language') ? pll_current_language() : $lang;
    }

    public function getDefaultLang($lang)
    {
      return function_exists('pll_default_language') ? pll_default_language() : $lang;
    }

    public function getLangs($langs)
    {
      if (!function_exists('pll_the_languages')) return $langs;

      $allLangs = pll_the_languages([
        'raw' => 1,
        'echo' => 0,
      ]);

      $currentLang = null;
      $otherLangs = [];

      foreach ($allLangs as $lang) {
        if ($lang['current_lang'] === true) {
          $currentLang = $lang;
          continue;
        }

        $otherLangs[] = $lang;
      }

      return [
        'current' => $currentLang,
        'others' => $otherLangs,
        'all' => $allLangs,
      ];
    }
  }
