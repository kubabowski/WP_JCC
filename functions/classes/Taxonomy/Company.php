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
            'name'              => __('Firmy', 'bud-went'),
            'singular_name'     => __('Firma', 'bud-went'),
            'search_items'      => __('Szukaj firm', 'bud-went'),
            'all_items'         => __('Wszystkie firmy', 'bud-went'),
            'parent_item'       => __('Firma nadrzędna', 'bud-went'),
            'parent_item_colon' => __('Firma nadrzędna:', 'bud-went'),
            'edit_item'         => __('Edytuj firmę', 'bud-went'),
            'update_item'       => __('Aktualizuj firmę', 'bud-went'),
            'add_new_item'      => __('Dodaj nową firmę', 'bud-went'),
            'new_item_name'     => __('Nazwa nowej firmy', 'bud-went'),
            'menu_name'         => __('Firmy', 'bud-went'),
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
