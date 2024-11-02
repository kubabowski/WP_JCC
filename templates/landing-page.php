<?php
  /**
   * Template Name: Landing Page
   */

  get_header();
?>
<main class="sections">
  <?php get_part('sections/personnelListWithTabs'); ?>
  <?php get_flexible(); ?>
</main>
<?php
  get_footer();
