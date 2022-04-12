<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\AppException;
use Common\Utils\DingDing\DingDingRobot;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Event\Annotation\Listener;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;
use Psr\Log\LoggerInterface;

/**
 * @Listener
 */
class AppExceptionListener implements ListenerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var StdoutLoggerInterface
     */
    private $stdoutLogger;

    /**
     * @var RequestInterface
     */
    private $request;


    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->logger       = $container->get(LoggerFactory::class)->get('app', 'exception');
        $this->stdoutLogger = $container->get(StdoutLoggerInterface::class);
        $this->request      = $container->get(RequestInterface::class);
    }

    public function listen(): array
    {
        return [
            AppException::class,
        ];
    }

    /**
     * @param AppException $event
     */
    public function process(object $event)
    {
        //根据不同环境 进行不同异常处理
        //1 local 直接输出
        //2 develop 记录到日志文件
        //3 production 记录到日志 并钉钉提醒

        $env = env('APP_ENV', '');

        switch ($env) {

            case 'develop':
            case 'production':
                $this->logger->error(sprintf('%s[%s] in %s', $event->exception->getMessage(),
                    $event->exception->getLine(), $event->exception->getFile()), $event->data);
                $this->logger->error($event->exception->getTraceAsString());

                if ($env == 'production') {
                    $this->sendExceptionToDingDing($event->exception);
                }

                break;
            case 'local':
            default:
                $this->stdoutLogger->error(sprintf('%s[%s] in %s', $event->exception->getMessage(),
                    $event->exception->getLine(), $event->exception->getFile()), $event->data);
                $this->stdoutLogger->error($event->exception->getTraceAsString());
                break;
        }
    }

    /**
     * @param \Exception|\Throwable $e
     */
    private function sendExceptionToDingDing($e)
    {
        $robot = new DingDingRobot(
            'https://oapi.dingtalk.com/robot/send?access_token=xxxxxx'
        );

        $url          = $this->request->getRequestUri();
        $method       = strtoupper($this->request->getMethod());
        $requestParam = json_encode([
            'get'  => $this->request->getQueryParams(),
            'post' => $this->request->getParsedBody(),
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $robot
            ->setMarkdownType()
            ->setContent([
                'title' => '[捂脸哭][捂脸哭][捂脸哭]业务异常报警',
                'text' => <<<EOF
### [捂脸哭][捂脸哭][捂脸哭]业务异常报警

### 路由:
```
{$url}
```

### 请求方法:
```
{$method}
```

### 请求参数
```
{$requestParam}
```

### 异常信息
```
{$e->getMessage()}
```

### 异常行号
```
{$e->getLine()}
```

### 异常文件
```
{$e->getFile()}
```

### 异常堆栈
```
{$e->getTraceAsString()}
```
EOF
            ])
            ->send();
    }
}
