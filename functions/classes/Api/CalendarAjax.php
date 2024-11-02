<?php

namespace ThemeClasses\Api;

class CalendarAjax
{
    public function __construct()
    {
        add_action('wp_ajax_get_calendar_events', [$this, 'get_calendar_events']);
        add_action('wp_ajax_nopriv_get_calendar_events', [$this, 'get_calendar_events']);
    }

    public function get_calendar_events()
    {
        $year = intval($_POST['year']);
        $month = intval($_POST['month']);

        $start_date = (new \DateTime("{$year}-{$month}-01"))->format('Y-m-d');
        $end_date = (new \DateTime("{$year}-{$month}-31"))->format('Y-m-d');

        $args = [
            'post_type' => 'training',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key'     => 'event_date',
                    'value'   => [$start_date, $end_date],
                    'compare' => 'BETWEEN',
                    'type'    => 'DATE',
                ],
            ],
        ];

        $events = get_posts($args);
        $event_dates = [];

        foreach ($events as $event) {
            $event_date = get_field('event_date', $event->ID);
            $company_terms = wp_get_post_terms($event->ID, 'company');
            $topic_terms = wp_get_post_terms($event->ID, 'topic');
            $event_desc = get_field('desc', $event->ID);

            $company_data = array_map(function ($term) {
                return [
                    'name' => $term->name,
                    'slug' => $term->slug,
                ];
            }, $company_terms);

            $topic_data = array_map(function ($term) {
                return [
                    'name' => $term->name,
                    'slug' => $term->slug,
                ];
            }, $topic_terms);

            $event_dates[] = [
                'ID' => $event->ID,
                'title' => $event->post_title,
                'date' => date('d.m.Y', strtotime($event_date)),
                'company' => !empty($company_data) ? $company_data : null,
                'topic'   => !empty($topic_data) ? $topic_data : null,
                'desc'    => $event_desc,
            ];
        }

        wp_send_json_success($event_dates);
    }
}
