<?php

  namespace ThemeClasses\Controller;

  use ThemeClasses\RegexRules;

  class Form
  {
    use GenericEmail;

    public function __construct()
    {
      add_filter('getFormFields', [$this, 'getFormFieldsByFilter'], 10, 3);

      add_filter('acf/fields/flexible_content/layout_title/name=fields', [$this, 'extendLayoutTitle'], 10, 4);
    }

    public function getFormFieldsByFilter($fields, $formId, $lang = null)
    {
      return static::getFormFields($fields, $formId, $lang);
    }

    static public function getFormFields($fields, $formId, $lang = null)
    {
      // $formId = static::getFormIdByLang($formId, $lang); // not works with REST API
      $fields = get_field('fields', $formId);
      $fields = array_map('ThemeClasses\Controller\Form::mapSingleField', $fields);

      return $fields;
    }

    // static public function getFormIdByLang($formId, $customLang = null)
    // {
    //   $lang = ($customLang != null) ? (
    //     $customLang
    //   ) : (
    //     apply_filters('getCurrentLang', null)
    //   );

    //   return (function_exists('pll_get_post') ? (
    //     pll_get_post($formId, $lang)
    //   ) : $formId);

    //   // return null;
    // }

    static public function mapSingleField($field)
    {
      $field['fieldType'] = $field['acf_fc_layout'];
      unset($field['acf_fc_layout']);

      if (isset($field['validation'])) {
        foreach ($field['validation'] as $ruleKey => $rule) {
          switch ($rule['type']) {

            case 'email':
              if (!(!isset($rule['parameter']) || $rule['parameter'] == '')) continue 2;
              $field['validation'][$ruleKey]['parameter'] = RegexRules::EMAIL;
              continue 2;

            case 'number':
              if (!(!isset($rule['parameter']) || $rule['parameter'] == '')) continue 2;
              $field['validation'][$ruleKey]['parameter'] = RegexRules::NUMBER;
              continue 2;

            default: continue 2;
          }
        }
      }

      return $field;
    }

    static public function sendForm($params)
    {
      if (!isset($params['lang'])) {
        $params['lang'] = apply_filters('getCurrentLang', null);
      }

      $result = static::sendEmailMail($params);

      return [
        'success' => (bool)$result,
        'data' => [
          // 'id' => $memberId,
        ],
      ];
    }

    static public function sendEmailMail($params)
    {
      $emailTemplates = get_field('emails', $params['formId']);

      foreach ($emailTemplates as $emailTemplate) {
        $to = static::fillPlaceholders($emailTemplate['to'], $params);
        $subject = static::fillPlaceholders($emailTemplate['subject'], $params);
        $message = static::getMessage($emailTemplate, $params);
        $headers = static::getHeaders($emailTemplate, $params);
        $attachments = static::getAttachments($emailTemplate, $params);

        $result = static::sendMail($to, $subject, $message, $headers, $attachments);
        if ($result === false) return false;
      }

      return true;
    }

    static public function getHeaders($emailTemplate, $params)
    {
      $headers = [
        'Content-Type: text/html; charset=UTF-8'
      ];

      if ($emailTemplate['headers'] != '') {
        $headers[] = static::fillPlaceholders($emailTemplate['headers'], $params);
      }

      return $headers;
    }

    static public function getMessage($emailTemplate, $params)
    {
      $emailParams = array_merge([
        'subject' => $emailTemplate['subject'],
      ], $params);
      unset($emailParams['formId']);
      // unset($emailParams['lang']);

      $message = '';

      switch ($emailTemplate['messageType']) {
        case 'file':
          $message = static::getEmailTemplate($emailTemplate['templateFile'], $emailParams);
          break;

        case 'custom':
          $message = static::fillPlaceholders($emailTemplate['customHtml'], $emailParams);
          break;

        case 'default': break;
        default: break;
      }

      if ($message === '') $message = static::getEmailTemplate('default', $emailParams);

      return $message;
    }

    static public function getAttachments($emailTemplate, $params)
    {
      return [];
    }

    static public function fillPlaceholders($string, $params)
    {
      $placeholders = [];
      $values = [];

      foreach ($params as $paramKey => $param) {
        $placeholders[] = '[' . $paramKey . ']';
        $values[] = $param;
      }

      return str_replace($placeholders, $values, $string);
    }

    public function extendLayoutTitle($title, $field, $layout, $i)
    {
      $newTitle = $title;

      $name = get_sub_field('name');
      if ($name != '') $newTitle .= ' : ' . $name;

      $required = get_sub_field('required');
      if ($required == 1) $newTitle .= ' *';

      return $newTitle;
    }
  }
