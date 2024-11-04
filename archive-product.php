<?php
  get_header();

  $archiveOptions = get_field('archive_options', 'option') ?? [];
  $productsOptions = $archiveOptions['products'] ?? [];

  $pageTitle = $productsOptions['title'] ?? __('Produkty', 'jcc-solutions');
  $pageDescription = $productsOptions['description'] ?? '';

  $page = intval(get_query_var('page', 1));
  $per_page = intval(get_query_var('per_page', 12));
  $orderby = get_query_var('orderby', 'date');
  $order = get_query_var('order', 'DESC');
  $search = get_query_var('search', '');
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

    get_part('sections/productsList', [
      'page' => $page,
      'per_page' => $per_page,
      'orderby' => $orderby,
      'order' => $order,
      'search' => $search,
    ]);
    // get_flexible();
  ?>
</main>
<?php
  get_footer();
