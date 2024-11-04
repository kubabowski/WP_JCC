<?php
$rootClass = '';
$rootAttr = '';

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];


$topics = get_terms([
  'taxonomy'   => 'topic',
  'hide_empty' => true,
]);

$companies = get_terms([
  'taxonomy'   => 'company',
  'hide_empty' => true,
]);

?>
<section class="calendar my-40px md:mt-58px md:mb-[128px] <?= $rootClass ?> " <?= $rootAttr ?>>

  <div class="wysiwyg">

    <div class="wrapper wpcf7">

      <?php if (!empty($props['title'])): ?>
        <header class="mb-48px flex items-center">
          <h2 class="flex-shrink-0 text-36px/1_2 lg:text-40px/1_2 font-normal text-neutral-dark">
            <?= $props['title'] ?>
          </h2>
          <div class="flex-grow-1 block h-px w-full ms-24px bg-neutral-dark"></div>
        </header>
      <?php endif; ?>

      <form class="wpcf7-form">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-24px">

          <!-- companies -->
          <div>
            <select name="company" id="company">
              <option value=""><?= __('Wszystkie', 'jcc-solutions') ?></option>
              <?php
              if (!empty($companies)) {
                foreach ($companies as $company) {
                  echo '<option value="' . $company->slug . '">' . $company->name . '</option>';
                }
              }
              ?>
            </select>
            <label for="company"><?= __('Firma', 'jcc-solutions') ?></label>
          </div>

          <!-- topics -->
          <div>
            <select name="topic" id="topic">
              <option value=""><?= __('Wszystkie', 'jcc-solutions') ?></option>
              <?php
              if (!empty($topics)) {
                foreach ($topics as $topic) {
                  echo '<option value="' . $topic->slug . '">' . $topic->name . '</option>';
                }
              }
              ?>
            </select>
            <label for="topic"><?= __('Tematyka szkolenia', 'jcc-solutions') ?></label>
          </div>

        </div>
      </form>
    </div>
  </div>

  <div class="wrapper mt-48px">
    <div class="grid grid-cols-12 gap-24px">

      <div class="col-span-12 md:col-span-8 ">

        <!-- calendar main -->
        <div class="calendar-main">
          <header class="<?= cx([
                            'flex items-center justify-between',
                            ' p-8px mb-8px',
                            'bg-neutral-dark/5',
                          ]) ?>">


            <div class="header-display ">
              <p class="<?= cx([
                          'display',
                          ' text-20px/1_6 font-medium text-neutral-dark/40',
                          '[&>span]:text-neutral-dark',
                        ]) ?>"></p>
            </div>

            <div class="flex items-center gap-16px ">
              <button class="left h-auto size-24px rotate-180"><?= get_icon('arrow', 'inline-block text-neutral-dark size-24px'); ?></button>
              <button class="right  h-auto size-24px"><?= get_icon('arrow', 'inline-block text-neutral-dark size-24px'); ?></button>
            </div>
          </header>

          <div class="<?= cx([
                        'week',
                        'grid grid-cols-[repeat(7,1fr)] justify-center',
                        'm-auto pb-24px',
                        'text-18px/1_6 text-neutral-dark/40',
                        '[&>span]:py-4px md:[&>span]:py-8px [&>span]:px-6px md:[&>span]:px-[10px]',
                      ]) ?>">
            <span><?= __('Pon', 'jcc-solutions') ?></span>
            <span><?= __('Wto', 'jcc-solutions') ?></span>
            <span><?= __('Śro', 'jcc-solutions') ?></span>
            <span><?= __('Czw', 'jcc-solutions') ?></span>
            <span><?= __('Pią', 'jcc-solutions') ?></span>
            <span><?= __('Sob', 'jcc-solutions') ?></span>
            <span><?= __('Nie', 'jcc-solutions') ?></span>
          </div>
          <div class="<?= cx([
                        'days',
                        'grid grid-cols-[repeat(7,1fr)] gap-y-16px justify-center m-auto',
                        'text-18px/1_6 md:text-24px/1_6',
                        '[&>div]:size-32px md:[&>div]:size-[54px] [&>div]:flex [&>div]:justify-center [&>div]:items-center ',
                        '[&>.event-date]:bg-neutral-red [&>.event-date]:text-white [&.featured_.event-date:not(.highlight)]:bg-neutral-dark/30',
                        '[&>.event-date]:cursor-pointer [&>.event-date.active]:!bg-[#BD1622]',
                      ]) ?>"></div>
        </div>
      </div>

      <!-- calendar sidebar -->
      <div class="col-span-12 md:col-span-4">
        <header class="p-8px bg-neutral-dark/5 mb-8px">
          <p class="text-20px/1_6 font-medium text-neutral-dark"><?= __('Lista szkoleń', 'jcc-solutions') ?></p>
        </header>
        <div class="calendar-sidebar [&_.active-event]:cursor-pointer [&.featured_.event:not(.highlight):not(.active)]:hidden"></div>
      </div>

    </div>
  </div>

  <?php get_part('components/modalForm', [
    'id' => '79c8967',
  ]); ?>

</section>