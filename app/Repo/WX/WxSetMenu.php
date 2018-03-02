<?php
namespace App\Repo\WX;

use Exception;
use App\Repo\Common\Log;
use App\Repo\Common\WXapi;
use App\Repo\Common\ReturnF;

class WxSetMenu
{
    private static $api_url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=%s';

    public static function setMenu()
    {
        $url = sprintf(self::$api_url, WXapi::getAccessToken());
        $postData =
<<<EOF
{
    "button":[
        {
            "type":"click",
            "name":"我的信息",
            "key":"V1001_USER_INFO"
        },
        {
            "name":"菜单",
            "sub_button":[
                {
                    "type":"view",
                    "name":"搜索",
                    "url":"http://www.bing.com/"
                },
                {
                   "type":"view",
                    "name":"showIpList",
                    "url":"https://{{ip}}/showIpList?code=mevb"
                },
                {
                    "type":"click",
                    "name":"赞一下我们",
                    "key":"V1001_GOOD"
                },
                {
                    "type":"click",
                    "name":"查看所有命令",
                    "key":"V1001_ALL_COMMAND"
                },
                {
                    "type": "location_select",
                    "name": "发送位置",
                    "key": "V1001_SEND_LOCATION"
                }
            ]
        }
    ],
    "matchrule":{
        "tag_id":"",
        "sex":"",
        "country":"",
        "province":"",
        "city":"",
        "client_platform_type":"",
        "language":"zh_CN"
    }
}
EOF;
        $ret = self::curlPost($url, self::setServerIP($postData));
        Log::info('WxGetUserInfo::getUserInfo', [$ret]);
        return $ret;
    }

    private static function setServerIP($string)
    {
        return str_replace('{{ip}}', config('wxConfig.serverIP'), $string);
    }

    public static function testSetMenu($command, $xmlData)
    {
        $ret = self::setMenu();
        return ReturnF::returnTextXML($ret, $xmlData);
    }

    private static function curlPost($url, $postData)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
