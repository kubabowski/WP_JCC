<?php
$rootClass = '';
$rootAttr = '';

$text = $props['text'] ?? '';
$size = $props['size'] ?? 'default';
$vesion = $props['version'] ?? 'default';
$button = $props['button'] ?? null;
$author = $props['author'] ??  null;
$date = $props['date'] ?? null;

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="<?= $rootClass ?>" <?= $rootAttr ?>>
  <div class="wrapper py-48px">
    <div class="<?= cx([
                  'flex items-center',
                  $size === 'default' ? 'text-48px/1_2 md:text-72px/1_2' : null,
                  $size === 'small' ? 'text-36px/1_2 md:text-40px/1_2' : null,
                ]) ?>">
      <h1 class="<?= cx([
                    'flex-shrink-0 -mt-[0.1em] text-balance',
                    $vesion === 'default' ? 'max-w-2/3' : null,
                    $vesion === 'large' ? 'max-w-full md:max-w-[70%]' : null,
                  ]) ?>"><?= $props['title'] ?></h1>
      <?php if ($vesion === 'default'): ?>
        <div class="flex-grow-1 block self-start h-px w-full ms-24px mt-[0.6em] bg-neutral-dark"></div>
      <?php endif; ?>
      <?php if ($button): ?>
        <?php /*
        <a
          href="<?= $button['url'] ?>"
          class="<?= cx([
            'flex-shrink-0 ms-40px -my-8px inline-flex items-center min-h-[62px] px-20px py-8px',
            'text-16px/1_25 font-medium',
            'text-neutral-white bg-neutral-red hover:bg-neutral-red/80',
            'transition-colors',
          ]) ?>"
        ><?= $button['title'] ?></a>
         */ ?>
        <?php get_part('components/button', [
          'class' => 'flex-shrink-0 ms-40px -my-8px',
          'text' => $button['title'],
          'url' => $button['url'],
          'theme' => 'red',
          'size' => 'large',
        ]); ?>
      <?php endif; ?>
    </div>
    <?php if ($text): ?>
      <p class=" <?= cx([
                    'text-16px/1_6 md:text-18px/1_6 mt-24px whitespace-pre-line text-neutral-gray',
                    $vesion === 'large' ? 'max-w-full md:max-w-[70%]' : null,
                  ]) ?>"><?= $props['text'] ?></p>
    <?php endif; ?>

    <?php if ($author || $date) : ?>
      <div class="flex flex-row items-center gap-8px mt-48px">
        <?php if ($date) : ?>
          <p class="text-14px/1 text-neutral"><?= $date; ?></p>
        <?php endif; ?>

        <?php if ($author && $date) : ?>
          <span class="<?= cx([
                          'size-[18.5px] text-neutral-dark/20 relative',
                          "after:contents-[''] after:absolute after:left-1/2 after:top-1/2 after:-translate-y-1/2 after:-translate-x-1/2",
                          'after:w-full after:h-[1px] after:bg-neutral-dark/20 after:-rotate-45',
                        ]) ?>"></span>
        <?php endif; ?>

        <?php if ($author) : ?>
          <p class="text-14px/1 text-neutral"><?= $author; ?></p>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>