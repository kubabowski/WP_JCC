<?php

  namespace ThemeClasses\Controller;

  class News
  {
    use GenericPost;
    use GenericColumns;

    static protected $postTypeName = 'News';
    static protected $postTypeSlug = 'news';

    public function __construct()
    {
      $this->initPost();
      $this->initColumns();
    }

    static public function extendPostDetails($postObj, $postDetails)
    {
      $postId = $postObj->ID;

      return array_merge($postDetails, [
        'image' => get_field('image', $postId),
      ]);
    }
  }
