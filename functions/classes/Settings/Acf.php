<?php

  namespace ThemeClasses\Settings;

  class Acf
  {
    public function __construct()
    {
      add_filter('acf/location/rule_match/page_type', [$this, 'matchValueForFrontPage'], 10, 4);
      // add_filter('acf/load_field/name=themeIcon', [$this, 'getThemeIconsList'], 10, 1);
      // add_filter('acf/load_field/name=themeColor', [$this, 'getThemeColorsList'], 10, 1);
    }

    public function matchValueForFrontPage($match, $rule, $options, $field_group)
    {
      if (
        $rule['param'] != 'page_type' ||
        $rule['operator'] != '==' ||
        $rule['value'] != 'front_page' ||
        (isset($options['post_type']) && $options['post_type'] != 'page')
      ) return $match;

      $pageId = isset($options['post_id']) ? $options['post_id'] : -1;
      $frontPageId = get_option('page_on_front');

      if (function_exists('pll_get_post')) $frontPageId = pll_get_post($frontPageId);

      if ($pageId == $frontPageId) return 1;

      return $match;
    }

    public function getThemeIconsList($field)
    {
      if ($field['type'] !== 'select') return $field;

      if (is_admin()) {
        $screen = get_current_screen();
        if ($screen !== null && $screen->post_type === 'acf-field-group') return $field;
      }

      $field['choices'] = $this->getIconsFromScss();

      // $field['choices'] = [
      //   'eye' => 'eye',
      //   'diamond-arrow-up' => 'diamond-arrow-up',
      //   'diamond-arrow-down' => 'diamond-arrow-down',
      //   'diamond-arrow-left' => 'diamond-arrow-left',
      //   'diamond-arrow-right' => 'diamond-arrow-right',
      //   'diamond-cross' => 'diamond-cross',
      //   'arrow-left' => 'arrow-left',
      //   'arrow-right' => 'arrow-right',
      //   'chevron-up' => 'chevron-up',
      //   'chevron-down' => 'chevron-down',
      //   'globe' => 'globe',
      //   'units' => 'units',
      //   'box' => 'box',
      //   'exchange' => 'exchange',
      //   'twitter' => 'twitter',
      //   'linkedin' => 'linkedin',
      //   'instagram' => 'instagram',
      //   'youtube' => 'youtube',
      // ];

      return $field;
    }

    private function getIconsFromScss()
    {
      // $fileString = file_get_contents(THEME_DIR . 'src/scss/settings/icons.scss', true);

      // $fileString = preg_replace('/\s/im', '', $fileString);
      // $fileString = preg_replace('/\'/im', '', $fileString);
      // $fileString = preg_replace('/^(.*?\()(.*)(\).*?)$/im', '$2', $fileString);
      // $icons = array_map(function($itemString) {
      //   return explode(':', $itemString)[0];
      // }, array_filter(explode(',', $fileString), function($itemString) {
      //   return ($itemString !== '');
      // }));

      $icons = [];

      // map flat array to associative array
      $iconsArr = [];
      foreach ($icons as $icon) {
        $iconsArr[$icon] = $icon;
      }

      return $iconsArr;
    }

    public function getThemeColorsList($field)
    {
      if ($field['type'] !== 'select') return $field;

      if (is_admin()) {
        $screen = get_current_screen();
        if ($screen !== null && $screen->post_type === 'acf-field-group') return $field;
      }

      $field['choices'] = [
        '#000000' => 'black',
        '#FFFFFF' => 'white',
        '#4F008C' => 'purple',
        '#FF375E' => 'pink',
        '#FF6A39' => 'red',
        '#00C48C' => 'green',
        '#1DCED8' => 'blue',
        '#FFDD40' => 'yellow',
      ];

      return $field;
    }
  }
