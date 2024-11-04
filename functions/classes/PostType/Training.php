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
            'singular_name'         => __('Szkolenie', 'jcc-solutions'),
            'menu_name'             => __('Szkolenia', 'jcc-solutions'),
            'name_admin_bar'        => __('Szkolenie', 'jcc-solutions'),
            'add_new'               => __('Dodaj szkolenie', 'jcc-solutions'),
            'add_new_item'          => __('Dodaj nowe szkolenie', 'jcc-solutions'),
            'new_item'              => __('Nowe szkolenie', 'jcc-solutions'),
            'edit_item'             => __('Edytuj szkolenie', 'jcc-solutions'),
            'view_item'             => __('Zobacz szkolenie', 'jcc-solutions'),
            'all_items'             => __('Wszystkie szkolenia', 'jcc-solutions'),
            'search_items'          => __('Szukaj szkoleń', 'jcc-solutions'),
            'parent_item_colon'     => __('Szkolenie nadrzędne:', 'jcc-solutions'),
            'not_found'             => __('Brak szkoleń.', 'jcc-solutions'),
            'not_found_in_trash'    => __('Brak szkoleń w koszu.', 'jcc-solutions'),
            'archives'              => __('Archiwum szkoleń', 'jcc-solutions'),
            'filter_items_list'     => __('Filtruj listę szkoleń', 'jcc-solutions'),
            'items_list_navigation' => __('Lista nawigacji szkoleń', 'jcc-solutions'),
            'items_list'            => __('Lista szkoleń', 'jcc-solutions'),
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
            ['acf_date' => __('Data szkolenia', 'jcc-solutions')],
            array_slice($columns, array_search('title', array_keys($columns)) + 1)
        );

        return $columns;
    }

    public function renderCustomColumn($column, $post_id)
    {
        if ($column === 'acf_date') {
            $date_value = get_field('event_date', $post_id);
            echo $date_value ? esc_html($date_value) : __('Brak daty', 'jcc-solutions');
        }
    }
}
