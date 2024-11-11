<?php
  $rootClass = '';
  $rootAttr = '';

 $Services = get_field('servicesOptions', 'option') ?? [];
 $pageTitle = get_the_title() ?? 'No title';

  $categoryTerm = $props['category'] ?? null;

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

//var_dump($props);
?>
<section>

<div class="hero-categories-spacer-bg" style="background-image: url('<?= $props['heroImage']['url'] ?>')"></div>

    <div class="hero-categories">
        <div class="hero-categories-container">
            <div class="container">
                <?php get_part('layout/breadcrumbs', [
                    'items' => [
                        [
                            'title' => $props['title'],
                            'url' => get_post_type_archive_link($props['post-type']),
                        ],

                    ],
                ]); ?>

                <h2 class="header fw-500 fs-56 lh-64 t-white">
                    <?= $props['title']?>
                </h2>

                <div class="hero-cat-line"></div>

                <div class="filter-label">
                <span class="t-white fw-500 fs-20 lh-28">
                    <?php echo isset($heroCatFilterLabel) ? $heroCatFilterLabel : 'Filter by';  ?>:
                </span>

<!--                    --><?php //echo file_get_contents(BASE_PATH . 'assets/icons/filter-arrow.svg'); ?>

                </div>

                <div class="hero-categories-filters">
                    <ul>
                        <li>
                            <a href="/case-studies" class="t-white fw-700 fs-12 lh-14 uppercase">
                                <?php echo isset($translteLabels["all"]) ? $translteLabels["all"] : 'all';  ?>
                            </a>
                        </li>

                        <?php foreach ($props['categories'] as $category): ?>
                            <li>
<!--                                --><?php //var_dump($category); ?>
                                <a class="t-white fw-700 fs-12 lh-14 uppercase" href="<?php echo $category->slug; ?>">
                                    <?php echo $category->name; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="featured-case">
                    <?php
                    get_part('components/featuredItem', [
                        'featured' => $props['featured']
                    ]);
                    ?>
<!--                    --><?php //include BASE_PATH . '/components/featuredCase.php'; ?>
                </div>
            </div>
        </div>
    </div>





</section>





