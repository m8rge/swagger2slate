#!/usr/bin/env php
<?php

if (PHP_VERSION_ID < 70200) {
    die("Php minimum version is 7.2\n");
}

if (class_exists('Phar')) {
    Phar::mapPhar('default.phar');
    /** @noinspection PhpIncludeInspection */
    require 'phar://' . __FILE__ . '/index.php';
}
__HALT_COMPILER(); ?>
