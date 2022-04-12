<?php

namespace App\Task;

use Hyperf\Task\Annotation\Task;
use Hyperf\Utils\Coroutine;

class AnnotationTask
{
    /**
     * @param $cid
     * @Task()
     * @return array
     */
    public function handle($cid)
    {
        return [
            'work.cid'=>$cid,
            'task.cid'=>Coroutine::id(),
        ];
    }
}