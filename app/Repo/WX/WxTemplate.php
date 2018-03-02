<?php
namespace App\Repo\WX;

use Exception;
use App\Repo\Common\Log;
use App\Repo\Common\WXapi;

// test1 template
// {{first.DATA}}

// 商品名称：{{product.DATA}}
// 商品价格：{{price.DATA}}
// 购买时间：{{time.DATA}}
// {{remark.DATA}}

class WxTemplate
{
    private static $template_id = ['test1' => 'mG-8Js4kbCChjchMzM94BKcP2eAMO8__8on6jziA380'];
    private static $api_url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=';

    public static function sendShoppingInfo($touser, $topColor, $title, $product, $price, $time = null, $remark = '谢谢惠顾')
    {
        if (empty($time)) {
            $time = date('Y-m-d H:i:s');
        }
        $data = [
            "touser" => $touser,
            "template_id" => self::$template_id["test1"],
            "topcolor" => $topColor,
            "data" => [
                "first" => [
                    "value" => $title,
                    "color" => "#173177"
                ],
                "product" => [
                    "value" => $product,
                    "color" => "#173177"
                ],
                "price" => [
                    "value" => $price,
                    "color" => "#173177"
                ],
                "time" => [
                    "value" => $time,
                    "color" => "#173177"
                ],
                "remark" => [
                    "value" => $remark,
                    "color" => "#173177"
                ]
            ]
        ];
        $jsonData = json_encode($data);
        $ret = self::curlPost($jsonData);
        Log::info('sendShoppingInfo', [$ret]);
    }

    public static function testTemplate($command, $xmlData)
    {
        self::sendShoppingInfo((string)$xmlData->FromUserName, '#FF0000', '购物回执', 'PS4', '2300');
    }

    private static function curlPost($postData)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$api_url . WXapi::getAccessToken());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}
