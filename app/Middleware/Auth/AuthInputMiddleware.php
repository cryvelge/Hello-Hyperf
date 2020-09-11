<?php

declare(strict_types=1);

namespace App\Middleware\Auth;

use Hyperf\HttpMessage\Exception\ForbiddenHttpException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthInputMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $blacklist = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->blacklist = [1, 2, 3];
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $input = $request->getQueryParams();
//        var_dump($input);
        if (!empty($input) && in_array($input, $this->blacklist)) {
            throw new ForbiddenHttpException('您已经被拉黑');
        }
        return $handler->handle($request);
    }
}