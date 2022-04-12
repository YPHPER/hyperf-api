<?php

declare(strict_types=1);

namespace App\Controller\Demo;

use App\Controller\AbstractController;
use Common\Traits\JsonResponse;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * Class JsonResponseDemo
 * @AutoController()
 *
 * @package App\Controller\Demo
 */
class JsonResponseDemo extends AbstractController
{
    use JsonResponse;

    public function index()
    {
        $user   = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        $data = [
            'method'  => $method,
            'message' => "Hello {$user}.",
        ];

        return $this->buildSuccessFormat($data);
    }
}
