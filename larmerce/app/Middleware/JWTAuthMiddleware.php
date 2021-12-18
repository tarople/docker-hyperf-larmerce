<?php

namespace App\Middleware;

use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Phper666\JWTAuth\Util\JWTUtil;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Phper666\JWTAuth\JWT;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Context;

class JWTAuthMiddleware implements MiddlewareInterface
{
    
    protected $jwt;

    public function __construct(JWT $jwt)
    {        
        $this->jwt = $jwt;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Throwable
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $isValidToken = true;
        // check token
        $token = JWTUtil::handleToken($request->getHeaderLine('Token'));
        try {

            $this->jwt->checkToken($token);

        } catch (\Throwable $e) {

            $isValidToken = false;

        }    
        
        if ($isValidToken) {
            return $handler->handle($request);
        }    
        
        $response = Context::get(ResponseInterface::class);

        $response->withAddedHeader('content-type', 'application/json; charset=utf-8');        

        $body = json_encode([
            'code' => -1,
            'msg' => 'Token authentication does not match',
            'data' => (object)[]
        ], JSON_UNESCAPED_UNICODE);
        
        return $response->withStatus(200)->withBody(new SwooleStream($body));        
    }
}
