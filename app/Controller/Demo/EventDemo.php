<?php

declare(strict_types=1);

namespace App\Controller\Demo;

use App\Controller\AbstractController;
use App\Event\UserRegistered;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Class EventDemo
 * @AutoController()
 *
 * @package App\Controller\Demo
 */
class EventDemo extends AbstractController
{
    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function index()
    {
        $this->eventDispatcher->dispatch(new UserRegistered(['name' => 'august']));

        return true;
    }
}

