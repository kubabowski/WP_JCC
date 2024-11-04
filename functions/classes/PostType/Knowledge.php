<?php

  namespace ThemeClasses\PostType;

  class Knowledge
  {
    static protected $postTypeName = 'knowledge';
    static protected $postTypeSlug = 'baza-wiedzy';

    public function __construct()
    {
      add_action('init', [$this, 'registerPostType']);
      add_theme_support( 'post-thumbnails' );
    }

    public function registerPostType()
    {
      $labels = [
        'name'                  => __('Baza wiedzy', 'jcc-solutions'),
        'singular_name'         => __('Wpis', 'jcc-solutions'),
        'menu_name'             => __('Baza wiedzy', 'jcc-solutions'),
        'name_admin_bar'        => __('Wpis', 'jcc-solutions'),
        'add_new'               => __('Dodaj [wpis]', 'jcc-solutions'),
        'add_new_item'          => __('Dodaj wpis', 'jcc-solutions'),
        'new_item'              => __('Nowy wpis', 'jcc-solutions'),
        'edit_item'             => __('Edytuj wpis', 'jcc-solutions'),
        'view_item'             => __('Zobacz wpis', 'jcc-solutions'),
        'all_items'             => __('Wszystkie wpisy', 'jcc-solutions'),
        'search_items'          => __('Szukaj wpis', 'jcc-solutions'),
        'parent_item_colon'     => __('Wpis rodzic:', 'jcc-solutions'),
        'not_found'             => __('Brak wpisów.', 'jcc-solutions'),
        'not_found_in_trash'    => __('Brak wpisów w koszu.', 'jcc-solutions'),
        // 'featured_image'        => _x('Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'jcc-solutions'),
        // 'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'jcc-solutions'),
        // 'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'jcc-solutions'),
        // 'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'jcc-solutions'),
        'archives'              => __('Archiwum wpisów', 'jcc-solutions'),
        // 'insert_into_item'      => _x('Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'jcc-solutions'),
        // 'uploaded_to_this_item' => _x('Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'jcc-solutions'),
        'filter_items_list'     => __('Filtruj listę wpisów', 'jcc-solutions'),
        'items_list_navigation' => __('Lista wpisów list [nav]', 'jcc-solutions'),
        'items_list'            => __('Lista wpisów list', 'jcc-solutions'),
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
        'menu_icon'          => 'dashicons-book',
        'supports'           => ['title', 'thumbnail', 'author'],
      ];

      register_post_type(static::$postTypeName, $args);
    }
  }
