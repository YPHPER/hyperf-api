<?php

declare(strict_types=1);

namespace App\Controller;

use Common\Traits\JsonResponse;

class BaseController extends AbstractController
{
    use JsonResponse;

    /**
     * 获取上下文的user_id
     * @return int
     */
    public function getContextUserId()
    {
        return $this->request->getAttribute('userId',0);
    }
}