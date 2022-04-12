## 一：env配置
1. debug 和 env配置
2. mysql, redis, jwt, elasticsearch等配置
3. 新建.env, .env.dev, .env.prod便于管理
```
#三个值：local, develop, production 
APP_DEBUG=true
APP_ENV=local
```
## 二：公共类
##### 1. 引入公共 并自动加载
```
#新建文件夹：辅助类, 性状, 工具类
app/common/Helpers 
app/common/Traits
app/common/Utils

#composer.json加入
"Common\\": "common"

composer dumpautoload
```
##### 2. 辅助类
- TimeFormat 时间格式转换
- Validator  通用验证器

##### 3. 性状
- JsonResponse 接口响应json

##### 4. 工具类
- DingDingRobot 钉钉机器人


## composer包
```
composer require ext-curl
composer require ext-json
composer require ext-redis
composer require ext-bcmath
```

## 三：路由扩展
##### 1.公共路由
##### 2.api路由 包含版本控制

## 四：统一异常处理
##### 1.通过事件机制管理异常处理
```
一个事件就是一个用于管理状态数据的普通类，
触发时将应用数据传递到事件里，
然后监听器对事件类进行操作，
一个事件可被多个监听器监听。
```
## 五：数据验证层
##### 1.验证异常处理
##### 2.验证规则和使用


## 六：JWT
##### 1.composer require lcobucci/jwt
##### 2.使用中间件进行拦截验证

## 七：跨域处理
