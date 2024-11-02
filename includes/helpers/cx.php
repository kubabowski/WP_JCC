<?php
/**
 * Get class names string
 * @param array $classNames - array of classnames
 * @return string class names string
 */
function cx($classNames) {
  return implode(' ', array_filter($classNames, function($className) {
    if ($className === null || $className === false || $className === '') return false;
    return true;
  }));
}
