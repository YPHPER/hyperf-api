<?php

declare(strict_types=1);

namespace App\Controller\Demo;

use App\Controller\AbstractController;
use Common\Utils\DingDing\DingDingRobot;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * Class DingDingDemo
 * @AutoController()
 *
 * @package App\Controller\Demo
 */
class DingDingDemo extends AbstractController
{
    public function index()
    {
        $robot = new DingDingRobot(
            'https://oapi.dingtalk.com/robot/send?access_token=xxxxxx'
        );

        [$url, $method, $requestParam] = [
            $this->request->getRequestUri(),
            strtoupper($this->request->getMethod()),
            json_encode([
                'get'=>$this->request->getQueryParams(),
                'post'=>$this->request->getParsedBody(),
            ],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT)
        ];

        $robot->setMarkdownType()->setContent([
            'title' => '[捂脸哭][捂脸哭][捂脸哭]业务异常报警!',
            'text' => "测试消息啊"   ])->send();
    }
}