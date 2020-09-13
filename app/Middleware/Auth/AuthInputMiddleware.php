<?php

declare(strict_types=1);

namespace App\Middleware\Auth;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Exception\ForbiddenHttpException;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\ValidationException;
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

    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->blacklist = [1, 2, 3];
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->validation($request);
        return $handler->handle($request);
    }

    protected function validation(ServerRequestInterface $request)
    {
        $validator = $this->validationFactory->make(
            $request->getParsedBody(),
            $this->getRules()
            );
        if ($validator->fails()) {
            $errMsg = $validator->errors()->getMessages();
            array_walk($errMsg, 'var_dump');
        }
    }

    protected function getRules()
    {
        return [
            'id' => 'required|numeric|gt:2'
        ];
    }


}