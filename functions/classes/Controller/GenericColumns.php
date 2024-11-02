<?php

  namespace ThemeClasses\Controller;

  trait GenericColumns
  {
    protected $columnsBody = [];
    protected $columnsSort = [];

    public function initColumns()
    {
      $this->columnsBody = static::setGenericColumnsBody();
      $this->columnsSort = static::setGenericColumnsSort();

      add_filter('manage_' . static::$postTypeName . '_posts_columns' , [$this, 'setColumns']);
      add_action('manage_' . static::$postTypeName . '_posts_custom_column' , [$this, 'fillColumns'], 10, 2);
      add_action('manage_edit-' . static::$postTypeName . '_sortable_columns' , [$this, 'sortableColumns']);
      add_action('pre_get_posts', [$this, 'sortColumns']);
    }

    /* columns head - begin */

    static public function setColumnsHead($columns)
    {
      return $columns;
    }

    static protected function setGenericColumnsHead($columns)
    {
      // $columns['title'] = __('Title', 'center3');

      $columns = array_merge(array_slice($columns, 0, 2, true), [
        'image' => __('Image', 'center3'),
      ], array_slice($columns, 2, NULL, true));

      return static::setColumnsHead($columns);
    }

    public function setColumns($columns)
    {
      return static::setGenericColumnsHead($columns);
    }

    /* columns head - end */

    /* columns body - begin */

    static public function setColumnsBody($columns)
    {
      return $columns;
    }

    static protected function setGenericColumnsBody()
    {
      $columns = [];

      $columns['image'] = function($column, $post_id) {
        $imageObj = get_field('image', $post_id);
        $imageUrl = isset($imageObj['sizes']) ? $imageObj['sizes']['thumbnail'] : '';
        echo ($imageUrl != '')
          ? '<img src="' . $imageUrl . '" alt="image" style="display: block; width: 70px; height: auto;" />'
          : __('no image', 'center3');
      };

      return static::setColumnsBody($columns);
    }

    public function fillColumns($column, $post_id)
    {
      $columns = $this->columnsBody;

      if (!isset($columns[$column])) return;

      $columns[$column]($column, $post_id);
    }

    /* columns body - end */

    /* columns sortable - begin */

    static public function setSortableColumns($columns)
    {
      return $columns;
    }

    static protected function setGenericSortableColumns($columns) {
      // $columns['beginTime'] = 'beginTime';
      // $columns['endTime'] = 'endTime';

      return static::setSortableColumns($columns);
    }

    public function sortableColumns($columns)
    {
      return static::setGenericSortableColumns($columns);
    }

    /* columns sortable - end */

    /* columns sort - begin */

    static public function setColumnsSort($columns) {
      return $columns;
    }

    static protected function setGenericColumnsSort() {
      $columns = [];

      // $columns['beginTime'] = function($query) {
      //   $query->set('meta_key', 'beginTime');
      //   $query->set('orderby', 'meta_value');
      // };

      // $columns['endTime'] = function($query) {
      //   $query->set('meta_key', 'endTime');
      //   $query->set('orderby', 'meta_value');
      // };

      // $columns['field_key'] = function($query) {
      //   $meta_query = [
      //     'relation' => 'OR',
      //     [
      //       'key' => 'field_key',
      //       'compare' => 'NOT EXISTS',
      //     ],
      //     [
      //       'key' => 'field_key',
      //     ],
      //   ];

      //   $query->set('meta_query', $meta_query);
      //   $query->set('orderby', 'meta_value');
      // };

      return static::setColumnsSort($columns);
    }

    public function sortColumns($query)
    {

      if ($query->get('post_type') !== static::$postTypeName) return;
      $orderBy = $query->get('orderby');

      $columns = $this->columnsSort;

      if (!isset($columns[$orderBy])) return;

      $columns[$orderBy]($query);
    }

    /* columns sort - end */
  }
