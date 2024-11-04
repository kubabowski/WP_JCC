<?php
  get_header();

  $pageTitle = get_the_title() ?? 'No title';
  $pageDescription = get_field('description') ?? '';

  $servicesOptions = get_field('services_options', 'option') ?? [];

  $serviceData = get_field('service_data') ?? [];

  if (!$serviceData) {
    error_log('Service data not found for post ID: ' . get_the_ID());
}
?>
<main id="main" class="flex flex-col flex-grow mt-header-height">
  <?php
    get_part('layout/breadcrumbs', [
      'items' => [
        [
          'title' => __('Services', 'jcc-solutions'),
          'url' => get_post_type_archive_link('service'),
        ],
        [
          'title' => $pageTitle,
        ],
      ],
    ]);
    get_part('layout/pageHead', [
      'title' => $pageTitle,
      'text' => $pageDescription,
      'size' => 'small',
      'button' => [
        'title' => __('Zamów produkt', 'jcc-solutions'),
        'url' => '#',
      ],
    ]);

   
    // get_flexible();
  ?>
</main>
<?php
  get_footer();
