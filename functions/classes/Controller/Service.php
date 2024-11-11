<?php

  namespace ThemeClasses\Controller;

  class Service
  {
    use GenericPost;
    use GenericColumns;

    static protected $postTypePrefix = 'Service';
    static protected $postTypeName = 'service';
    static protected $postTypeSlug = 'service';

    public function __construct()
    {
      $this->initPost();
      $this->initColumns();

      // parseServiceWysiwyg
      add_filter('parse' . static::$postTypePrefix . 'Wysiwyg', [$this, 'parseWysiwyg'], 10, 2);
    }

    static public function extendPostDetails($postObj, $postDetails)
    {
      $postId = $postObj->ID;
      $serviceCategories = wp_get_post_terms($postId, 'service-category', ['fields' => 'all']);

//      $serviceData = get_field('service_data', $postId);
      $serviceData = get_field('service_data', $postId);
      $description = $serviceData['description'] ?? '';


      return array_merge($postDetails, [
        'desc' => $description,
        'serviceData' => $serviceData,
        'image' => get_field('image', $postId),
        'item-category' => $serviceCategories ?  $serviceCategories : null,
      ]);
    }

    // static public function extendPostDetails($postObj, $postDetails)
    // {
    //     $postId = $postObj->ID;

    //     // Retrieve term objects associated with the service-category taxonomy
    //     $serviceCategories = wp_get_post_terms($postId, 'service-category');

    //     // Check for errors or empty results
    //     if (is_wp_error($serviceCategories) || empty($serviceCategories)) {
    //         return array_merge($postDetails, [
    //             'text' => get_field('description', $postId),
    //             'image' => get_field('image', $postId),
    //             'service-category' => null, // Return null if no categories
    //         ]);
    //     }

    //     // Assuming you want the first category only
    //     $category = $serviceCategories[0]; // Get the first category

    //     // Return the first category data directly
    //     return array_merge($postDetails, [
    //         'text' => get_field('description', $postId),
    //         'image' => get_field('image', $postId),
    //         'service-category' => [ // Wrap it in an array to match your desired format
    //             'id' => $category->term_id,
    //             'name' => $category->name,
    //             'slug' => $category->slug,
    //             'description' => $category->description,
    //         ],
    //     ]);
    // }

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
