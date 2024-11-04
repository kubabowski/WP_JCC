<?php
  get_header();

  $archiveOptions = get_field('archive_options', 'option') ?? [];
  $servicesOptions = $archiveOptions['services'] ?? [];

  $pageTitle = $servicesOptions['title'] ?? __('Services', 'jcc-solutions');
  $pageDescription = $servicesOptions['description'] ?? '';

  
?>
<main id="main" class="">
  <?php

    get_flexible('servicesOptions', true);

    get_part('sections/servicesOptions', [
      'items' => [
        [
          'title' => $pageTitle,
        ],
      ],
    ]);

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

    
    // get_flexible();
  ?>
</main>
<?php
  get_footer();
