<?php
/**
 * Get template part from path as template
 * @param string $id - template id
 * @param string $fileName - fileName
 * @param array $varsArray - view variables array
 * @param boolean $render - rendering
 * @return string part html if $render === false
 */
function get_template($tplAttr = '', $fileName = null, $props = [], $render = true, $extract = true) {
  $partTemplatePath = INCLUDES . $fileName . '.php';

  if (!file_exists($partTemplatePath)) {
    error_log(sprintf(
      implode('', [
        'Undefined template part `%s`',
        '%smissing file: %s',
        '%serror source: %s'
      ]),
      $fileName,
      PHP_EOL, $partTemplatePath,
      PHP_EOL, __FILE__
    ));

    return;
  }

  ob_start();

  echo '<script type="text/template"' . $tplAttr .'>';
  get_part($fileName, $props, true, $extract);
  echo '</script>';

  $partHtml = ob_get_clean();

  if ($render === false) return $partHtml;
  echo $partHtml;
}
