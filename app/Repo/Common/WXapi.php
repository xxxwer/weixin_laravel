<?php
namespace App\Repo\Common;

use Exception;
use Cache;

class WXapi
{
    public static function getAccessToken()
    {
        $cacheKey = 'wx_access_token';
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $accessToken = self::callWxApigetAccessToken();

        Cache::put($cacheKey, $accessToken['access_token'], $accessToken['expires_in'] / 60 / 2);
        return Cache::get($cacheKey);
    }

    private static function callWxApigetAccessToken()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='
            . self::getWXConfig('AppID')
            . '&secret=' . self::getWXConfig('AppSecret');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $accessToken = json_decode($output, true);
        if (empty($accessToken['access_token'])) {
            throw new Exception("call wx api fail:" . $accessToken['errmsg'], 1);
        }

        return $accessToken;
    }

    public static function getWXConfig($name)
    {
        $ret = config('wxConfig.' . $name);
        if (empty($ret)) {
            throw new Exception("没有这项配置", 1);
        }
        return $ret;
    }

    public static function getWxIpList()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=' . self::getAccessToken();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $urlList = json_decode($output, true);
        if (empty($urlList['ip_list'])) {
            throw new Exception("call wx api fail:" . $accessToken['errmsg'], 1);
        }
        return $urlList;
    }
}
