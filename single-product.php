<?php
  get_header();

  $pageTitle = get_the_title() ?? 'No title';
  $pageDescription = get_field('description') ?? '';

  $productsOptions = get_field('products_options', 'option') ?? [];
  $productContact = $productsOptions['contact_section'] ?? [];

  $productData = get_field('product_data') ?? [];
?>
<main id="main" class="flex flex-col flex-grow mt-header-height">
    <?php echo do_shortcode('[rt_reading_time label="Reading Time:" postfix="minutes"]'); ?>
  <?php
    get_part('layout/breadcrumbs', [
      'items' => [
        [
          'title' => __('Produkty', 'jcc-solutions'),
          'url' => get_post_type_archive_link('product'),
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

    get_part('sections/productTabs', [
      'data' => $productData,
    ]);

    get_part('sections/headingCta', [
      'label' => $productContact['label'] ?? '',
      'link' => $productContact['link'] ?? [],
      'title' => $productContact['title'] ?? '',
      'button' => $productContact['button'] ?? [],
      'button_accent' => $productContact['button_accent'] ?? [],
    ]);
    // get_flexible();
  ?>
</main>
<?php
  get_footer();
