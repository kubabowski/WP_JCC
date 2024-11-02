<?php

  namespace ThemeClasses\PostType;

  class News
  {
    static protected $postTypeSlug = 'news';

    public function __construct()
    {
      add_action('init', [$this, 'registerPostType']);
    }

    public function registerPostType()
    {
      $labels = [
        'name'                  => __('News', 'center3'),
        'singular_name'         => __('News', 'center3'),
        'menu_name'             => __('News', 'center3'),
        'name_admin_bar'        => __('News', 'center3'),
        'add_new'               => __('Add new [news]', 'center3'),
        'add_new_item'          => __('Add new news', 'center3'),
        'new_item'              => __('New news', 'center3'),
        'edit_item'             => __('Edit news', 'center3'),
        'view_item'             => __('View news', 'center3'),
        'all_items'             => __('All news', 'center3'),
        'search_items'          => __('Search news', 'center3'),
        'parent_item_colon'     => __('Parent news:', 'center3'),
        'not_found'             => __('No news.', 'center3'),
        'not_found_in_trash'    => __('No news in trash.', 'center3'),
        // 'featured_image'        => _x('Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'center3'),
        // 'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'center3'),
        // 'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'center3'),
        // 'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'center3'),
        'archives'              => __('News archive', 'center3'),
        // 'insert_into_item'      => _x('Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'center3'),
        // 'uploaded_to_this_item' => _x('Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'center3'),
        'filter_items_list'     => __('Filter news list', 'center3'),
        'items_list_navigation' => __('News list navigation', 'center3'),
        'items_list'            => __('News list', 'center3'),
      ];

      $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'query_var'          => true,
        'show_in_rest'       => false,
        'rewrite'            => ['slug' => static::$postTypeSlug],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-format-status',
        'supports'           => ['title'],
      ];

      register_post_type(static::$postTypeSlug, $args);
    }
  }
