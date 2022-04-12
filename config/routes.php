<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

//公共路由
Router::addGroup(
'/common/',
    function(){
        require_once __DIR__.'/route/common.php';
    }
);

//api v1 路由
Router::addGroup(
    '/api/v1/',
    function (){
        require_once __DIR__.'/route/api/v1.php';
    }
);

