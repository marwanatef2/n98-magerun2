<?php

if (!class_exists('Robusta\MagerunBootstrap')) {
    require_once __DIR__ . '/Robusta/MagerunBootstrap.php';
}

try {
    if (version_compare(PHP_VERSION, '7.2.0', '<')) {
        throw new \ErrorException('PHP Version is lower than 7.2.0. Please upgrade your runtime.');
    }
    return Robusta\MagerunBootstrap::createApplication();
} catch (Exception $e) {
    printf("%s: %s\n", get_class($e), $e->getMessage());
    if (array_intersect(['-vvv', '-vv', '-v', '--verbose'], $argv)) {
        printf("%s\n", $e->getTraceAsString());
    }
    exit(1);
}
