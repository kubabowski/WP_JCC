<?php

  namespace ThemeClasses\Controller;

  class Insight
  {
    use GenericPost;
    use GenericColumns;

    static protected $postTypePrefix = 'Insight';
    static protected $postTypeName = 'insight';
    static protected $postTypeSlug = 'insight';

    public function __construct()
    {
      $this->initPost();
      $this->initColumns();

      // parseInsightWysiwyg
      add_filter('parse' . static::$postTypePrefix . 'Wysiwyg', [$this, 'parseWysiwyg'], 10, 2);
    }

    static public function extendPostDetails($postObj, $postDetails)
    {
      $postId = $postObj->ID;

      return array_merge($postDetails, [
        'text' => get_field('description', $postId),
        'image' => get_field('image', $postId),
      ]);
    }

    static public function parseWysiwyg($content) {
      // mark floating image paragraph
      $content = preg_replace(
        '/(<p)(><img.*?class=".*?(alignright|alignleft).*?".*?><\/p>)/i',
        "$1 class=\"onlyfloatingimg\"$2",
        $content
      );

      // wrap tables by scroll
      // $content = preg_replace(
      //   '/(<table(?:\n|.)*?<\/table>)/i',
      //   "<div class=\"w-full overflow-auto\">$1</div>\e",
      //   $content
      // );

      // echo "\n###\n";
      // echo preg_last_error_msg();
      // echo "\n###\n";

      // open table tag
      $content = preg_replace(
        '/(<table.*?>)/i',
        "<div class=\"w-full overflow-auto\">$1",
        $content
      );

      // close table tag
      $content = preg_replace(
        '/(<\/table>)/i',
        "$1</div>",
        $content
      );

      return $content;
    }
  }
