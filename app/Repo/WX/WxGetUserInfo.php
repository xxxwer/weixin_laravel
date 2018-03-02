<?php
namespace App\Repo\WX;

use Exception;
use App\Repo\Common\Log;
use App\Repo\Common\WXapi;
use App\Repo\Common\ReturnF;

class WxGetUserInfo
{
    private static $api_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN';

    public static function getUserInfo($openid)
    {
        $url = sprintf(self::$api_url, WXapi::getAccessToken(), $openid);
        $ret = self::curlGet($url);
        Log::info('WxGetUserInfo::getUserInfo', [$ret]);
        return $ret;
    }

    public static function testGetUserInfo($command, $xmlData)
    {
        $ret = self::getUserInfo((string)$xmlData->FromUserName);
        return ReturnF::returnTextXML($ret, $xmlData);
    }

    private static function curlGet($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
