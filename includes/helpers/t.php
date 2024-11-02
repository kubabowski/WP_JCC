<?php
/**
 * Get translation
 * @param string $text - default english text
 * @param string $rtlText - arabic text
 */
function t($text = '', $rtlText = '') {
  return (IS_RTL && !empty($rtlText)) ? $rtlText : $text;
}
