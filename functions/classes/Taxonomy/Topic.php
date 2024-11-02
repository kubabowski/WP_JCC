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
            'name'              => __('Tematy', 'bud-went'),
            'singular_name'     => __('Temat', 'bud-went'),
            'search_items'      => __('Szukaj tematów', 'bud-went'),
            'all_items'         => __('Wszystkie tematy', 'bud-went'),
            'edit_item'         => __('Edytuj temat', 'bud-went'),
            'update_item'       => __('Aktualizuj temat', 'bud-went'),
            'add_new_item'      => __('Dodaj nowy temat', 'bud-went'),
            'new_item_name'     => __('Nazwa nowego tematu', 'bud-went'),
            'menu_name'         => __('Tematy', 'bud-went'),
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
