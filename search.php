<?php get_header(); ?>

<?php
$query = get_search_query();
$title = '"' . $query . '"';

$noResults = __('Nic nie znaleziono', 'jcc-solutions');
$rootDescription = $productsOptions['description'] ?? '';

$products =  apply_filters('getProducts', [], [
  'with_pages'  => true,
  'search'      => $query,
  'per_page' => 4,
]);

$itemsProducts = $products['items'] ?? [];
$totalProducts = $products['total'] ?? 0;

$args = [
  'post_type' => ['knowledge', 'page'],
  's' => $query,
  'posts_per_page' => -1,
  'post_type__not_in' => ['product'],
];
$searchQuery = new WP_Query($args);
$totalPosts = $searchQuery->found_posts ?? 0;

$totalResults = $totalProducts + $totalPosts;

function get_result_label($count)
{
  if ($count == 1) {
    return $count . " " . __('Wynik', 'jcc-solutions');
  } elseif ($count % 10 >= 2 && $count % 10 <= 4 && ($count % 100 < 10 || $count % 100 >= 20)) {
    return $count . " " . __('Wyniki', 'jcc-solutions');
  } else {
    return $count . " " . __('Wyników', 'jcc-solutions');
  }
}


?>
<main id="main" class="flex flex-col flex-grow mt-header-height pb-96px">
  <?php
  get_part('layout/breadcrumbs', [
    'items' => [
      [
        'title' => $title,
      ],
    ],
  ]);
  get_part('layout/pageHead', [
    'title' => $title,
    'text' => get_result_label($totalResults),
  ]);
  ?>
  <?php if ($totalResults > 0) : ?>
    <?php if ($itemsProducts and !empty($itemsProducts)) : ?>
      <section>
        <div class="wrapper">
          <div class="flex flex-wrap flex-row gap-24px justify-between">
            <p class="flex flex-row items-center gap-8px">
              <span class="text-24px/1_2 font-medium text-neutral-dark"><?= __('Produkty', 'jcc-solutions') ?></span>
              <span class="text-18px/1_2 text-neutral-gray"><?= get_result_label($totalProducts); ?> </span>
            </p>

            <?php get_part('components/button', [
              'text' => __('Zobacz wszystkie produkty', 'jcc-solutions'),

              'url' => add_query_arg('search', $query, get_post_type_archive_link('product')),
              'theme' => 'red',
            ]); ?>
          </div>
          <hr class="bg-neutral-gray mt-8px" />

          <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-32px mt-32px">
            <?php foreach ($itemsProducts as $item): ?>
              <?php get_part('components/productTile', [
                'item' => $item,
              ]); ?>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <?php if ($searchQuery->have_posts()) : ?>
      <section class="mt-48px">
        <div class="wrapper">

          <div class="flex flex-wrap flex-row gap-24px justify-between">
            <p class="flex flex-row items-center gap-8px">
              <span class="text-24px/1_2 font-medium text-neutral-dark"><?= __('Inne', 'jcc-solutions') ?></span>
              <span class="text-18px/1_2 text-neutral-gray"><?= get_result_label($totalPosts); ?> </span>
            </p>

          </div>
          <hr class="bg-neutral-gray mt-8px" />

          <div class="mt-32px flex flex-col gap-48px max-w-[906px]">
            <?php while ($searchQuery->have_posts()) : $searchQuery->the_post(); ?>
              <div class="post-item">
                <p class="text-16px/1_2 font-medium text-neutral-dark underline">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </p>

                <?php
                $description = '';
                if (get_field('description', get_the_ID())) {
                  $description = get_field('description', get_the_ID());
                } else {
                  $description = get_the_excerpt();
                }
                ?>

                <?php if ($description) :  ?>
                  <p class="text-16px/1_4 text-neutral-gray mt-24px">
                    <?php echo wp_trim_words($description, 20); ?>
                  </p>
                <?php endif; ?>


              </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
          </div>

        </div>
      </section>
    <?php endif; ?>
  <?php else : ?>

    <section class="mt-48px"></section>
    <div class="wrapper">
      <p class="text-24px/1_2 font-medium text-neutral-dark">
        <?= __('Nie znaleziono wyników', 'jcc-solutions') ?>
      </p>
    </div>
    </section>

  <?php endif; ?>


</main>
<?php
get_footer();
