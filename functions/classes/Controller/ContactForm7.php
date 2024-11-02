<?php

  namespace ThemeClasses\Controller;

  class ContactForm7
  {

    public function __construct()
    {
      // add_filter('wpcf7_autop_or_not', '__return_false'); // does not work
    }

    static public function parseFormHtml($html)
    {
      // used define('WPCF7_AUTOP', false); in wp-config

      /*
      // remove empty <p> (without attributes)
      $html = preg_replace('/<p>((?:.|\s)*?)<\/p>/', "$1", $html);
      // remove <br>
      $html = preg_replace('/<br.*?>/', "", $html);
      // replace <p> by <div>
      $html = preg_replace('/(<\/?)p(.*?>)/', "$1div$2", $html);
      */
      /*
      // replace <span> by <div>
      $html = preg_replace('/(<)span(.*?class="wpcf7-form-control-wrap.*?>.*?<\/)span(>)/', "$1div$2div$3", $html);
      */

      return $html;
    }
  }
