<?php
get_header();
$serviceController = new \ThemeClasses\Controller\Service();

$queried_object = get_queried_object();
$term = $queried_object;

$archiveOptions = get_field('archive_options', 'option') ?? [];
$servicesOptions = $archiveOptions['services_options'] ?? [];

$pageTitle = $term->name;
$pageDescription = $servicesOptions['description'] ?? '';


$heroImage = $servicesOptions['hero_image'] ?? "";
$featuredObject = $servicesOptions['featured'][0] ?? '';
$categoryTerm = $props['category'] ?? null;

$servicesCategories = apply_filters('getServicesCategories', [], [
    'category' => $categoryTerm ? $categoryTerm->slug : null,
]);

$featured = $serviceController->getPostDetails($featuredObject);

$list = apply_filters('getServices', [], []);




?>
    <main id="main" class="">
        <?php

        get_part('sections/searchHeader', [
            'title' => $term,
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
