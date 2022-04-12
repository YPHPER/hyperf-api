<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Common\Traits\JsonResponse;
use Hyperf\Di\Annotation\Inject;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ValidationExceptionHandler extends ExceptionHandler
{
    use JsonResponse;

    /**
     * @Inject
     * @var RequestInterface
     */
    private $request;

    /**
     * @param Throwable         $throwable
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        //阻止异常冒泡
        $this->stopPropagation();

        $flag = $this->request->getHeaderLine('x-request-from');


        $validatorError = new SwooleStream(
            json_encode($this->buildErrorFormat($throwable->validator->errors()->first()),JSON_UNESCAPED_UNICODE)
        );

        //web浏览器跨域返回
        if ($flag == 'web') {
            return $response
                ->withBody($validatorError)
                ->withHeader('content-type', 'application/json; charset=utf-8')
                ->withHeader('Access-Control-Allow-Origin', $this->request->getHeaderLine('origin'))
                ->withHeader('Access-Control-Allow-Credentials', 'true')
                ->withHeader('Access-Control-Allow-Headers', 'Keep-Alive,User-Agent,Cache-Control,Content-Type,Authorization,X-Requested-With,X-Request-From,x-request-form');
        }

        return $response
            ->withBody($validatorError)
            ->withHeader('content-type', 'application/json; charset=utf-8');
    }

    /**
     * @param Throwable $throwable
     *
     * @return bool
     */
    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}
