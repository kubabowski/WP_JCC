<?php

  namespace ThemeClasses\Settings;

  class Media
  {
    public function __construct()
    {
      add_filter('intermediate_image_sizes', [$this, 'removeDefaultImageSizes']);

      $this->addCustomImageSizes();
    }

    public function removeDefaultImageSizes($sizes)
    {
      $toRemove = [
        // 'thumbnail',
        'medium',
        'medium_large',
        'large',
        '1536x1536',
        '2048x2048',
      ];

      // foreach ($sizes as $sizeIndex => $size) {
      //   if (in_array($size, $toRemove)) {
      //     unset($sizes[$sizeIndex]);
      //   }
      // }

      $keepSizes = [];
      foreach ($sizes as $sizeIndex => $size) {
        if (!in_array($size, $toRemove)) {
          $keepSizes[] = $size;
        }
      }
      $sizes = $keepSizes;

      return $sizes;
    }

    private function addCustomImageSizes()
    {
      add_image_size('full-hd', 1920, 1080, true);
      add_image_size('square-sm', 480, 480, true);
      add_image_size('square-md', 640, 640, true);
      add_image_size('square-lg', 960, 960, true);
      add_image_size('list-thumbnail', 260, 170, true);
    }
  }
