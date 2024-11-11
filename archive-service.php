<?php
  get_header();
    $serviceController = new \ThemeClasses\Controller\Service();
    $serviceCategoryTaxonomy = new \ThemeClasses\Taxonomy\ServiceCategory();

    $archiveOptions = get_field('archive_options', 'option') ?? [];
    $servicesOptions = $archiveOptions['services_options'] ?? [];

    $pageTitle = $servicesOptions['title'] ?? __('Services', 'jcc-solutions');
    $pageDescription = $servicesOptions['description'] ?? '';


    $heroImage = $servicesOptions['hero_image'] ?? "";
    $featuredObject = $servicesOptions['featured'][0] ?? '';
    $categoryTerm = $props['category'] ?? null;

    $servicesCategories = apply_filters('getServicesCategorys', [], [
        'category' => $categoryTerm ? $categoryTerm->slug : null,
    ]);

    $featured = $serviceController->getDetailsById($featuredObject);
    $servicesCategories = $serviceCategoryTaxonomy->getServiceCategories();

    $list = apply_filters('getServices', [], []);


    var_dump($servicesCategories);



?>
<main id="main" class="">
  <?php

    get_part('sections/searchHeader', [
        'title' => $pageTitle,
        'post-type' => 'service',
        'heroImage' => $heroImage,
        'categories' => $servicesCategories,
        'featured' => $featured,
        'list' => $list,
    ]);

  get_part('sections/itemsList', [
    'list' => $list,
    'title' => $pageTitle,
  ]);



  ?>
</main>
<?php
  get_footer();
