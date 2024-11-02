<?php

  namespace ThemeClasses\Controller;

  class OptionsPage
  {
    public function __construct()
    {
      add_filter('getOptions', [$this, 'getOptionsByFilter'], 10, 3);
    }

    public function getOptionsByFilter($options, $optionsTaxSlug, $lang = null)
    {
      return static::getOptions($options, $optionsTaxSlug, $lang);
    }

    static public function getOptions($options, $optionsTaxSlug, $lang = null)
    {
      $optionsPageId = static::getOptionsPageId($optionsTaxSlug, $lang);
      $options = get_fields($optionsPageId);

      return $options;
    }

    static public function getOptionsPageId($optionsTaxSlug, $customLang = null)
    {
      $lang = ($customLang != null) ? (
        $customLang
      ) : (
        apply_filters('getCurrentLang', null)
      );

      $optionPage = get_posts([
        'post_type' => 'optionspage',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'tax_query' => [
          [
            'taxonomy' => 'optionsgroup',
            'field' => 'slug',
            'terms' => $optionsTaxSlug,
          ],
        ],
      ]);

      if (count($optionPage) && isset($optionPage[0])) {
        $optionPageId = $optionPage[0]->ID;
        return (function_exists('pll_get_post') ? (
          pll_get_post($optionPageId, $lang)
        ) : $optionPageId);
      }

      return null;
    }
  }
