<?php

  namespace ThemeClasses\Settings;

  class Admin
  {
    public function __construct()
    {
      $this->removeComments();
      // $this->removePages();
      $this->removePosts();
      // $this->removeMedia();
      $this->disableBlockEditor();
    }

    private function removeComments()
    {
      // Disable support for comments and trackbacks in post types
      add_action('admin_init', function() {
        $postTypes = get_post_types();
        foreach ($postTypes as $postType) {
          if (post_type_supports($postType, 'comments')) {
            remove_post_type_support($postType, 'comments');
            remove_post_type_support($postType, 'trackbacks');
          }
        }
      });

      // Close comments on the front-end
      add_filter('comments_open', '__return_false', 20, 2);
      add_filter('pings_open', '__return_false', 20, 2);

      // Hide existing comments
      add_filter('comments_array', '__return_empty_array', 10, 2);

      // Remove comments page in menu
      add_action('admin_menu', function() {
        remove_menu_page('edit-comments.php');
      });

      // Redirect any user trying to access comments page
      add_action('admin_init', function() {
        global $pagenow;
        if ($pagenow === 'edit-comments.php') {
          wp_redirect(admin_url());
          exit;
        }
      });

      // Remove comments metabox from dashboard
      add_action('admin_init', function() {
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
      });

      // Remove comments links from admin bar
      add_action('init', function() {
        if (is_admin_bar_showing()) {
          remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
        }
      });
    }

    private function removePosts()
    {
      // Remove posts page in menu
      add_action('admin_menu', function() {
        remove_menu_page('edit.php');
      });

      // Redirect any user trying to access posts page
      add_action('admin_init', function() {
        if (get_current_screen() === 'edit-post') {
          wp_redirect(admin_url());
          exit;
        }
      });

      // Remove +New post in top Admin Menu Bar
      add_action('admin_bar_menu', function($wpAdminBar) {
        $wpAdminBar->remove_node('new-post');
      }, 999);

      // Remove Quick Draft Dashboard Widget
      add_action( 'wp_dashboard_setup', function() {
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
      }, 999);
    }

    private function removePages()
    {
      // Remove pages page in menu
      add_action('admin_menu', function() {
        remove_menu_page('edit.php?post_type=page');
      });

      // Redirect any user trying to access pages page
      add_action('admin_init', function() {
        if (get_current_screen() === 'edit-page') {
          wp_redirect(admin_url());
          exit;
        }
      });
    }

    private function removeMedia()
    {
      // Remove pages page in menu
      add_action('admin_menu', function() {
        remove_menu_page('upload.php');
      });

      // Redirect any user trying to access pages page
      add_action('admin_init', function() {
        if (get_current_screen() === 'upload') {
          wp_redirect(admin_url());
          exit;
        }
      });
    }

    private function disableBlockEditor()
    {
      add_filter('use_block_editor_for_post', '__return_false');
    }
  }
