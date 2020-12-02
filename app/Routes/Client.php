<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;
use App\Controller\ClientController;

Router::post('/client', ClientController::class);