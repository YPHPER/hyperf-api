<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Utils\Context;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;


class CorsMiddleware implements MiddlewareInterface
{
    /**
     * @var array 允许的域名
     */
    protected $allowOrigin = [];

    /**
     * @var array 配置不需要跨域的callback
     */
    protected $callbackUrl = [];

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
        $this->allowOrigin = env('APP_DEBUG') ? [
            'http://192.168.0.43:8081',
            'http://192.168.0.43:8080',
            'http://localhost:8080',
            'http://localhost:8089',
            'http://192.168.0.60:8089',
            'http://192.168.0.86:8080',
            'http://192.168.0.86:8089',
            'http://192.168.0.43:8089',
            'http://192.168.0.60:8089'
        ] :[
            'https://test.timedifferent.com',
            'https://m.timedifferent.com',
        ];
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        //跳过回调的检查
        if(in_array($request->getUri()->getPath(),$this->callbackUrl)){
            return $handler->handle($request);
        }

        $response = Context::get(ResponseInterface::class);
        $flag = $request->getHeaderLine('x-request-from');

        switch($flag){
            case 'wx_mini':
            case 'app':
            case  'XMLHttpRequest':
                return $handler->handle($request);

            case 'web':
            default:
                $origin = $request->getHeaderLine('origin');

                if(env('APP_DEBUG',false)){
                    $origin = '*';
                }else{
                    if(!in_array($origin, $this->allowOrigin)){
                        return $response;
                    }
                }

                if($request->getMethod() == 'OPTIONS'){
                    $response = $this->setAllowOrigin($response,$origin);
                    Context::set(ResponseInterface::class, $response);
                    return $response;
                }

                return $this->setAllowOrigin($handler->handle($request),$origin);
                break;
        }

    }


    /**
     * @param $handle
     * @param $origin
     *
     * @return mixed
     */
    protected function setAllowOrigin($handle, $origin)
    {
        return $handle
            ->withHeader('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Max-Age', '86400')
            ->withHeader('Access-Control-Allow-Headers', 'Origin, Access-Control-Request-Headers, SERVER_NAME, Access-Control-Allow-Headers, cache-control, Authorization, Access-Token, Content-Type, Accept, Connection, User-Agent, Cookie,X-Requested-With,X-Request-From,x-request-form,request-platform');
    }
}