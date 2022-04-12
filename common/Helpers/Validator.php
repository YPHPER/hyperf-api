<?php

namespace Common\Helpers;

/**
 * Class Validator 通用的验证器
 *
 * @package Common\Helpers
 */
class Validator
{
    /**
     * 检查是否是ip地址
     *
     * @param string $str
     *
     * @return bool|int
     */
    public static function isIp(string $str)
    {
        $ip        = explode('.', $str);
        $ip_length = count($ip);
        for ($i = 0; $i < $ip_length; $i++) {
            if ($ip[$i] > 255) {
                return false;
            }
        }

        return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $str);
    }

    /**
     * 判断是否一个合法的url地址
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isUrl(string $str)
    {
        return preg_match('/^((ht|f)tps?):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?$/',
            $str);
    }

    /**
     * 判断是否是合法的手机号码
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isPhone(string $str)
    {
        return preg_match('/^1[34578]\d{9}$/', $str);
    }


    /**
     * 匹配 大写字母、小写字母、阿拉伯数字
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isLetterNumber(string $str)
    {
        return preg_match('/^[a-zA-Z0-9]*$/', $str);
    }

    /**
     * 判断是否正整数
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isPositiveInteger(string $str)
    {
        return preg_match('/^\+?[1-9]\d*$/', $str);
    }

    /**
     * 判断是否自然数
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isNaturalNumber(string $str)
    {
        return preg_match('/^\+?[0-9]\d*$/', $str);
    }

    /**
     * 判断输入是否经度
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isLng(string $str)
    {
        return preg_match('/^(\-|\+)?(((\d|[1-9]\d|1[0-7]\d|0{1,3})\.\d{0,6})|(\d|[1-9]\d|1[0-7]\d|0{1,3})|180\.0{0,6}|180)$/',
            $str);
    }

    /**
     * 判断输入是否纬度
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isLat(string $str)
    {
        return preg_match('/^(\-|\+)?([0-8]?\d{1}\.\d{0,6}|90\.0{0,6}|[0-8]?\d{1}|90)$/', $str);
    }

    /**
     * 判断是否是合法的固话号码
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isTelephone(string $str)
    {
        return preg_match('/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}$/', $str);
    }

    /**
     * 判断是否是合法年月日
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isDate(string $str)
    {
        return preg_match('/^(19|20)\d{2}-(0?\d|1[012])-(0?\d|[12]\d|3[01])$/', $str);
    }

    public static function isHourMinute(string $str)
    {
        return preg_match('/((0?[0-9]|[12][0-3])\:(0?[0-9]|[1-5][1-9]))$/', $str);
    }

    /**
     * 判断是否是合法年月日是分秒
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isDateTime(string $str)
    {
        return preg_match('/^(19|20)\d{2}[\-](0?[1-9]|1[012])[\-](0?[1-9]|[12][0-9]|3[01])(\s+(0?[0-9]|[12][0-3])\:(0?[0-9]|[1-5][1-9])\:(0?[0-9]|[1-5][1-9]))?$/',
            $str);
    }

    /**
     * 判断是否是微信浏览器
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isWeChatBrowser(string $str)
    {
        return strpos($str, 'MicroMessenger');
    }

    /**
     * 验证固话或手机号码
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isPhoneOrTel(string $str)
    {
        return preg_match('/^((0\d{2,3}-\d{7,8})|(400-\d{3}-\d{4})|(1[34578]\d{9}))$/', $str);
    }

    /**
     * 检查是否一个图片uri地址
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isPictureUri(string $str)
    {
        return preg_match('/^((http|https))://((?!(\\.jpg|\\.png|\\.jpeg))).+?(\\.jpg|\\.png|\\.png)$/', $str);
    }

    /**
     * 检查版本格式是否正确
     *
     * @param string $str
     *
     * @return false|int
     */
    public static function isAppVersionNumber(string $str)
    {
        return preg_match('/^((\d{1,3}).(\d{1,3}).(\d{1,3}))$/', $str);
    }
}

