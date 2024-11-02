<?php

  namespace ThemeClasses\PostType;

  class Form
  {
    static protected $postTypeSlug = 'form';

    public function __construct()
    {
      add_action('init', [$this, 'registerPostType']);
      add_filter('pll_get_post_types', [$this, 'addToPolylangList'], 10, 2);
    }

    public function registerPostType()
    {
      $labels = [
        'name'                  => __('Forms', 'center3'),
        'singular_name'         => __('Form', 'center3'),
        'menu_name'             => __('Forms', 'center3'),
        'name_admin_bar'        => __('Form', 'center3'),
        'add_new'               => __('Add new [form]', 'center3'),
        'add_new_item'          => __('Add new form', 'center3'),
        'new_item'              => __('New form', 'center3'),
        'edit_item'             => __('Edit form', 'center3'),
        'view_item'             => __('View form', 'center3'),
        'all_items'             => __('All forms', 'center3'),
        'search_items'          => __('Search form', 'center3'),
        'parent_item_colon'     => __('Parent form:', 'center3'),
        'not_found'             => __('No forms.', 'center3'),
        'not_found_in_trash'    => __('No forms in trash.', 'center3'),
        // 'featured_image'        => _x('Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'center3'),
        // 'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'center3'),
        // 'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'center3'),
        // 'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'center3'),
        'archives'              => __('Forms archive', 'center3'),
        // 'insert_into_item'      => _x('Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'center3'),
        // 'uploaded_to_this_item' => _x('Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'center3'),
        'filter_items_list'     => __('Filter forms list', 'center3'),
        'items_list_navigation' => __('Forms list navigation', 'center3'),
        'items_list'            => __('Forms list', 'center3'),
      ];

      $args = [
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'query_var'          => false,
        'show_in_rest'       => false,
        'rewrite'            => ['slug' => static::$postTypeSlug],
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-editor-table',
        'supports'           => ['title'],
        'exclude_from_search' => false,
      ];

      register_post_type(static::$postTypeSlug, $args);
    }

    /**
     * force CPT visibiliti in polylang options required if 'public' == false
     * https://polylang.pro/doc/filter-reference/#pll_get_post_types
     */
    public function addToPolylangList($post_types, $is_settings)
    {
      $post_types[static::$postTypeSlug] = static::$postTypeSlug;

      return $post_types;
    }
  }
