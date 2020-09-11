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
namespace App\Controller;

use Hyperf\HttpServer\Annotation\{
    Controller,
    GetMapping
};
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @Controller()
 */
class IndexController extends AbstractController
{
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }

    /**
     * @GetMapping(path="injectIndex")
     * path 是该路由的方法名
     */
    public function injectIndex()
    {
        return 'hello inject';
    }

    public function routerIndex(RequestInterface $request)
    {
        return 'hello router' . $request->route('id');
    }
}
