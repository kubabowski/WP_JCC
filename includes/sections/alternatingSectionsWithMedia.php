<?php
$rootClass = '';
$rootAttr = '';

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

?>
<section class="relative<?= $rootClass ?> mb-64px lg:mb-[155px]" <?= $rootAttr ?>>

  <?php foreach ($props['rows'] as $row) : ?>
    <div class="relative group">
      <div class="group-even:hidden contents-[''] absolute -z-10 top-1/2 translate-y-[-50%] w-full h-full lg:h-4/5 bg-neutral-dark/5"></div>
      <div class="wrapper">
        <div class="flex items-center flex-col-reverse lg:flex-row  group-even:lg:flex-row-reverse object-cover lg:-mt-72px group-first:mt-0">

          <div class="flex-1 flex gap-16px xl:gap-32px flex-col py-72px group-last:pb-0 items-center group-even:xl:pl-[91px] group-odd:xl:pr-[91px]">
            <?php get_part('components/picture', [
              'imgClass' => /*tw:*/ 'block w-auto max-h-[70px]',
              'sources' => [[
                'src' => $row['logo']['sizes']['square-lg'] ?? $row['logo']['url'],
                'width' => $row['logo']['width'],
                'height' => $row['logo']['height'],
                'alt' => $row['logo']['alt'] ?? __('logo', 'jcc-solutions'),
              ]],
            ]); ?>

            <?php if ($row['files'] && !empty($row['files'])) : ?>
              <div class="grid md:grid-cols-2 gap-16px group-odd:[&_.custom-gradient-border]:after:bg-[#f3f3f3]">
                <?php foreach ($row['files'] as $key => $file) : ?>

                  <?php get_part('components/fileButton', [
                    'item' => $file,
                  ]); ?>

                <?php endforeach; ?>
              </div>
            <?php endif; ?>

          </div>

          <div class="flex-none lg:w-2/5 xl:w-[51.5%] bg-link-blue lg:pb-0 lg:h-[468px]">
            <?php get_part('components/picture', [
              'imgClass' => /*tw:*/ 'block size-full object-cover',
              'sources' => [[
                'src' => $row['img']['sizes']['square-lg'] ?? $row['img']['url'],
                'width' => $row['img']['width'],
                'height' => $row['img']['height'],
                'alt' => $row['img']['alt'] ?? __('Zdjęcie', 'jcc-solutions'),
              ]],
            ]); ?>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

</section>