<?php

namespace ThemeClasses\Taxonomy;

class Company
{
    static protected $postTypeName = 'training';
    static protected $taxonomyName = 'company';
    static protected $taxonomySlug = 'firma';

    public function __construct()
    {
        add_action('init', [$this, 'registerTaxonomy']);
    }

    public function registerTaxonomy()
    {
        $labels = [
            'name'              => __('Firmy', 'jcc-solutions'),
            'singular_name'     => __('Firma', 'jcc-solutions'),
            'search_items'      => __('Szukaj firm', 'jcc-solutions'),
            'all_items'         => __('Wszystkie firmy', 'jcc-solutions'),
            'parent_item'       => __('Firma nadrzędna', 'jcc-solutions'),
            'parent_item_colon' => __('Firma nadrzędna:', 'jcc-solutions'),
            'edit_item'         => __('Edytuj firmę', 'jcc-solutions'),
            'update_item'       => __('Aktualizuj firmę', 'jcc-solutions'),
            'add_new_item'      => __('Dodaj nową firmę', 'jcc-solutions'),
            'new_item_name'     => __('Nazwa nowej firmy', 'jcc-solutions'),
            'menu_name'         => __('Firmy', 'jcc-solutions'),
        ];

        $args = [
            'hierarchical'      => false,
            'labels'            => $labels,
            'public'            => false,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => static::$taxonomySlug],
        ];

        register_taxonomy(static::$taxonomyName, [static::$postTypeName], $args);
    }
}
