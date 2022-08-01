#!/usr/bin/env php
<?php

Phar::mapPhar('robusta-magerun2.phar');

$application = require 'phar://robusta-magerun2.phar/src/bootstrap.php';
$application->setPharMode(true);
$application->run();

__HALT_COMPILER();
