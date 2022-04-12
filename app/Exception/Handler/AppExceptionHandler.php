<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use App\Event\AppException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param Throwable         $throwable
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->eventDispatcher->dispatch(
            new AppException($throwable,[])
        );

        return $response->withStatus(500)->withBody(new SwooleStream('Internal Server Error.'));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
