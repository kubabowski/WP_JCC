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
        'name'              => __('Producenci produktów', 'bud-went'),
        'singular_name'     => __('Producent produktów', 'bud-went'),
        'search_items'      => __('Szukaj producenta produktów', 'bud-went'),
        'all_items'         => __('Wszyscy producenci produktów', 'bud-went'),
        'parent_item'       => __('Producent produktów rodzic', 'bud-went'),
        'parent_item_colon' => __('Producent produktów rodzic:', 'bud-went'),
        'edit_item'         => __('Edytuj producenta produktów', 'bud-went'),
        'update_item'       => __('Aktualizuj producenta produktów', 'bud-went'),
        'add_new_item'      => __('Dodaj producenta produktów', 'bud-went'),
        'new_item_name'     => __('Nowy producent produktów [nazwa]', 'bud-went'),
        'menu_name'         => __('Producenci produktów', 'bud-went'),
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
