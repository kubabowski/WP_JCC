<?php

  namespace ThemeClasses\Settings;

  class Menu
  {
    public function __construct()
    {
      add_action('after_setup_theme', [$this, 'registerNavMenus']);
      add_filter('getMenuTree', [$this, 'getMenuTree'], 10, 2);
    }

    public function registerNavMenus()
    {
      register_nav_menus([
        'header_menu' => __('Header Menu', 'center3'),
        'footer_menu' => __('Footer Menu', 'center3'),
        'footer_links' => __('Footer Links', 'center3'),
      ]);
    }

    static public function extendTreeNode($menuItemObj, $itemTreeNode)
    {
      $itemId = $menuItemObj->ID;

      $itemProps = [];
      // $image = get_field('image', $itemId);
      // if (is_array($image)) {
      //   $itemProps['image'] = $image;
      // }
      $text = get_field('text', $itemId);
      if (!empty($text)) {
        $itemProps['text'] = $text;
      }

      return array_merge($itemTreeNode, $itemProps);
    }

    public function getMenuTree($menu = [], $location = '')
    {
      $flatMenu = $menu;
      $flatMenu = $this->getMenuItems($menu, $location);

      $treeMenu = [];
      $itemsRefs = [];

      $currentUrl = home_url(add_query_arg([]));

      foreach ($flatMenu as $menuItemObj) {
        $itemId = $menuItemObj->ID;
        $parentId = $menuItemObj->menu_item_parent;

        $itemUrl = $menuItemObj->url;
        $isActive = substr($currentUrl, 0, strlen($itemUrl)) === $itemUrl;

        $itemTreeNode = [
          'name' => $menuItemObj->title,
          'url' => $menuItemObj->url,
          'target' => $menuItemObj->target,
          'ID' => $itemId,
          'parentId' => $parentId,
          'children' => [],
          'active' => $isActive,
        ];

        $itemTreeNode = static::extendTreeNode($menuItemObj, $itemTreeNode);

        $itemsRefs[$itemId] = $itemTreeNode;

        if ($parentId == 0) {
          $treeMenu[] = &$itemsRefs[$itemId];
        } elseif (isset($itemsRefs[$parentId])) {
          $itemsRefs[$parentId]['children'][] = &$itemsRefs[$itemId];
        }
      }

      return $treeMenu;
    }

    private function getMenuItems($menu, $location)
    {
      // Get all locations
      $locations = get_nav_menu_locations();

      // Get object id by location
      $menuObject = wp_get_nav_menu_object($locations[$location]);

      // Check menu exists
      if (!is_object($menuObject)) return [];

      // Get menu items by menu slug
      $menu = wp_get_nav_menu_items($menuObject->slug);

      // Return menu post objects
      return $menu;
    }
  }
