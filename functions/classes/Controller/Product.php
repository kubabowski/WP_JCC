<?php

  namespace ThemeClasses\Controller;

  class Product
  {
    use GenericPost;
    use GenericColumns;

    static protected $postTypePrefix = 'Product';
    static protected $postTypeName = 'product';
    static protected $postTypeSlug = 'produkt';

    public function __construct()
    {
      $this->initPost();
      $this->initColumns();

      // parseProductWysiwyg
      add_filter('parse' . static::$postTypePrefix . 'Wysiwyg', [$this, 'parseWysiwyg'], 10, 2);
    }

    static public function extendPostDetails($postObj, $postDetails)
    {
      $postId = $postObj->ID;

      return array_merge($postDetails, [
        'text' => get_field('description', $postId),
        'image' => get_field('image', $postId),
        'promotion' => get_field('product_promotion', $postId) ?? false,
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

      var_dump($content);

      return $content;
    }
  }
