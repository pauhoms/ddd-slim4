<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api/v1', function (RouteCollectorProxy $group) {
        $group->get('/health-check', 'App\Controllers\HealthCheck');
    });
};
