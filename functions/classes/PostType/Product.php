<?php

  namespace ThemeClasses\PostType;

  class Product
  {
    static protected $postTypeName = 'product';
    static protected $postTypeSlug = 'produkty';

    public function __construct()
    {
      add_action('init', [$this, 'registerPostType']);
    }

    public function registerPostType()
    {
      $labels = [
        'name'                  => __('Produkty', 'jcc-solutions'),
        'singular_name'         => __('Produkt', 'jcc-solutions'),
        'menu_name'             => __('Produkty', 'jcc-solutions'),
        'name_admin_bar'        => __('Produkt', 'jcc-solutions'),
        'add_new'               => __('Dodaj [produkt]', 'jcc-solutions'),
        'add_new_item'          => __('Dodaj produkt', 'jcc-solutions'),
        'new_item'              => __('Nowy produkt', 'jcc-solutions'),
        'edit_item'             => __('Edytuj produkt', 'jcc-solutions'),
        'view_item'             => __('Zobacz produkt', 'jcc-solutions'),
        'all_items'             => __('Wszystkie produkty', 'jcc-solutions'),
        'search_items'          => __('Szukaj produkt', 'jcc-solutions'),
        'parent_item_colon'     => __('Produkt rodzic:', 'jcc-solutions'),
        'not_found'             => __('Brak produktów.', 'jcc-solutions'),
        'not_found_in_trash'    => __('Brak produktów w koszu.', 'jcc-solutions'),
        // 'featured_image'        => _x('Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'jcc-solutions'),
        // 'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'jcc-solutions'),
        // 'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'jcc-solutions'),
        // 'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'jcc-solutions'),
        'archives'              => __('Archiwum produktów', 'jcc-solutions'),
        // 'insert_into_item'      => _x('Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'jcc-solutions'),
        // 'uploaded_to_this_item' => _x('Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'jcc-solutions'),
        'filter_items_list'     => __('Filtruj listę produktówt', 'jcc-solutions'),
        'items_list_navigation' => __('Lista produktów list [nav]', 'jcc-solutions'),
        'items_list'            => __('Lista produktów list', 'jcc-solutions'),
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
        'menu_icon'          => 'dashicons-networking',
        'supports'           => ['title'],
      ];

      register_post_type(static::$postTypeName, $args);
    }
  }
