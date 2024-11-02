<?php
/**
 * Get flexible content sections from ACF
 * @param string $fieldName - flexible content field name
 * @param boolean $render - rendering
 * @return string flexible section html if $render == false
 */
function get_flexible($fieldName = 'sections', $render = true) {
  $allSectionsHtml = '';

  $sections = get_field($fieldName);
  if ($sections) {
    foreach ($sections as $sectionIndex => $section) {
      if (isset($section['sectionDisabled']) && $section['sectionDisabled']) continue;

      $section['class'] = 'sections__item';
      if (isset($section['sectionMarginTop']) && $section['sectionMarginTop']) {
        $section['class'] .= ' sections__item--marginTop';
      }
      if (isset($section['sectionMarginBottom']) && $section['sectionMarginBottom']) {
        $section['class'] .= ' sections__item--marginBottom';
      }

      // $sectionTemplatePath = __DIR__ . '/' . $section['acf_fc_layout'] . '.php';
      $sectionTemplatePath = FLEXIBLE . $section['acf_fc_layout'] . '.php';

      if (!file_exists($sectionTemplatePath)) {
        global $post;
        error_log(sprintf(
          implode('', [
            'Undefined section template for layout `%s` in post id `%s`',
            '%smissing file: %s',
            '%serror source: %s'
          ]),
          $section['acf_fc_layout'], $post->ID,
          PHP_EOL, $sectionTemplatePath,
          PHP_EOL, __FILE__
        ));

        continue;
      }

      ob_start();
      include($sectionTemplatePath);
      $sectionHtml = ob_get_clean();

      $allSectionsHtml .= $sectionHtml;
    }
  }

  if ($render == false) return $allSectionsHtml;
  echo $allSectionsHtml;
}
