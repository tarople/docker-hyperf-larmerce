<?php

namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ValidateExceptionHandle extends ExceptionHandler
{

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();

        /** @var \Hyperf\Validation\ValidationException $throwable */        
            
        $response = $response->withAddedHeader('content-type', 'application/json; charset=utf-8');        

        $body = json_encode([
            'code' => 0,
            'msg' => $throwable->validator->errors()->first(),
            'data' => (object)[]
        ], JSON_UNESCAPED_UNICODE);
        
        return $response->withStatus(200)->withBody(new SwooleStream($body));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}