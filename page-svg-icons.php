<?php
  get_header();

  $pageTitle = 'Icons';
  $pageDescription = 'Svg icons list';

  $rawIcons = file_get_contents(INCLUDES . '/layout/icons.php');
  // $rawIcons = get_part('/layout/icons', [], false);
  preg_match_all('/<symbol id="(.*?)" viewBox/m', $rawIcons, $matches);
  $icons = $matches[1];
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
  ?>
  <section class="pb-64px">
    <div class="wrapper">
      <div class="flex flex-wrap gap-24px">
        <?php foreach ($icons as $icon): ?>
          <div class="flex flex-col items-start">
            <div class="flex items-center justify-center text-72px/1 text-neutral-dark border border-border-gray">
              <svg class="icon"><use xlink:href="#<?= $icon ?>"></use></svg>
            </div>
            <span class="mt-4px"><?= substr($icon, 5) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>
<?php
  get_footer();
