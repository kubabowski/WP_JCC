<?php
get_header();
$postId = get_the_ID();

$pageTitle = get_the_title() ?? 'No title';
$pageDescription = get_field('description') ?? '';
$date = get_the_date('d.m.Y');

$authorId = get_post_field('post_author', $postId);
$userInfo = get_userdata($authorId);
$authorFirstName = get_user_meta($authorId, 'first_name', true);
$authorLastName = get_user_meta($authorId, 'last_name', true);

if (!empty($authorFirstName) || !empty($authorLastName)) {
  $userFullName = $authorFirstName . ' ' . $authorLastName;
} else {
  $userFullName = $userInfo->display_name;
}

?>
<main id="main" class="flex flex-col flex-grow mt-header-height">
  <?php

  get_part('layout/breadcrumbs', [
    'items' => [
      [
        'title' => __('Baza wiedzy', 'bud-went'),
        'url' => get_post_type_archive_link('knowledge'),
      ],
      [
        'title' => $pageTitle,
      ],
    ],
  ]);

  get_part('layout/pageHead', [
    'title' => $pageTitle,
    'text' => $pageDescription,
    'size' => 'default',
    'version' => 'large',
    'author' => $userFullName,
    'date' => $date,
  ]);

  get_flexible();

  ?>
  <div class="wrapper lg:contents">

    <div class="mb-72px w-full max-w-[892px] mx-auto">
      <hr class="w-full border-neutral-dark/15">
      <div class="flex flex-row items-center justify-between gap-12px mt-32px">

        <p class="text-16px/1_2 text-neutral-dark">
          <?= $userFullName; ?>
        </p>

        <div class="flex flex-wrap flex-row gap-[2px]">

          <?php
          $url = get_the_permalink();
          $socials = [
            [
              'title' => 'linkedin',
              'url' => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $url,
              'icon' => 'linkedin',
            ],
            [
              'title' => 'twitter',
              'url' => 'https://twitter.com/intent/tweet?text=' . $url,
              'icon' => 'twitter',
            ],
            [
              'title' => 'facebook',
              'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . $url,
              'icon' => 'facebook',
            ],

          ]
          ?>
          <?php foreach ($socials as $social) : ?>
            <a
              href="<?= $social['url'] ?>"
              target="'_blank'"
              class="<?= cx([
                        'flex items-center justify-center',
                        'size-56px text-20px/1 text-neutral-gray',
                        'bg-neutral-dark/5 hover:bg-neutral-dark/15',
                        'transition-colors',
                      ]) ?>"><?php get_icon($social['icon'], 'icon'); ?></a>
          <?php endforeach; ?>

        </div>

      </div>
    </div>
  </div>

  <?php
  get_part('sections/latestPosts', [
    'title' => __('Podobne wpisy', 'bud-went'),
  ]);
  ?>

</main>
<?php
get_footer();
