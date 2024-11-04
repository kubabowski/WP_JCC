<?php

namespace ThemeClasses\Taxonomy;

class Topic
{
    static protected $postTypeName = 'training';
    static protected $taxonomyName = 'topic';
    static protected $taxonomySlug = 'temat';

    public function __construct()
    {
        add_action('init', [$this, 'registerTaxonomy']);
    }

    public function registerTaxonomy()
    {
        $labels = [
            'name'              => __('Tematy', 'jcc-solutions'),
            'singular_name'     => __('Temat', 'jcc-solutions'),
            'search_items'      => __('Szukaj tematów', 'jcc-solutions'),
            'all_items'         => __('Wszystkie tematy', 'jcc-solutions'),
            'edit_item'         => __('Edytuj temat', 'jcc-solutions'),
            'update_item'       => __('Aktualizuj temat', 'jcc-solutions'),
            'add_new_item'      => __('Dodaj nowy temat', 'jcc-solutions'),
            'new_item_name'     => __('Nazwa nowego tematu', 'jcc-solutions'),
            'menu_name'         => __('Tematy', 'jcc-solutions'),
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
