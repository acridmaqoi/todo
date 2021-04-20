<?php

ob_start();

if(!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . (PHP_OS == 'Linux' ? ' ' : '/') . 'config/config.php';
require_once __DIR__ . '/defines.php';

