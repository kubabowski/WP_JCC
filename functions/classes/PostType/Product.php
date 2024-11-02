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
        'name'                  => __('Produkty', 'bud-went'),
        'singular_name'         => __('Produkt', 'bud-went'),
        'menu_name'             => __('Produkty', 'bud-went'),
        'name_admin_bar'        => __('Produkt', 'bud-went'),
        'add_new'               => __('Dodaj [produkt]', 'bud-went'),
        'add_new_item'          => __('Dodaj produkt', 'bud-went'),
        'new_item'              => __('Nowy produkt', 'bud-went'),
        'edit_item'             => __('Edytuj produkt', 'bud-went'),
        'view_item'             => __('Zobacz produkt', 'bud-went'),
        'all_items'             => __('Wszystkie produkty', 'bud-went'),
        'search_items'          => __('Szukaj produkt', 'bud-went'),
        'parent_item_colon'     => __('Produkt rodzic:', 'bud-went'),
        'not_found'             => __('Brak produktów.', 'bud-went'),
        'not_found_in_trash'    => __('Brak produktów w koszu.', 'bud-went'),
        // 'featured_image'        => _x('Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'bud-went'),
        // 'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'bud-went'),
        // 'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'bud-went'),
        // 'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'bud-went'),
        'archives'              => __('Archiwum produktów', 'bud-went'),
        // 'insert_into_item'      => _x('Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'bud-went'),
        // 'uploaded_to_this_item' => _x('Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'bud-went'),
        'filter_items_list'     => __('Filtruj listę produktówt', 'bud-went'),
        'items_list_navigation' => __('Lista produktów list [nav]', 'bud-went'),
        'items_list'            => __('Lista produktów list', 'bud-went'),
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
