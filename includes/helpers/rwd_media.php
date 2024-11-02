<?php
// keep in sync with html\src\scss\settings\breakpoints.scss

$breakpoints = [
  // 'phone'        => '(min-width:  360px)',
  // 'large-phone'  => '(min-width:  480px)',
  // 'small-tablet' => '(min-width:  600px)',
  // 'tablet'       => '(min-width:  768px)',
  // 'large-tablet' => '(min-width: 1024px)',
  // 'laptop'       => '(min-width: 1280px)',
  // 'large-laptop' => '(min-width: 1366px)',
  // 'ultra'        => '(min-width: 1600px)',
  '2xs' => '(min-width: 360px)',
  'xs' =>  '(min-width: 480px)',
  'sm' =>  '(min-width: 640px)',
  'md' =>  '(min-width: 768px)',
  'lg' =>  '(min-width: 1024px)',
  'xl' =>  '(min-width: 1280px)',
  '2xl' => '(min-width: 1536px)',
];

/**
 * Get media query from breakpoint name
 * @param string $breakpoint - breakpoint name or custom media query
 * @return string media query for breakpoint
 */
function rwd_media($breakpoint = '') {
  global $breakpoints;
  return $breakpoints[$breakpoint] ?? $breakpoint;
}

$breakpointsMax = [
  // 'phone'        => '(min-width:  360px)',
  // 'large-phone'  => '(min-width:  480px)',
  // 'small-tablet' => '(min-width:  600px)',
  // 'tablet'       => '(min-width:  768px)',
  // 'large-tablet' => '(min-width: 1024px)',
  // 'laptop'       => '(min-width: 1280px)',
  // 'large-laptop' => '(min-width: 1366px)',
  // 'ultra'        => '(min-width: 1600px)',
  '2xs' => '(max-width: 359.9px)',
  'xs' =>  '(max-width: 479.9px)',
  'sm' =>  '(max-width: 639.9px)',
  'md' =>  '(max-width: 767.9px)',
  'lg' =>  '(max-width: 1023.9px)',
  'xl' =>  '(max-width: 1279.9px)',
  '2xl' => '(max-width: 1535.9px)',
];

/**
 * Get media query from breakpoint name
 * @param string $breakpoint - breakpoint name or custom media query
 * @return string media query for breakpoint
 */
function rwd_media_max($breakpoint = '') {
  global $breakpoints;
  return $breakpoints[$breakpoint] ?? $breakpoint;
}
