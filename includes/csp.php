<?php
$cspRules = "";
$cspRules .= "default-src 'self';";
$cspRules .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' www.google.com www.gstatic.com www.google-analytics.com www.googletagmanager.com;";
$cspRules .= "style-src 'self' 'unsafe-inline';";
$cspRules .= "img-src 'self' data: www.google-analytics.com;";
$cspRules .= "font-src 'self' data:;"; // data: for swiper base64 icons font
$cspRules .= "frame-src *;";
$cspRules .= "connect-src 'self' www.google-analytics.com;";
header("Content-Security-Policy: " . $cspRules);

$permRules = "";
$permRules .= "geolocation=(self)";
$permRules .= ", ";
$permRules .= "microphone=()";
$permRules .= ", ";
$permRules .= "camera=()";
$permRules .= ", ";
$permRules .= "accelerometer=()";
$permRules .= ", ";
$permRules .= "gyroscope=()";
header("Permissions-Policy: " . $permRules);
