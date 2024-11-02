<?php
  get_header();

  $pageTitle = get_the_title() ?? 'No title';
  $pageDescription = get_field('description') ?? '';
?>
<main id="main" class="flex flex-col flex-grow mt-header-height">
  <?php
    get_part('layout/breadcrumbs', [
      'items' => [
        [
          'title' => $pageTitle,
        ],
      ],
    ]);
    get_part('layout/pageHead', [
      'title' => $pageTitle,
      'text' => $pageDescription,
    ]);

    get_flexible();
  ?>
</main>
<?php
  get_footer();
