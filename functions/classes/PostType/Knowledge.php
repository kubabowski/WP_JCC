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
        'name'                  => __('Baza wiedzy', 'bud-went'),
        'singular_name'         => __('Wpis', 'bud-went'),
        'menu_name'             => __('Baza wiedzy', 'bud-went'),
        'name_admin_bar'        => __('Wpis', 'bud-went'),
        'add_new'               => __('Dodaj [wpis]', 'bud-went'),
        'add_new_item'          => __('Dodaj wpis', 'bud-went'),
        'new_item'              => __('Nowy wpis', 'bud-went'),
        'edit_item'             => __('Edytuj wpis', 'bud-went'),
        'view_item'             => __('Zobacz wpis', 'bud-went'),
        'all_items'             => __('Wszystkie wpisy', 'bud-went'),
        'search_items'          => __('Szukaj wpis', 'bud-went'),
        'parent_item_colon'     => __('Wpis rodzic:', 'bud-went'),
        'not_found'             => __('Brak wpisów.', 'bud-went'),
        'not_found_in_trash'    => __('Brak wpisów w koszu.', 'bud-went'),
        // 'featured_image'        => _x('Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'bud-went'),
        // 'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'bud-went'),
        // 'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'bud-went'),
        // 'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'bud-went'),
        'archives'              => __('Archiwum wpisów', 'bud-went'),
        // 'insert_into_item'      => _x('Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'bud-went'),
        // 'uploaded_to_this_item' => _x('Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'bud-went'),
        'filter_items_list'     => __('Filtruj listę wpisów', 'bud-went'),
        'items_list_navigation' => __('Lista wpisów list [nav]', 'bud-went'),
        'items_list'            => __('Lista wpisów list', 'bud-went'),
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
