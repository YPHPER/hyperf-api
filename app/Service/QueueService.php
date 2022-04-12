<?php

declare(strict_types=1);

namespace App\Service;

use App\Job\ExampleJob;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;

class QueueService
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    public function __construct(DriverFactory $driverFactory)
    {
        $this->driver = $driverFactory->get('default');
    }

    public function push($params, int $delay=0):bool
    {
        //这里的ExampleJob 会被序列化存到Redis中，所以内部变量最好只传入普通数据
        //同理，如果内部使用了注解@Value 会把对应对象一起序列化，导致消息体变大
        //所以这里也不推荐使用make方法来创建Job对象
        return $this->driver->push(new ExampleJob($params),$delay);
    }

}