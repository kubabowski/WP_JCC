<?php
  get_header();

  $archiveOptions = get_field('archive_options', 'option') ?? [];
  $productsOptions = $archiveOptions['knowledge_base'] ?? [];

  $pageTitle = $productsOptions['title'] ?? __('Baza wiedzy', 'jcc-solutions');
  $pageDescription = $productsOptions['description'] ?? '';
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
    get_part('sections/featuredNews');
    get_part('sections/knowledgeBaseList');
  ?>
</main>
<?php
  get_footer();
