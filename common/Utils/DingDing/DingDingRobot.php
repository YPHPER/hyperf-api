<?php

declare(strict_types=1);

namespace Common\Utils\DingDing;

/**
 * Class DingDingRobot
 * @package Common\Utils\DingDing
 */
class DingDingRobot
{
    public $url = '';
    public $messageType = 'text';
    public $content = [];
    public $atContent = [];

    public function __construct($url)
    {
        $timestamp  = floor(microtime(true) * 1000);
        $sign = $this->sign($timestamp);
        $url = $url.'&timestamp='.$timestamp.'&sign='.$sign;
        $this->url = $url;
    }

    public function setTextType()
    {
        $this->messageType = 'text';
        return $this;
    }

    public function setMarkdownType()
    {
        $this->messageType = 'markdown';
        return $this;
    }

    public function setActionCardType()
    {
        $this->messageType = 'actionCard';
        return $this;
    }

    public function setFeedCardType()
    {
        $this->messageType = 'feedCard';
        return $this;
    }

    public function setLinkType()
    {
        $this->messageType = 'link';
        return $this;
    }

    public function setContent(array $content)
    {
        $this->content[$this->messageType] = $content;
        return $this;
    }

    public function atMobile(array $mobile)
    {
        $this->atContent['at']['atMobiles'] = $mobile;
        return $this;
    }

    public function atAll($isAtAll = true)
    {
        $this->atContent['at']['isAtAll'] = $isAtAll;
        return $this;
    }

    public function send()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json;charset=utf-8']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
            array_merge(['msgtype' => $this->messageType], $this->content, $this->atContent)
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data, true);
    }

    protected function sign($timestamp)
    {
        $secret       = 'SECc957a0970ce9157429af3c9e4e9452caf6c9d78ac9871f43bfce01fc06ef189c';
        $stringToSign = $timestamp . "\n" . $secret;
        $signData     = base64_encode(hash_hmac('sha256', $stringToSign, $secret, true));

        return rawurlencode($signData);
    }
}
