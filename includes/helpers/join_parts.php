<?php
/**
 * Join multiple html parts into one part
 * @param array $partsArr - array of parts
 * @param boolean $render - rendering
 * @return string parts html if $render === false
 */
function join_parts($partsArr = [], $render = true) {
  ob_start();
  foreach ($partsArr as $partHtml) {
    echo $partHtml;
  }
  $partHtml = ob_get_clean();

  if ($render === false) return $partHtml;
  echo $partHtml;
}
