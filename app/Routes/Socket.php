<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;

Router::addServer('socket', function () {
    Router::get('/socket', 'App\Controller\WebSocketController');
});