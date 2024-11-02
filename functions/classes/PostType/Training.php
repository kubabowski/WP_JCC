<?php

namespace ThemeClasses\PostType;

class Training
{
    static protected $postTypeName = 'training';
    static protected $postTypeSlug = 'szkolenia';

    public function __construct()
    {
        add_action('init', [$this, 'registerPostType']);
        add_filter('manage_training_posts_columns', [$this, 'addCustomColumns']);
        add_action('manage_training_posts_custom_column', [$this, 'renderCustomColumn'], 10, 2);
    }

    public function registerPostType()
    {
        $labels = [
            'name'                  => __('Szkolenia',),
            'singular_name'         => __('Szkolenie', 'bud-went'),
            'menu_name'             => __('Szkolenia', 'bud-went'),
            'name_admin_bar'        => __('Szkolenie', 'bud-went'),
            'add_new'               => __('Dodaj szkolenie', 'bud-went'),
            'add_new_item'          => __('Dodaj nowe szkolenie', 'bud-went'),
            'new_item'              => __('Nowe szkolenie', 'bud-went'),
            'edit_item'             => __('Edytuj szkolenie', 'bud-went'),
            'view_item'             => __('Zobacz szkolenie', 'bud-went'),
            'all_items'             => __('Wszystkie szkolenia', 'bud-went'),
            'search_items'          => __('Szukaj szkoleń', 'bud-went'),
            'parent_item_colon'     => __('Szkolenie nadrzędne:', 'bud-went'),
            'not_found'             => __('Brak szkoleń.', 'bud-went'),
            'not_found_in_trash'    => __('Brak szkoleń w koszu.', 'bud-went'),
            'archives'              => __('Archiwum szkoleń', 'bud-went'),
            'filter_items_list'     => __('Filtruj listę szkoleń', 'bud-went'),
            'items_list_navigation' => __('Lista nawigacji szkoleń', 'bud-went'),
            'items_list'            => __('Lista szkoleń', 'bud-went'),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_nav_menus'  => false,
            'query_var'          => false,
            'show_in_rest'       => false,
            'rewrite'            => ['slug' => static::$postTypeSlug],
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-welcome-learn-more',
            'supports'           => ['title'],
            'exclude_from_search' => true,
        ];

        register_post_type(static::$postTypeName, $args);
    }

    public function addCustomColumns($columns)
    {
        $columns = array_merge(
            array_slice($columns, 0, array_search('title', array_keys($columns)) + 1),
            ['acf_date' => __('Data szkolenia', 'bud-went')],
            array_slice($columns, array_search('title', array_keys($columns)) + 1)
        );

        return $columns;
    }

    public function renderCustomColumn($column, $post_id)
    {
        if ($column === 'acf_date') {
            $date_value = get_field('event_date', $post_id);
            echo $date_value ? esc_html($date_value) : __('Brak daty', 'bud-went');
        }
    }
}
