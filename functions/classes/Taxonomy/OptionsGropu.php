<?php

  namespace ThemeClasses\Taxonomy;

  class OptionsGropu
  {
    public function __construct()
    {
      add_action('init', [$this, 'registerTaxonomy']);
    }

    public function registerTaxonomy()
    {
      $labels = [
        'name'              => __('Options groups', 'center3'),
        'singular_name'     => __('Options group', 'center3'),
        'search_items'      => __('Search options group', 'center3'),
        'all_items'         => __('All options groups', 'center3'),
        'parent_item'       => __('Parent options group', 'center3'),
        'parent_item_colon' => __('Parent options group:', 'center3'),
        'edit_item'         => __('Edit options group', 'center3'),
        'update_item'       => __('Update options group', 'center3'),
        'add_new_item'      => __('Add new options group', 'center3'),
        'new_item_name'     => __('New options group name', 'center3'),
        'menu_name'         => __('Options groups', 'center3'),
      ];

      $args = [
        'hierarchical'      => true,
        'labels'            => $labels,
        'public'            => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'optionsgroup'],
      ];

      register_taxonomy('optionsgroup', ['optionspage'], $args);
    }
  }
