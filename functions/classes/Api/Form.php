<?php

  namespace ThemeClasses\Api;

  use ThemeClasses\RegexRules;
  use ThemeClasses\Controller\Form as FormController;

  class Form extends \WP_REST_Controller {

    use GenericApi;

    public function __construct() {
      $this->version = '1';
      $this->namespace = 'api/v' . $this->version;
      $this->base = '/form';

      add_action('rest_api_init', [$this, 'registerRoutes']);
      add_filter('getApiFormUrl', [$this, 'getApiFormUrl'], 10, 2);
    }

    public function getApiFormUrl($url, $formId) {
      return WP_SITEURL . '/wp-json/' . $this->namespace . $this->base . '/' . $formId;
    }

    /**
      * Register the routes for the objects of the controller.
      */
    public function registerRoutes() {

      $sharedRouteArgs = [
        'lang' => [
          'description' => 'Language',
          'required' => false,
          // 'default' => 'en',
          'validate_callback' => function($value, $request, $param) {
            return (preg_match(RegexRules::LANG, $value) > 0);
          },
        ],
      ];

      $forms = get_posts([
        'post_type' => 'form',
        'post_status' => 'publish',
        'posts_per_page' => -1,
      ]);

      foreach ($forms as $form) {
        $formId = $form->ID;
        // $formFields = apply_filters('getFormFields', [], $formId);
        $formFields = FormController::getFormFields([], $formId);

        $routeArgs = [
          'formId' => [
            'description' => 'Form id',
            'default' => $formId,
          ],
        ];

        foreach ($formFields as $field) {
          if (!isset($field['name'])) continue;

          $fieldArgs = [];
          $fieldArgs['description'] = (isset($field['label'])) ? $field['label'] : $field['fieldType'] . ':' . $field['name'];
          $fieldArgs['required'] = (isset($field['required']) && $field['required'] == 1);
          if (isset($field['default'])) $fieldArgs['default'] = $field['default'];

          if (isset($field['validation'])) {
            $fieldArgs['validate_callback'] = function($value, $request, $param) use ($field) {
              foreach ($field['validation'] as $rule) {
                switch ($rule['type']) {

                  case 'regex':
                    if (!isset($rule['parameter']) || $rule['parameter'] == '') continue 2;
                    if (preg_match($rule['parameter'], $value) <= 0) return false;
                    continue 2;

                  case 'min-length':
                    if (!isset($rule['parameter']) || $rule['parameter'] == '') continue 2;
                    if (strlen($value) < $rule['parameter']) return false;
                    continue 2;

                  case 'max-length':
                    if (!isset($rule['parameter']) || $rule['parameter'] == '') continue 2;
                    if (strlen($value) > $rule['parameter']) return false;
                    continue 2;

                  case 'email':
                    if (!isset($rule['parameter']) || $rule['parameter'] == '') continue 2;
                    if (preg_match($rule['parameter'], $value) <= 0) return false;
                    // if (preg_match(RegexRules::EMAIL, $value) <= 0) return false;
                    continue 2;

                  case 'number':
                    if (!isset($rule['parameter']) || $rule['parameter'] == '') continue 2;
                    if (preg_match($rule['parameter'], $value) <= 0) return false;
                    // if (preg_match(RegexRules::NUMBER, $value) <= 0) return false;
                    continue 2;

                  default: continue 2;
                }
              }
              return true;
            };
          }

          // if (isset($field['fileValidation']) {} // maybe soon

          $routeArgs[$field['name']] = $fieldArgs;
        }

        register_rest_route($this->namespace, $this->base . '/' . $formId, [
          [
            'methods' => \WP_REST_Server::CREATABLE,
            'callback' => [$this, 'sendForm'],
            // 'permission_callback' => function($request) { return true },
            'args' => array_merge($sharedRouteArgs, $routeArgs),
            'show_in_index' => false,
          ],
        ]);
      }
    }

    /**
      * Send contact form
      *
      * @param WP_REST_Request $request Full data about the request.
      * @return WP_Error|WP_REST_Response
      */
    public function sendForm($request) {
      $params = $this->getRequestParams($request);

      $data = FormController::sendForm($params);
      if (is_array($data)) {
        if ($data['success']) {
          return new \WP_REST_Response($data, 200);
        }
      }

      return new \WP_Error('cant-send-form', __('Can\'t send form', 'center3'), ['status' => 500]);
    }
  }
