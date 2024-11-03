<?php
  get_header();

  /*
  $formsOptions = apply_filters('getOptions', [], 'forms');

  $staticFormProps = [
    'textButton' => [
      'headline' => 'Nie udało Ci się znaleźć potrzebnych informacji lub jesteś zainteresowany współpracą z nami?',
      'text' => 'Napisz do nas! Odezwiemy się najszybciej jak to możliwe.',
    ],
    'formId' => $formsOptions['contactFormId'],
  ];
  */

  // $homeUrl = home_url('/');
?>
<main id="main" class="">
  <?php
    get_part('sections/heroSlider');
    get_flexible();
    // get_part('sections/textFormRow', $staticFormProps);
    get_part('sections/newsletter');
  ?>
</main>
<?php
  get_footer();
