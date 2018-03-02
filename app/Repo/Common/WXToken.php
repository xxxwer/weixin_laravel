<?php

namespace App\Repo\Common;

use Illuminate\Support\Facades\Request;
use App\Repo\Common\Log;

class WXToken
{
    public static function check()
    {
        $token = 'wx_laravel';
        $data = Request::all();

        if (empty($data['nonce']) || empty($data['timestamp']) || empty($data['signature'])) {
            return false;
        }

        $ret = [$token, $data['timestamp'], $data['nonce']];
        sort($ret, SORT_STRING);
        $sha1 = sha1(implode($ret));
        Log::info('App\Repo\Common\WXToken::check', [$sha1, implode($ret), $data]);
        if ($sha1 === $data['signature']) {
            return true;
        } else {
            return false;
        }
    }

    public static function myCheck()
    {
        $data = Request::all();
        if (empty($data['code']) || $data['code'] !== 'mevb') {
            return false;
        }
        return true;
    }
}
