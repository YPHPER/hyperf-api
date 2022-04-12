<?php

declare(strict_types=1);

namespace App\Job;

use Hyperf\AsyncQueue\Job;

/**
 * 生产消息
 * Class ExampleJob
 *
 * @package App\Job
 */
class ExampleJob extends Job
{
    public $params;

    public $maxAttempts;

    public function __construct($params)
    {
        $this->params = $params;
        $this->maxAttempts=1;
    }

    public function handle()
    {
        //根据参数处理具体逻辑
        //通过具体参数获取模型等
//        var_dump($this->params);
        throw new \Exception('执行失败');
    }


}
