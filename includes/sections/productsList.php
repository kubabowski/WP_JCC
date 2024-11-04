<?php
  $rootClass = '';
  $rootAttr = '';

  $categoryTerm = $props['category'] ?? null;
  $manufacturerTerm = $props['manufacturer'] ?? null;

  $listTitle = $categoryTerm ? $categoryTerm->name : __('Wszystkie produkty', 'jcc-solutions');
  $backLink = $categoryTerm ? get_post_type_archive_link('product') : null;

  $page = $props['page'] ?? 1;
  $per_page = $props['per_page'] ?? null;
  $orderby = $props['orderby'] ?? 'date';
  $order = $props['order'] ?? 'ASC';
  $search = $props['search'] ?? '';

  $itemsPage =  apply_filters('getProducts', [], [
    'with_pages'  => true,
    'page'        => $page,
    'per_page'    => $per_page,
    'orderby'     => $orderby,
    'order'       => $order,
    'search'      => $search,
    'category'    => $categoryTerm
      ? $categoryTerm->slug
      : null,
    'manufacturer'    => $manufacturerTerm
      ? $manufacturerTerm->slug
      : null,
  ]);

  $items = $itemsPage['items'] ?? [];
  $total = $itemsPage['total'] ?? 1;
  $pages = $itemsPage['pages'] ?? 1;

  $perPageOptions = [
    [
      'value' => 6,
      'label' => 6,
    ],
    [
      'value' => 12,
      'label' => 12,
    ],
    [
      'value' => 24,
      'label' => 24,
    ],
  ];

  $orderOptions = [
    [
      'value' => 'DESC',
      'label' => __('Od najnowszych', 'jcc-solutions'),
    ],
    [
      'value' => 'ASC',
      'label' => __('Od najstarszych', 'jcc-solutions'),
    ],
  ];

  // $categories = array_map(function($category) {
  //   return [
  //     'name'  => $category->name,
  //     'slug'  => $category->slug,
  //     'url'   => get_term_link($category, $category->taxonomy),
  //   ];
  // }, get_terms([
  //   'taxonomy'    => 'product-category',
  //   'hide_empty'  => true,
  //   'parent'      => $categoryTerm
  //     ? $categoryTerm->term_id
  //     : null,
  // ]));

  // $manufacturers = array_map(function($manufacturer) use ($manufacturerTerm) {
  //   return [
  //     'name'    => $manufacturer->name,
  //     'slug'    => $manufacturer->slug,
  //     'url'     => get_term_link($manufacturer, $manufacturer->taxonomy),
  //     'active'  => $manufacturerTerm
  //       ? $manufacturer->slug === $manufacturerTerm->slug
  //       : false,
  //   ];
  // }, get_terms([
  //   'taxonomy'    => 'product-manufacturer',
  //   'hide_empty'  => true,
  //   // 'parent'      => $manufacturerTerm
  //   //   ? $manufacturerTerm->term_id
  //   //   : null,
  // ]));

  $categories = null;
  $manufacturers = null;

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="<?= $rootClass ?>" <?= $rootAttr ?>>
  <div class="wrapper pb-96px">
    <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-32px">
      <div class="block">
        <?php if ($categories): ?>
          <h2
            class="text-24px/1_2 font-medium mb-24px"
          ><?= __('Kategoria', 'jcc-solutions') ?>:</h2>

          <ul class="block">
            <?php foreach ($categories as $category): ?>
              <li>
                <a
                  class="<?= cx([
                    'flex items-center justify-betwee',
                    'text-16px/1_6 text-neutral-gray',
                    'hover:text-neutral-dark',
                    'transition-colors',
                  ]) ?>"
                  href="<?= $category['url'] ?>"
                >
                  <span><?= $category['name'] ?></span>
                  <?php get_icon('chevron-right', 'icon flex-shrink-0 ms-4px'); ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <?php if ($manufacturers): ?>
          <h2
            class="<?= cx([
              'text-24px/1_2 font-medium mb-24px',
              $categories ? 'mt-40px' : null,
            ]) ?>"
          ><?= __('Producent', 'jcc-solutions') ?>:</h2>

          <ul class="flex flex-wrap gap-12px">
            <?php foreach ($manufacturers as $manufacturer): ?>
              <li>
                <a
                  class="<?= cx([
                    'flex items-center',
                    'p-8px min-h-[2.875rem] border',
                    $manufacturer['active']
                      ? 'border-neutral-dark text-neutral-dark bg-neutral-gray/5'
                      : 'border-border-gray text-neutral-gray',
                    'hover:text-neutral-dark',
                    'transition-colors',
                  ]) ?>"
                  href="<?= $manufacturer['url'] ?>"
                >
                  <span><?= $manufacturer['name'] ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>

      <div class="md:col-span-2 lg:col-span-3">
        <div class="flex items-center mb-24px">
          <?php if ($backLink): ?>
          <a
            href="<?= $backLink ?>"
            class="<?= cx([
              'flex items-center',
              'text-16px/1_2 font-medium text-neutral-gray',
              'hover:text-neutral-dark',
              'transition-colors'
            ]) ?>"
          >
            <?php get_icon('long-arrow-left', 'icon text-24px/1 me-8px'); ?>
            <span><?= __('Wróc', 'jcc-solutions') ?></span>
          </a>
          <span class="w-px h-24px bg-border-gray mx-24px"></span>
          <?php endif; ?>
          <h2 class="text-24px/1_2 font-medium"><?= $listTitle ?></h2>
        </div>

        <form
          action="<?= add_query_arg([]) ?>"
          method="get"
          class="flex flex-col md:flex-row md:flex-wrap gap-16px md:gap-32px text-neutral-gray mb-32px"
          autocomplete="off"
          data-products-filters
        >
          <div class="flex items-center text-16px/1_2">
            <strong
              class="font-medium text-neutral-dark me-6px"
            ><?= __('Produkty', 'jcc-solutions') ?>:</strong>
            <span><?= $total ?></span>
          </div>

          <div class="flex items-center text-16px/1_2">
            <strong
              class="font-medium text-neutral-dark me-6px"
            ><?= __('Na stronę', 'jcc-solutions') ?>:</strong>
            <select
              name="per_page"
              class="px-6px -mx-6px"
              aria-label="<?= __('Wybierz liczbe produktów na stronie', 'jcc-solutions') ?>"
              data-products-filters-select
            >
              <?php foreach ($perPageOptions as $perPageOption): ?>
                <option
                  value="<?= $perPageOption['value'] ?>"
                  <?= $perPageOption['value'] === $per_page ? 'selected' : '' ?>
                ><?= $perPageOption['label'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="flex items-center text-16px/1_2">
            <strong
              class="font-medium text-neutral-dark me-6px"
            ><?= __('Sortuj', 'jcc-solutions') ?>:</strong>
            <select
              name="order"
              class="px-6px -mx-6px"
              aria-label="<?= __('Wybierz sortowanie', 'jcc-solutions') ?>"
              data-products-filters-select
            >
              <?php foreach ($orderOptions as $orderOption): ?>
                <option
                  value="<?= $orderOption['value'] ?>"
                  <?= $orderOption['value'] === $order ? 'selected' : '' ?>
                ><?= $orderOption['label'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="relative min-w-[14rem] lg:ms-auto md:w-full lg:w-[calc(33.33%-1rem)]">
            <input
              type="search"
              name="search"
              value="<?= $search ?>"
              placeholder="<?= __('Wpisz nazwę produktu', 'jcc-solutions') ?>"
              class="block w-full h-[60px] bg-neutral/5 py-8px ps-16px pe-40px"
            >
            <button
              tyoe="submit"
              class="absolute block size-24px text-24px/1 top-1/2 end-16px -mt-12px"
            ><?php get_icon('search', 'icon'); ?></button>
          </div>
        </form>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-32px">
          <?php foreach ($items as $item): ?>
            <?php get_part('components/productTile', [
              'item' => $item,
            ]); ?>
          <?php endforeach; ?>
        </div>

        <?php get_part('components/pagination', [
          'class' => 'mt-32px',
          'page' => $page,
          'pages' => $pages,
        ]); ?>
      </div>
    </div>
  </div>
</section>