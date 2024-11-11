<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>


<div class="breadcrumps">
    <nav class="align-center">
        <a
                href="<?= home_url('/') ?>"
                class="fw-400 fs-12 lh-20 uppercase">
            <!--        --><?php //get_icon('home', 'icon'); ?>
            Home
        </a>

        <?php foreach ($props['items'] as $item) : ?>
            <li class="flex items-center ms-6px">
                <?php get_icon('chevron-right', 'icon text-14px/1 me-6px text-neutral-gray'); ?>
                <?php if (isset($item['url'])) : ?>
                    <a
                            href="<?= $item['url'] ?>"
                            class="fw-400 fs-12 lh-20 uppercase"
                    ><?= $item['title'] ?></a>
                <?php else: ?>
                    <span
                            class="fw-400 fs-12 lh-20 uppercase"
                    ><?= $item['title'] ?></span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </nav>
</div>




