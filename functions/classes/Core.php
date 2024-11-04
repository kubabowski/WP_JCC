<?php

  namespace ThemeClasses;

  class Core
  {
    public function __construct()
    {
      new WordPressSecurity([
        'wpc_path_allow'      => [],
        'login_error_message' => '%sERROR%s: Login details are incorrect. Another failed attempts will lead to blocking the website.',
        'login_disable_info'  => 'The website has been blocked due to exceeded limit of failed login attempts. Contact us if the problem persists.',
        'login_url'           => 'my-login',
      ]);

      /* --- Settings --- */
      new Settings\Admin();
      new Settings\Langs();
      new Settings\Menu();
      new Settings\Theme();
      new Settings\Media();
      new Settings\Acf();
      new Settings\Flexible();

      /* --- PostType --- */
      new PostType\Product();
      new PostType\Service(); 
      new PostType\CaseStudy();
      new PostType\Insight();
      // new PostType\Knowledge();
      // new PostType\Training();
      // new PostType\News();
      // new PostType\Form();
      // new PostType\OptionsPage();

      /* --- Taxonomy --- */
      new Taxonomy\ProductCategory();
      // new Taxonomy\ProductManufacturer();
      new Taxonomy\Company();
      new Taxonomy\Topic();
      new Taxonomy\ServiceCategory();
      new Taxonomy\CaseStudyCategory();
      // new Taxonomy\OptionsGropu();



      /* --- Controller --- */
      new Controller\Product();
      new Controller\Knowledge();
      new Controller\Service();
      // new Controller\News();
      // new Controller\Form();
      // new Controller\OptionsPage();

      /* --- Api --- */
      new Api\CalendarAjax();
      // new Api\Form();
    }
  }

