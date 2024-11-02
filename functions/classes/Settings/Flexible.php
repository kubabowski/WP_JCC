<?php

  namespace ThemeClasses\Settings;

  class Flexible
  {
    public function __construct()
    {
      add_filter('acf/fields/flexible_content/layout_title/name=sections', [$this, 'replaceSectionsTitle'], 10, 4);
      add_filter('acf/load_field/name=sections', [$this, 'addStaticSectionsFields'], 10, 1);
    }

    public function replaceSectionsTitle($title, $field, $layout, $i)
    {
      if ($field['type'] !== 'flexible_content') return $title;

      $sectionTitle = get_sub_field('title');
      if (empty($sectionTitle)) return $title;

      $sectionTitle = esc_html(str_replace('<br />', ' ', $sectionTitle));
      $title .= ' <b>(' . $sectionTitle . ')</b>';

      $sectionDisabled = get_sub_field('sectionDisabled');
      if (empty($sectionDisabled) || $sectionDisabled === '0') return $title;

      $title = '<strike>' . $title . '</strike> - (disabled)';

      return $title;
    }

    public function addStaticSectionsFields($field)
    {
      if ($field['type'] !== 'flexible_content') return $field;

      if (is_admin()) {
        $screen = get_current_screen();
        if ($screen !== null && $screen->post_type === 'acf-field-group') return $field;
      }

      foreach ($field['layouts'] as $layoutKey => $layout) {
        $field['layouts'][$layoutKey]['sub_fields'] = array_merge([
          $this->getFieldOptions([
            'key' => 'field_section_settings',
            'label' => 'General section settings',
            'type' => 'accordion',
            'open' => 0,
            'multi_expand' => 0,
            'endpoint' => 0,
          ]),
          $this->getFieldOptions([
            'key' => 'field_section_disabled',
            'label' => 'Disable section',
            'name' => 'sectionDisabled',
            'type' => 'true_false',
            'default_value' => false,
            'message' => 'Disable section on the website',
          ]),
          // $this->getFieldOptions([
          //   'key' => 'field_section_margin_top',
          //   'label' => 'Margin top',
          //   'name' => 'sectionMarginTop',
          //   'type' => 'true_false',
          //   'default_value' => false,
          //   'message' => 'Add top section margin',
          // ]),
          // $this->getFieldOptions([
          //   'key' => 'field_section_margin_bottom',
          //   'label' => 'Margin bottom',
          //   'name' => 'sectionMarginBottom',
          //   'type' => 'true_false',
          //   'default_value' => false,
          //   'message' => 'Add bottom section margin',
          // ]),
          $this->getFieldOptions([
            'key' => 'field_section_content',
            'label' => 'Section content',
            'type' => 'accordion',
            'open' => 1,
            'multi_expand' => 0,
            'endpoint' => 0,
          ]),
        ], $layout['sub_fields']);
      }
      return $field;
    }

    private function getFieldOptions($customOptions = [])
    {
      return array_merge([
        'key' => '',
        'label' => '',
        'name' => '',
        'type' => '',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => '',
          'id' => '',
        ],
        'default_value' => '',
        '_name' => $customOptions['name'] ?? '',
      ], $customOptions);
    }
  }
