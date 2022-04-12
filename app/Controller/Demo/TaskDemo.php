<?php

declare(strict_types=1);

namespace App\Controller\Demo;


use App\Controller\AbstractController;
use App\Task\AnnotationTask;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Coroutine;

/**
 * Class TaskDemo
 * @AutoController()
 * @package App\Controller\Demo
 */
class TaskDemo extends AbstractController
{

    public function index()
    {
        $container = ApplicationContext::getContainer();
        $task = $container->get(AnnotationTask::class);
        return $task->handle(Coroutine::id());
    }

}

