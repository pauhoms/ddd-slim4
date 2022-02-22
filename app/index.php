<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/bootstrap.php';

$cors = require __DIR__ . '/configuration/cors.php';
$cors();

$app->run();
