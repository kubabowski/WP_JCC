<?php
  $rootClass = '';
  $rootAttr = '';



  $page = $props['page'] ?? 1;
  $per_page = $props['per_page'] ?? null;
  $orderby = $props['orderby'] ?? 'date';
  $order = $props['order'] ?? 'ASC';
  $search = $props['search'] ?? '';

  $itemsPage =  apply_filters('getServices', [], [
    'with_pages'  => true,
    'page'        => $page,
    'per_page'    => $per_page,
    'orderby'     => $orderby,
    'order'       => $order,
    'search'      => $search,
        
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


  

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="<?= $rootClass ?>" <?= $rootAttr ?>>
  <div class="wrapper pb-96px">
    <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-32px">
      

      <div class="md:col-span-2 lg:col-span-3">
        

        <form
          action="<?= add_query_arg([]) ?>"
          method="get"
          class="flex flex-col md:flex-row md:flex-wrap gap-16px md:gap-32px text-neutral-gray mb-32px"
          autocomplete="off"
          data-services-filters
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
              aria-label="<?= __('Choose number of services on page', 'jcc-solutions') ?>"
              data-services-filters-select
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
              data-services-filters-select
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
              placeholder="<?= __('Enter Service name', 'jcc-solutions') ?>"
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
            <?php get_part('components/serviceTile', [
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