<?php

namespace Common\Traits;

/**
 * Trait 响应json数据
 * @package Common\Traits
 */
trait JsonResponse
{
    /**
     * @param int $code 状态码
     * @param string $message 信息
     * @param array $data 数据源
     * @return array
     */
    public function buildFormat(int $code = 0, string $message = 'success', $data = [])
    {
        return [
            'code' => $code,
            'msg' => $message,
            'data' => empty($data) ? new \StdClass : $data
        ];
    }

    /**
     * @param array $data 数据源
     * @return array
     */
    public function buildSuccessFormat($data = [])
    {
        return [
            'code' => 0,
            'msg' => 'success',
            'data' => empty($data) ? new \StdClass : $data
        ];
    }

    /**
     * 构建错误码
     * @param string $message 信息
     * @return array
     */
    public function buildErrorFormat(string $message)
    {
        return [
            'code' => -1,
            'msg' => $message,
            'data' => new \StdClass
        ];
    }

    /**
     * 构建service异常json
     * @param string $message 信息
     * @return array
     */
    public function buildServiceErrorFormat(string $message)
    {
        return [
            'code' => 10999,
            'msg' => $message,
            'data' => new \StdClass
        ];
    }
}
