<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use App\Exception\ApiException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ApiExceptionHandler extends AppExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof  ApiException) {
            $data = json_encode([
                'code' => $throwable->getCode(),
                'message' => $throwable->getMessage()
                                ], JSON_UNESCAPED_UNICODE);
            $this->stopPropagation();
            return $response->withStatus(500)->withBody(new SwooleStream($data));
        }
        return  $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
