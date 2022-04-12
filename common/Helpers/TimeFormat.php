<?php

declare(strict_types=1);

namespace Common\Helpers;

/**
 * Class TimeFormat 时间格式转换
 * @package Common\Helpers
 */
class TimeFormat
{
    /**
     * ISO时间格式转为Unix时间戳
     * ISO日期格式（ISODatetime）是ISO8601标准规定的时间表示方式。云点播如无特别指定，所有时间相关参数统一采用ISO8601表示的UTC时间，格式为YYYY-MM-DDThh:mm:ssZ。如：2018-10-01T10:00:00Z，表示北京时间2018年10月01日18点00分00秒（北京时间值 = UTC 时间值 + 8小时）。
     * 2019-12-18T02:15:59Z -> 2019-12-18 10:15:59 -> 1576635359
     * @param string $ISOTime ISO时间格式
     * @return array
     */
    public static function ISO2Unix($ISOTime): int
    {
        $T_Character = stripos($ISOTime, "T");
        $Z_Character = stripos($ISOTime, "Z");

        if($T_Character && $Z_Character)
        {
            // 截取字符串转换
            $ISOTime = str_replace('T',' ', $ISOTime);

            $normalTime = str_replace('Z',' ', $ISOTime);

            // 如果是ISO8601格式，转换为时间戳
            $unixTime = strtotime($normalTime);
            // 需要+8小时
            $finalUnixTime = strtotime(date("Y-m-d H:i:s", $unixTime + 8 * 3600));

            return $finalUnixTime;
        }
        // 不是ISO格式就返回现在的时间戳
        return time();
    }

    /**
     * 多长时间以前
     * 1分钟内的：刚刚
     * 1小时内的：XXX分钟前
     * 1天内：XX小时前
     * 3天内的：昨天、前天
     * 超过以上的：20XX-XX-XX
     * @param string $posttime 存储的时间戳
     * @return string
     */
    public static function timeAgo($posttime)
    {
        // 今天最大时间
        $todayLast = strtotime(date('Y-m-d 23:59:59'));

        //相差时间戳
        $agoTimeTrue = time()-$posttime;

        $agoTime = $todayLast - $posttime;
        $agoDay = floor($agoTime / 86400);

        //进行时间转换
        if($agoTimeTrue <= 60){

            return '刚刚';

        }else if($agoTimeTrue>60 && $agoTimeTrue<=120){

            return '1分钟前';

        }else if($agoTimeTrue>120 && $agoTimeTrue<=180){

            return '2分钟前';

        }else if($agoTimeTrue>180 && $agoTimeTrue<3600){

            return ceil(($agoTimeTrue/60)).'分钟前';

        }else if($agoTimeTrue>=3600 && $agoTimeTrue<3600*24 && $agoDay == 0){

            return ceil(($agoTimeTrue/3600)).'小时前';

        }else if($agoDay == 1){

            return '昨天';

        }else if($agoDay == 2){

            return '前天';

        }else if($agoDay > 2){

            return date("Y-m-d", intval($posttime));

        }else{
            return $posttime;
        }
    }

    /*
     * 小于10000，直接显示
     * 1w条
     * 1.1w条
     * @param int $count
     * @return string
     */
    public static function formatNum(int $count)
    {
        $count_str = (string)$count;

        if ($count >= 10000)
        {
            $count_decimal = sprintf("%.1f", substr(sprintf("%.3f", $count/10000), 0, -2));

            if (substr($count_decimal, -1) == 0)
            {
                $count_decimal = str_replace('.0', '', $count_decimal);
            }
            $count_str = $count_decimal.'w';
        }
        return $count_str;
    }
}
