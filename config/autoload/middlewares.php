<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Hyperf\Validation\Middleware\ValidationMiddleware;

return [
    'http' => [
        //这里是全局中间件
//        \App\Middleware\Auth\AuthInputMiddleware::class,
        ValidationMiddleware::class
    ],
];
