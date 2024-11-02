<?php
  get_header();

  $pageTitle = __('404', 'bud-went');
  $pageDescription = __('Nie znaleziono strony', 'bud-went');
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
      'button' => [
        'title' => __('Strona główna', 'bud-went'),
        'url' => home_url('/'),
      ],
    ]);

    // get_template_part('includes/sections/notFound');
  ?>
</main>

<?php
  get_footer();
