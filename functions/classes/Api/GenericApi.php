<?php

  namespace ThemeClasses\Api;

  use ThemeClasses\Model\Member as MemberModel;

  trait GenericApi {

    /**
      * Set locale
      *
      * @param Array $params request params
      * @param String $textdomain
      */
    public function setLocale($params, $textdomain = 'center3') {
      // $locale = (isset($params['lang']) && $params['lang'] == 'ar') ? 'ar' : 'en_US';
      $locale = 'en_US';
      if (isset($params['lang'])) {
        switch ($params['lang']) {
          // case 'en': $locale = 'en_US';
          case 'pl': $locale = 'pl_PL';
          // case 'ar': $locale = 'ar';
          default: break;
        }
      }

      global $l10n;

      $this->resetLocale();

      if (isset($l10n[$textdomain])) {
        $this->localeBackup = $l10n[$textdomain];
      }

      load_textdomain($textdomain, apply_filters('getMoFilePath', $locale));
    }

    /**
      * Reset locale
      *
      * @param String $textdomain
      */
    public function resetLocale($textdomain = 'center3') {
      global $l10n;

      if (isset($this->localeBackup)) {
        $l10n[$textdomain] = $this->localeBackup;
        unset($this->localeBackup);
      }
    }

    /**
      * Get and prepare request params
      *
      * @param WP_REST_Request $request Request object
      * @return WP_Error|object $params
      */
    protected function getRequestParams($request) {
      return $request->get_params();
    }

    // /**
    //   * Get and prepare request headers
    //   *
    //   * @param WP_REST_Request $request Request object
    //   * @return WP_Error|object $headers
    //   */
    // protected function getRequestHeaders($request) {
    //   return $request->get_headers();
    // }
  }