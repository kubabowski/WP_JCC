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
        'name'              => __('Kategorie produktów', 'bud-went'),
        'singular_name'     => __('Kategoria produktów', 'bud-went'),
        'search_items'      => __('Szukaj kategorię produktów', 'bud-went'),
        'all_items'         => __('Wszystkie kategorie produktów', 'bud-went'),
        'parent_item'       => __('Kategoria produktów rodzic', 'bud-went'),
        'parent_item_colon' => __('Kategoria produktów rodzic:', 'bud-went'),
        'edit_item'         => __('Edytuj kategorię produktów', 'bud-went'),
        'update_item'       => __('Aktualizuj kategorię produktów', 'bud-went'),
        'add_new_item'      => __('Dodaj kategorię produktów', 'bud-went'),
        'new_item_name'     => __('Nowa kategoria produktów [nazwa]', 'bud-went'),
        'menu_name'         => __('Kategorie produktów', 'bud-went'),
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
