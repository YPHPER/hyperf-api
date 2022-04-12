<?php

declare(strict_types=1);

namespace App\Controller\Demo;

use App\Controller\BaseController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\JwtMiddleware;

/**
 * Class JwtDemo
 * @AutoController()
 * @Middleware(JwtMiddleware::class)
 * @package App\Controller\Demo
 */
class JwtDemo extends BaseController
{

    public function index()
    {
        return $this->getContextUserId();
    }

}

