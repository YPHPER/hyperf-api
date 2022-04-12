<?php

declare(strict_types=1);

namespace App\Middleware;

use Common\Traits\JsonResponse;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Hyperf\Utils\Context;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JwtMiddleware implements MiddlewareInterface
{
    use JsonResponse;

    /**
     * @var array 半检查是否登录的路由
     */
    protected $notForceCheckRoute = [];

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var HttpResponse;
     */
    protected $response;


    public function __construct(ContainerInterface $container, HttpResponse $response)
    {
        $this->container = $container;
        $this->response  = $response;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getHeaderLine('authorization');
        $token = trim(str_ireplace('Bearer', '', $token));

        if(in_array($request->getUri()->getPath(), $this->notForceCheckRoute)){
            return $token ? $this->authCheck($token, $request, $handler) : $handler->handle($request);
        }

        return $this->authCheck($token, $request, $handler);
    }

    /**
     * @param string $token
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    protected function authCheck($token, $request, $handler)
    {
        if(empty($token) || !is_string($token) || strlen($token)<120){
            return $this->response->json($this->buildErrorFormat("缺失请求的凭证"))->withStatus(401);
        }

        # https://github.com/lcobucci/jwt/blob/3.3/README.md
        $token = (new Parser())->parse($token);

        //验证签名
        if(!$token->verify(new Sha256(),env('JWT_SECRET'))){
            return $this->response->json($this->buildErrorFormat("非法的凭证"))->withStatus(401);
        }

        if($token->isExpired()){
            return $this->response->json($this->buildErrorFormat("凭证已经过期了，请重新登录"))->withStatus(401);
        }

        $userId = $token->getClaim('sub');
        if($userId <= 0){
            return $this->response->json($this->buildErrorFormat("错误的用户编号凭证"))->withStatus(401);
        }

        $request = $request->withAttribute('userId', $token->getClaim('sub'));
        Context::set(ServerRequestInterface::class, $request);

        return $handler->handle($request);
    }


}