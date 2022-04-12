<?php

declare(strict_types=1);

namespace App\Process;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Process\AbstractProcess;
use Hyperf\Process\Annotation\Process;

/**
 * @Process(name="FooProcess")
 */
class FooProcess extends AbstractProcess
{
    public function handle(): void
    {
        $logger = $this->container->get(StdoutLoggerInterface::class);

        while(true){
            $redis = $this->container->get(\Redis::class);
            $count = $redis->llen('queue:failed');

            if ($count > 0) {
                $logger->warning('The num of failed queue is ' . $count);
            }

            sleep(15);
        }
    }
}
