<?php
/**
 * Get svg icon from global icons set
 * @param string $iconName - icon name
 * @param string $iconClass - icon class name (default: icon)
 * @param string $iconAttr - icon attributes
 * @param boolean $render - rendering'
 * @return string part html if $render === false
 */
function get_icon($iconName, $iconClass = 'icon', $iconAttr = '', $render = true) {
  ob_start();
  ?>
  <svg
    class="<?= $iconClass ?>"<?= $iconAttr ?>
  ><use xlink:href="#<?= ICON_PREFIX . $iconName ?>"></use></svg>
  <?php
  $iconHtml = ob_get_clean();

  if ($render === false) return $iconHtml;
  echo $iconHtml;
}
