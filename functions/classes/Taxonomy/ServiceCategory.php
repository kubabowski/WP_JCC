<?php

namespace ThemeClasses\Taxonomy;

class ServiceCategory
{
  static protected $postTypeName = 'service';
  static protected $taxonomyName = 'service-category';
  static protected $taxonomySlug = 'service-category';

  public function __construct()
  {
    add_action('init', [$this, 'registerTaxonomy']);
    add_filter('getServicesCategories', [$this, 'getServiceCategories']);
  }

  public function registerTaxonomy()
  {
    $labels = [
      'name'              => __('Service Categories', 'bud-went'),
      'singular_name'     => __('Service Category', 'bud-went'),
      'search_items'      => __('Search Service Category', 'bud-went'),
      'all_items'         => __('All Service Categories', 'bud-went'),
      'parent_item'       => __('Parent Service Category', 'bud-went'),
      'parent_item_colon' => __('Parent Service Category:', 'bud-went'),
      'edit_item'         => __('Edit Service Category', 'bud-went'),
      'update_item'       => __('Update Service Category', 'bud-went'),
      'add_new_item'      => __('Add New Service Category', 'bud-went'),
      'new_item_name'     => __('New Service Category Name', 'bud-went'),
      'menu_name'         => __('Service Categories', 'bud-went'),
    ];

    $args = [
      'hierarchical'      => true,
      'labels'            => $labels,
      'public'            => true,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => ['slug' => static::$taxonomySlug],
    ];

    register_taxonomy(static::$taxonomyName, [static::$postTypeName], $args);
  }

  public function getServiceCategories($args = [])
{
    $defaults = [
        'taxonomy'   => static::$taxonomyName,
        'hide_empty' => false, 
    ];

    $args = wp_parse_args($args, $defaults);

    return get_terms($args);
}
}
