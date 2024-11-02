<?php
define('DEBUG_GET_PART', true);
define('THEME_URL', get_template_directory_uri() . '/');
define('THEME_DIR', get_template_directory() . DIRECTORY_SEPARATOR);
define('INCLUDES', THEME_DIR . 'includes' . DIRECTORY_SEPARATOR);
define('FLEXIBLE', INCLUDES . 'flexible' . DIRECTORY_SEPARATOR);

define('THEME_DOMAIN', 'bud-went');
define('DEFAULT_LOCALE', 'pl_PL');

include_once(__DIR__ . DIRECTORY_SEPARATOR . 'helpers/get_part.php');
include_once(__DIR__ . DIRECTORY_SEPARATOR . 'helpers/get_flexible.php');

include_once(__DIR__ . DIRECTORY_SEPARATOR . 'helpers/rwd_media.php');

define('ICON_PREFIX', 'icon-');
include_once(__DIR__ . DIRECTORY_SEPARATOR . 'helpers/get_icon.php');

// include_once(__DIR__ . DIRECTORY_SEPARATOR . 'helpers/t.php');
include_once(__DIR__ . DIRECTORY_SEPARATOR . 'helpers/cx.php');
