<?php
    // display errors (when needed)
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // define path constants
    define("PUBLIC_HTML_PATH", dirname(__FILE__));
    define("PHP_PATH", PUBLIC_HTML_PATH . "/php");
    define("LAYOUTS_PATH", PHP_PATH . "/layouts");

    // include all PHP helper functions
    require_once(PHP_PATH . "/helpers.php");
?>