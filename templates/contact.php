<?php
  /**
  * Template Name: Contact page
  */

  get_header();

  /*
  $title = get_the_title();
  get_part('layout/pageHeader', [
    'category' => $title,
    'breadcrumbs' => [
      'items' => [
        [
          'title' => $title,
        ],
      ],
    ],
  ]);
  */
?>
<main class="page">
  <?php get_part('layout/withSidebar', [
    'mainContent' => join_parts([
      get_part('layout/form/contact', get_field('contactForm'), false),
    ], false),
    'sideContent' => get_part('components/contactSidebar', [], false),
    'class' => 'withSidebar--contact'
  ]); ?>
</main>
<?php
  get_footer();
