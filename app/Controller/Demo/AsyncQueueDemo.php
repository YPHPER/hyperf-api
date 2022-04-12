<?php

declare(strict_types=1);

namespace App\Controller\Demo;

use App\Controller\AbstractController;
use App\Service\QueueService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * Class AsyncQueueDemo
 * @AutoController()
 * @package App\Controller\Demo
 */
class AsyncQueueDemo extends AbstractController
{
    /**
     * @Inject
     * @var QueueService
     */
    protected $service;

    public function index()
    {
        $this->service->push([
            date('Y-m-d H:i:s')
        ]);

        return 'success';
    }

}

