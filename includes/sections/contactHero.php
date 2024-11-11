<?php
  $slider = get_field('heroHome');

  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];



//var_dump($props);

?>


<div class="hero-contact-spacer-bg" style="background-image: url('<?php echo isset($props['image']) ? $props['image']['url'] : ''; ?>')"></div>*/*/
<div class="hero-categories">
    <div class="container">
        <div class="hero-contact-container">

            <div class="col-1">
                <?php get_part('layout/breadcrumbs', [
                    'items' => [
                        [
                            'title' => __('Contact us', 'jcc-solutions'),
                            'url' => get_permalink(get_page_by_path('contact-us')),
                        ],

                    ],
                ]); ?>

                <h2 class="header fw-500 fs-56 lh-64 t-white">
                    <?php echo isset($props['header']) ? $props['header'] : ''; ?>
                </h2>

                <div class="hero-contact-text fw-400 fs-18 lh-30 t-white">
                    <?php echo isset($props['text']) ? $props['text'] : ''; ?>
                </div>

                <div class="hero-contact-person">
                    <div>
                        <div class="person-image">
                            <img
                                    src="<?php echo isset($props['contact_person']) ? $props['contact_person']['image']['url'] : ''; ?>"
                                    alt="<?php echo isset($props['contact_person']) ? $props['contact_person']['name'] : ''; ?>"
                            >
                        </div>
                    </div>
                    <div>
                        <div class="fw-700 fs-16 lh-24 t-white">
                            <?php echo isset($props['contact_person']['name']) ? $props['contact_person']['name'] : ''; ?>
                        </div>
                        <div class="fw-400 fs-14 lh-20 mb-16 t-white-72">
                            <?php echo isset($props['contact_person']['position']) ? $props['contact_person']['position'] : ''; ?>
                        </div>
                        <div class="align-bottom">
<!--                            --><?php //include BASE_PATH . 'assets/icons/mail-icon.svg'; ?>

                            <a class="t-white link-white" href="<?php echo isset($heroContactPersonMailUrl) ? $heroContactPersonMailUrl : ''; ?>">
                                <?php echo isset($heroContactPersonMail) ? $heroContactPersonMail : ''; ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="scroll-down">
<!--                    --><?php //include BASE_PATH . 'assets/icons/scroll-down.svg'; ?>
                </div>
            </div>

            <div class="col-2">
                <div class="hero-contact-form-container">
                    <div id="contactHero">
<!--                    --><?php //get_part('components/contactHeroForm', []); ?>
                    <?= do_shortcode('[contact-form-7 id="989e015" title="Contact us Form"]') ?>
                        </div>
                </div>


            </div>




        </div>
    </div>
</div>
