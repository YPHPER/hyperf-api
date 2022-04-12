<?php

declare(strict_types=1);

namespace App\Controller\Demo;

use App\Controller\AbstractController;
use App\Request\FooRequest;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * Class ExceptionDemo
 * @AutoController()
 *
 * @package App\Controller\Demo
 */
class ValidateDemo extends AbstractController
{

    public function index(FooRequest $request)
    {
        $validated = $request->validated();
        return 'ok123';
    }

}

