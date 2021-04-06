<?php

session_start();

// facebook defines
define('FB_GRAPH_VERSION', 'v10.0');
define('FB_GRAPH_DOMAIN', 'http://graph.facebook.com/');
define('FB_APP_STATE', 'eciphp');

include_once __DIR__ . (PHP_OS == 'Linux' ? ' ' : '/') . 'config/config.php';

include_once __DIR__ . '/lib/Facebook/facebook_api.php';