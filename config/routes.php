<?php
use Cake\Routing\Router;

Router::plugin('Cms', function ($routes) {
    $routes->fallbacks('DashedRoute');
});
