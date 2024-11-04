<?php

  namespace ThemeClasses\Taxonomy;

  class ProductCategory
  {
    static protected $postTypeName = 'product';
    static protected $taxonomyName = 'product-category';
    static protected $taxonomySlug = 'kategoria-produktu';

    public function __construct()
    {
      add_action('init', [$this, 'registerTaxonomy']);
    }

    public function registerTaxonomy()
    {
      $labels = [
        'name'              => __('Kategorie produktów', 'jcc-solutions'),
        'singular_name'     => __('Kategoria produktów', 'jcc-solutions'),
        'search_items'      => __('Szukaj kategorię produktów', 'jcc-solutions'),
        'all_items'         => __('Wszystkie kategorie produktów', 'jcc-solutions'),
        'parent_item'       => __('Kategoria produktów rodzic', 'jcc-solutions'),
        'parent_item_colon' => __('Kategoria produktów rodzic:', 'jcc-solutions'),
        'edit_item'         => __('Edytuj kategorię produktów', 'jcc-solutions'),
        'update_item'       => __('Aktualizuj kategorię produktów', 'jcc-solutions'),
        'add_new_item'      => __('Dodaj kategorię produktów', 'jcc-solutions'),
        'new_item_name'     => __('Nowa kategoria produktów [nazwa]', 'jcc-solutions'),
        'menu_name'         => __('Kategorie produktów', 'jcc-solutions'),
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
  }
