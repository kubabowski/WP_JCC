<?php

namespace ThemeClasses\Taxonomy;

class CaseStudyCategory
{
  static protected $postTypeName = 'case-study';
  static protected $taxonomyName = 'case-study-category';
  static protected $taxonomySlug = 'case-study-category';

  public function __construct()
  {
    add_action('init', [$this, 'registerTaxonomy']);
    add_filter('getCaseStudyCategories', [$this, 'getCaseStudyCategories']);
  }

  public function registerTaxonomy()
  {
    $labels = [
      'name'              => __('Case Study Categories', 'jcc-solutions'),
      'singular_name'     => __('Case Study Category', 'jcc-solutions'),
      'search_items'      => __('Search Case Study Category', 'jcc-solutions'),
      'all_items'         => __('All Case Study Categories', 'jcc-solutions'),
      'parent_item'       => __('Parent Case Study Category', 'jcc-solutions'),
      'parent_item_colon' => __('Parent Case Study Category:', 'jcc-solutions'),
      'edit_item'         => __('Edit Case Study Category', 'jcc-solutions'),
      'update_item'       => __('Update Case Study Category', 'jcc-solutions'),
      'add_new_item'      => __('Add New Case Study Category', 'jcc-solutions'),
      'new_item_name'     => __('New Case Study Category Name', 'jcc-solutions'),
      'menu_name'         => __('Case Study Categories', 'jcc-solutions'),
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

  public function getCaseStudyCategories($args = [])
{
    $defaults = [
        'taxonomy'   => static::$taxonomyName,
        'hide_empty' => false, 
    ];

    $args = wp_parse_args($args, $defaults);

    return get_terms($args);
}
}
