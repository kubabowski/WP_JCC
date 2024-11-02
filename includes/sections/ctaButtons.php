<?php
$rootClass = '';
$rootAttr = '';

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="my-40px md:my-96px <?= $rootClass ?>" <?= $rootAttr ?>>
    <div class="wrapper bg-neutral-dark p-24px md:p-48px text-white">
        <?php if (isset($props['title'])) : ?>
            <h2 class="text-48px/1_2 lg:text-72px/1_2 mb-16px text-center"><?= $props['title'] ?></h2>
        <?php endif; ?>

        <div class="flex flex-col gap-24px [&_p]:text-18px/1_6 [&_a]:text-white text-center">
            <?php if (isset($props['text_1'])) : ?>
                <div class="wysiwyg max-w-[588px] mx-auto"><?= $props['text_1'] ?></div>
            <?php endif; ?>

            <?php if (isset($props['text_1']) and isset($props['text_2'])) : ?>
                <div class="h-px w-full max-w-[682px] bg-gradient-to-r from-white/0 via-white/40 to-white/0 mx-auto"></div>
            <?php endif; ?>

            <?php if (isset($props['text_2'])) : ?>
                <div class="wysiwyg max-w-[588px] mx-auto text-white/60"><?= $props['text_2'] ?></div>
            <?php endif; ?>
        </div>


        <?php if (isset($props['button_file']) or isset($props['button'])) : ?>
            <div class="mt-48px flex justify-center flex-wrap gap-32px">
                <?php if (isset($props['button_file'])) : ?>
                    <?php get_part('components/button', [
                        'title' => $props['button_file']['title'],
                        'target' => $props['button_file']['target'],
                        'url' => $props['button_file']['url'],
                        'theme' => 'dark',
                        'iconBefore' => 'pdf',
                    ]); ?>
                <?php endif; ?>

                <?php if (isset($props['button'])) : ?>
                    <?php get_part('components/button', [
                        'title' => $props['button']['title'],
                        'target' => $props['button']['target'],
                        'url' => $props['button']['url'],
                        'theme' => 'red',
                    ]); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</section>