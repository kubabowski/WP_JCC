<?php

  namespace ThemeClasses\Controller;

  trait GenericPost
  {
    static protected $timeFormat = 'Y-m-d H:i:s';
    static protected $perPage = 12;

    public function initPost()
    {
      add_filter('posts_where', [$this, 'extendPostsWhere'], 10, 2);

      add_filter('get' . static::$postTypePrefix . 's', [$this, 'getPosts'], 10, 2);
      add_filter('get' . static::$postTypePrefix . 'Details', [$this, 'getDetails'], 10, 2);

      add_filter('apiGet' . static::$postTypePrefix . 'Posts', [$this, 'apiGetPosts'], 10, 2);
      add_filter('query_vars', [$this, 'addCustomQueryVars']);
    }



    public function extendPostsWhere($where, $queryObj)
    {
      $queryVars = $queryObj->query_vars;

      if ($queryVars['post_type'] != static::$postTypeName) return $where;

      $queryLabel = isset($queryVars['query_label']) ? $queryVars['query_label'] : '';
      if ($queryLabel != 'custom' . static::$postTypePrefix . 'Query') return $where;

      global $wpdb;

      $search = $queryVars['search_query'];
      if ($search == '') return $where;

      $where .= ' AND ( ';
      $where .= $wpdb->prefix . 'posts.post_title LIKE \'%' . $search . '%\'';
      $where .= ' OR ';
      $where .= $wpdb->prefix . 'posts.post_content LIKE \'%' . $search . '%\'';
      $where .= ' ) ';

      return $where;
    }

    public function addCustomQueryVars($vars = []) {
      if (!in_array('per_page', $vars)) $vars[] = 'per_page';
      return $vars;
    }

    public function getPosts($args = [], $items = [])
    {
        error_log("getPosts called with args: " . print_r($args, true));
        error_log('getPosts filter called');
        debug_backtrace();


      $lang = apply_filters('getCurrentLang', null);

      $varArgs = array_merge([
        'per_page' => static::getPerPage($args),
        'offset' => static::getPageOffset($args),
        'tax_query' => static::getTaxQuery($args),
        'date_query' => static::getDateQuery($args),
        'meta_query' => static::getMetaQuery($args),
        'search_query' => static::getSearchQuery($args),
        'post__not_in' => static::getPostNotIn($args),
        'lang' => $lang,
      ], (array)$args);

      $queryArgs = [
        'query_label' => 'custom' . static::$postTypePrefix . 'Query',
        'suppress_filters' => false, // false value allows use posts_where filter
        'post_type' => static::$postTypeName,
        'post_status' => $varArgs['post_status'] ?? 'publish',
        'posts_per_page' => $varArgs['per_page'],
        'offset' => $varArgs['offset'],
        'post__in' => $varArgs['post__in'] ?? null,
        'post__not_in' => $varArgs['post__not_in'] ?? null,
        'tax_query' => $varArgs['tax_query'],
        'date_query' => $varArgs['date_query'],
        'meta_query' => $varArgs['meta_query'],
        'search_query' => $varArgs['search_query'],
        'orderby' => $varArgs['orderby'] ?? 'date',
        'order' => $varArgs['order'] ?? 'DESC',
        'lang' => $varArgs['lang'],
      ];

      $items = get_posts($queryArgs);
        error_log("get_posts returned items: " . print_r($items, true));

      $items = array_map(function($item) {
        return static::getPostDetails($item);
      }, $items);

        var_dump($items);

      if (!isset($args['with_pages'])) return $items;

      $total = count(get_posts(array_merge($queryArgs, [
        'posts_per_page' => -1,
        'offset' => 0,
      ])));

      return [
        'items' => $items,
        'total' => $total,
        'pages' => max(1, ceil($total / $queryArgs['posts_per_page'])),
      ];
    }

    static public function getPerPage($args)
    {
      if (!isset($args['per_page'])) return static::$perPage;

      return $args['per_page'];
    }

    static public function getPostNotIn($args)
    {
      if (!isset($args['post__not_in'])) return null;

      return $args['post__not_in'];
    }

    static public function getPageOffset($args)
    {
      if (!isset($args['page'])) return 0;

      $perPage = isset($args['per_page']) ? $args['per_page'] : static::$perPage;
      return ($args['page'] - 1) * $perPage;
    }

    static public function getDateQuery($args)
    {
      if (!isset($args['date']) || $args['date'] == '') return null;

      $afterTime = strtotime($args['date'] . ' 00:00:00');
      $beforeTime = strtotime($args['date'] . ' 23:59:59');

      return [
        'after' => date_i18n(static::$timeFormat, $afterTime),
        'before' => date_i18n(static::$timeFormat, $beforeTime),
        'inclusive' => true,
      ];
    }

    static public function getTaxQuery($args)
    {
      $taxQuery = [
        'relation' => 'AND',
      ];

      static::extendTaxQuery($taxQuery, 'category', $args, 'category');
      static::extendTaxQuery($taxQuery, 'tag', $args, 'tags');

      return $taxQuery;
    }

    static public function extendTaxQuery(&$taxQuery, $taxSlug, $args, $argName)
    {
      if (!isset($args[$argName]) || $args[$argName] == '') return;

      $taxQuery[$taxSlug] = [
        'taxonomy' => static::$postTypeName . '-' . $taxSlug,
        'field' => 'slug',
        'terms' => explode(',', $args[$argName]),
        'operator' => 'IN',
      ];
    }

    static public function getMetaQuery($args)
    {
      $metaQuery = [
        'relation' => 'AND',
      ];

      return $metaQuery;
    }

    static public function getSearchQuery($args)
    {
      if (!isset($args['search']) || $args['search'] == '') return '';

      $searchQuery = apply_filters('get_search_query', $args['search']);
      $searchQuery = esc_attr($searchQuery);
      return $searchQuery;
    }

      public function getDetailsById($postId)
      {
          if (empty($postId)) return null;

          $post = get_post($postId);

          if (!$post) return null;

          return static::getPostDetails($post);
      }

    public function getDetails($postObj)
    {
      return static::getPostDetails($postObj);
    }

    static public function extendPostDetails($postObj, $postDetails) {
      return $postDetails;
    }

    static public function getPostDetails($postObj)
    {
        error_log('$postObj is: '.$postObj);

      if (!is_object($postObj)) return null;

      $postId = $postObj->ID;

      $url = get_permalink($postId);
      $title = get_the_title($postId);
      $text = get_field('description', $postId);
      $time = get_post_time('U', false, $postId);
      $date = date_i18n('j F Y', $time);

      $postDetails = [
        'id'           => $postId,
        'url'          => $url,
        'title'        => $title,
        'text'         => $text,
        'time'         => $time,
        'date'         => $date,
      ];

      return static::extendPostDetails($postObj, $postDetails);
    }

    public function apiGetPosts($args, $items = []) {
      $result = $this->getPosts($items, array_merge($args, [
        'with_pages' => true,
      ]));

      return [
        'success' => true,
        'data' => [
          'items' => $result['items'],
          'pages' => $result['pages'],
        ],
      ];
    }
  }
