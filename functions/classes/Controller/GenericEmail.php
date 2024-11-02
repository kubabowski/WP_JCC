<?php

  namespace ThemeClasses\Controller;

  trait GenericEmail
  {
    static public function sendMail($to, $subject, $message, $headers = '', $attachments = [])
    {
      return wp_mail($to, $subject, $message, $headers, $attachments);
    }

    static public function getEmailTemplate($fileName, $varsArray = [])
    {
      $emailTemplatePath = THEME_DIR . 'email-templates/' . $fileName . '.php';
      if (!file_exists($emailTemplatePath)) {
        error_log(sprintf(
          implode('', [
            'Undefined email template `%s`',
            '%smissing file: %s',
            '%serror source: %s'
          ]),
          $fileName,
          PHP_EOL, $emailTemplatePath,
          PHP_EOL, __FILE__
        ));

        return '';
      }

      ob_start();
      extract($varsArray);
      $emailProps = $varsArray;
      include($emailTemplatePath);
      $templateHtml = ob_get_clean();

      return $templateHtml;
    }
  }
