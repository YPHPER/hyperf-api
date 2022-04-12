<?php

declare(strict_types=1);

namespace App\Controller\Demo;

use App\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * Class ExceptionDemo
 * @AutoController()
 *
 * @package App\Controller\Demo
 */
class ExceptionDemo extends AbstractController
{

    public function index()
    {
        throw new \Exception('test exception');

        return true;
    }

}

