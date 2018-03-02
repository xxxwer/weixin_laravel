<?php

namespace App\Repo\Common;

use Exception;

class Weather
{
    public static function getWeather($city)
    {
        $json = self::curlData('http://wthrcdn.etouch.cn/weather_mini?city=' . $city);
        $data = json_decode($json, true);

        if (empty($data['data']['forecast'])) {
            throw new Exception('找不到城市' . $city . '的天气', 1);
        }
        return $data['data']['forecast'];
    }

    public static function curlData($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Encoding:gzip'));
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    public static function joinWeatherString($weather)
    {
        $str = '';
        foreach ($weather as $v) {
            $temp = '';
            foreach ($v as $v2) {
                $temp .= trim($v2, "<![CDATA[]]>") . ' ';
            }
            $str .= '(' . $temp . ")\n";
        }
        return $str;
    }

    public static function weatherText($cities, $xmlData)
    {
        $command = array_shift($cities);
        if (empty($cities)) {
            return ReturnF::returnTextXML('请按“天气 杭州 上海”格式输入，以空格分隔', $xmlData);
        }

        try {
            $weather = '';
            foreach ($cities as $city) {
                $weatherArray = Weather::getWeather($city);
                $weather .= $city . "\n----\n" . Weather::joinWeatherString($weatherArray) . "\n----\n";
            }
            return ReturnF::returnTextXML($weather, $xmlData);
        } catch (Exception $e) {
            return ReturnF::returnTextXML($e->getMessage(), $xmlData);
        }
    }
}
