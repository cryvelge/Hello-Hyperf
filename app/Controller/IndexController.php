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

use App\Exception\ApiException;
use App\Services\UserService;
use Hyperf\HttpServer\Annotation\{Controller, GetMapping, Middleware};
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Middleware\Auth\AuthInputMiddleware;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Paginator\Paginator;

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
     * @GetMapping(path="middlewareIndex/{id}")
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

    /**
     *
     * @author  shiwen <wshi@suntekcorps.com>
     * @GetMapping(path="exceptionIndex")
     */
    public function exceptionIndex()
    {
        throw new ApiException('hello exception');
    }

    /**
     *
     * @param ResponseInterface $response
     *
     * @return bool|mixed|string
     * @author  shiwen <wshi@suntekcorps.com>
     * @GetMapping(path="cacheIndex")
     */
    public function cacheIndex(ResponseInterface $response)
    {
        return make(UserService::class)->get();
    }

    /**
     * @GetMapping(path="pageIndex")
     * @param RequestInterface $request
     *
     * @return Paginator
     * @author  shiwen <wshi@suntekcorps.com>
     * @date    2020/9/11 16:47
     */
    public function pageIndex(RequestInterface $request)
    {
        $currentPage = (int)$request->input('page', 1);
        $prePage = (int)$request->input('prePage', 2);
        $data = [
            ['id' => 1, 'name' => 'Tom'],
            ['id' => 2, 'name' => 'Sam'],
            ['id' => 3, 'name' => 'Tim'],
            ['id' => 4, 'name' => 'Joe'],
        ];

        return new Paginator($data, $prePage, $currentPage);
    }
}
