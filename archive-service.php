<?php
  get_header();

  $archiveOptions = get_field('archive_options', 'option') ?? [];
  $servicesOptions = $archiveOptions['services'] ?? [];

  $pageTitle = $servicesOptions['title'] ?? __('Services', 'bud-went');
  $pageDescription = $servicesOptions['description'] ?? '';

  
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

    
    // get_flexible();
  ?>
</main>
<?php
  get_footer();
