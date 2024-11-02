<?php
$buildPartCounter;

/**
 * Get template part from path
 * @param string $fileName - file name
 * @param array $varsArray - view variables array
 * @param boolean $render - rendering
 * @param boolean $extract - extract varsArray
 * @return string part html if $render === false
 */
function get_part($fileName, $varsArray = [], $render = true, $extract = false) {
  $debug = defined('DEBUG_GET_PART') ? DEBUG_GET_PART : false;
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
  if ($extract) extract($varsArray);
  $props = $varsArray;
  if ($debug) echo PHP_EOL . '<!-- begin ' . $fileName . ' -->' . PHP_EOL;
  include($partTemplatePath);
  if ($debug) echo PHP_EOL . '<!-- end ' . $fileName . ' -->' . PHP_EOL;
  $partHtml = ob_get_clean();

  if (isset($_GET['build-pattern']) && str_contains($fileName, $_GET['build-pattern'])) {
    global $buildPartCounter;
    $buildPartCounter++;

    $buildPath = $_GET['build-path'];
    $buildSuffix = $_GET['build-suffix'];
    $fileSlug = str_replace('/', '_', $fileName);
    $buildPartPath = PROJECT_ROOT . $buildPath . '_' . $buildPartCounter . '_' . $fileSlug . $buildSuffix;

    // echo $buildPartPath;
    file_put_contents($buildPartPath, $partHtml);
  }

  if ($render === false) return $partHtml;
  echo $partHtml;
}
