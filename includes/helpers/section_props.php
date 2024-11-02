<?php
/**
 * Get standard section props
 * @param string $name - section name
 * @param array $props - section props
 * @param string &$rootClass - root element classes
 * @param string &$rootAttr - root element attributes
 * @return void
 */
function section_props($name, $props, &$rootClass, &$rootAttr) {
  if (isset($props['layout'])) $rootClass .= ' ' . $name . '--' . $props['layout'];
  if (isset($props['theme'])) $rootClass .= ' ' . $name . '--' . $props['theme'];

  if (isset($props['noPaddingTop']) && $props['noPaddingTop'])
    $rootClass .= ' ' . $name . '--noPaddingTop';

  if (isset($props['noPaddingBottom']) && $props['noPaddingBottom'])
    $rootClass .= ' ' . $name . '--noPaddingBottom';

  if (isset($props['smallPaddingTop']) && $props['smallPaddingTop'])
    $rootClass .= ' ' . $name . '--smallPaddingTop';

  if (isset($props['smallPaddingBottom']) && $props['smallPaddingBottom'])
    $rootClass .= ' ' . $name . '--smallPaddingBottom';

  if (isset($props['largePaddingTop']) && $props['largePaddingTop'])
    $rootClass .= ' ' . $name . '--largePaddingTop';

  if (isset($props['largePaddingBottom']) && $props['largePaddingBottom'])
    $rootClass .= ' ' . $name . '--largePaddingBottom';

  if (isset($props['fixNoPadding']) && $props['fixNoPadding'])
    $rootClass .= ' ' . $name . '--fixNoPadding';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
}
