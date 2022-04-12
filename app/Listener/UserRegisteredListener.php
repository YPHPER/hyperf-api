<?php

declare(strict_types=1);

namespace App\Listener;

use App\Event\UserRegistered;
use Hyperf\Event\Annotation\Listener;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * @Listener
 */
class UserRegisteredListener implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        ///返回一个该监听器要监听的事件数组，可以同时监听多个事件
        return [
            UserRegistered::class,
        ];
    }

    public function process(object $event)
    {
        //事件触发后该监听器要执行的代码写在这里，比如该示例下的发送用户注册成功短信等
        //直接访问$event的user 属性获得事件触发时传递的参数值
        //$event->user;

        var_dump($event->user);
    }
}
