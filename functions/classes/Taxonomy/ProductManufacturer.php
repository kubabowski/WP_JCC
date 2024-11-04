<?php

  namespace ThemeClasses\Taxonomy;

  class ProductManufacturer
  {
    static protected $postTypeName = 'product';
    static protected $taxonomyName = 'product-manufacturer';
    static protected $taxonomySlug = 'producent-produktow';

    public function __construct()
    {
      add_action('init', [$this, 'registerTaxonomy']);
    }

    public function registerTaxonomy()
    {
      $labels = [
        'name'              => __('Producenci produktów', 'jcc-solutions'),
        'singular_name'     => __('Producent produktów', 'jcc-solutions'),
        'search_items'      => __('Szukaj producenta produktów', 'jcc-solutions'),
        'all_items'         => __('Wszyscy producenci produktów', 'jcc-solutions'),
        'parent_item'       => __('Producent produktów rodzic', 'jcc-solutions'),
        'parent_item_colon' => __('Producent produktów rodzic:', 'jcc-solutions'),
        'edit_item'         => __('Edytuj producenta produktów', 'jcc-solutions'),
        'update_item'       => __('Aktualizuj producenta produktów', 'jcc-solutions'),
        'add_new_item'      => __('Dodaj producenta produktów', 'jcc-solutions'),
        'new_item_name'     => __('Nowy producent produktów [nazwa]', 'jcc-solutions'),
        'menu_name'         => __('Producenci produktów', 'jcc-solutions'),
      ];

      $args = [
        'hierarchical'      => true, // to show chackboxes
        'labels'            => $labels,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => static::$taxonomySlug],
      ];

      register_taxonomy(static::$taxonomyName, [static::$postTypeName], $args);
    }
  }
