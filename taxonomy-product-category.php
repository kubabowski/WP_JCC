<?php
  get_header();

  $queried_object = get_queried_object();
  $term = $queried_object;

  $archiveOptions = get_field('archive_options', 'option') ?? [];
  $productsOptions = $archiveOptions['products'] ?? [];

  $rootTitle = $productsOptions['title'] ?? __('Produkty', 'jcc-solutions');
  $rootDescription = $productsOptions['description'] ?? '';

  $pageTitle = $term->name;

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
          'title' => $rootTitle,
          'url' => get_post_type_archive_link('product'),
        ],
        [
          'title' => $pageTitle,
        ],
      ],
    ]);
    get_part('layout/pageHead', [
      'title' => $rootTitle,
      'text' => $rootDescription,
    ]);

    get_part('sections/productsList', [
      'category' => $term,
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
