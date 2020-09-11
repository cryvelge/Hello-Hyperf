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

use Hyperf\HttpServer\Annotation\{Controller, GetMapping, Middleware};
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Middleware\Auth\AuthInputMiddleware;
use Hyperf\HttpServer\Contract\ResponseInterface;

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
     * path 是该路由的方法名,必须用双引号
     */
    public function injectIndex()
    {
        return 'hello inject';
    }

    public function routerIndex(RequestInterface $request)
    {
        return 'hello router' . $request->route('id');
    }

    /**
     * @GetMapping(path="middlewareIndex")
     * @Middleware(AuthInputMiddleware::class)
     */
    public function middlewareIndex(RequestInterface $request)
    {
        return 'hello middleware';
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     * @GetMapping(path="returnIndex")
     */
    public function returnIndex(RequestInterface $request, ResponseInterface $response)
    {
        return $response->json(['code' => 200, 'msg' => 'ok!']);
    }
}
