<?php

  namespace ThemeClasses\Controller;

  trait GenericCaptcha
  {
    static public function checkCaptcha($token)
    {
      $captchaPrivKey = defined('RECAPTCHA_PRIV_KEY') ? RECAPTCHA_PRIV_KEY : '';

      $data = [
        'secret' => $captchaPrivKey,
        'response' => $token,
      ];

      $curlObj = curl_init();
      curl_setopt($curlObj, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
      curl_setopt($curlObj, CURLOPT_POST, true);
      curl_setopt($curlObj, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curlObj, CURLOPT_CONNECTTIMEOUT, 60);
      $response = curl_exec($curlObj);

      if (curl_errno($curlObj)) {
        error_log(curl_error($curlObj));
      }

      return json_decode($response, true)['success'];
    }
  }
