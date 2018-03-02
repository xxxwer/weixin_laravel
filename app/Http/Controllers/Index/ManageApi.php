<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Repo\Common\WXapi;
use App\Repo\Common\WXToken;
use Exception;

class ManageApi extends Controller
{
    public function __construct()
    {
        if (!WXToken::myCheck()) {
            echo json_encode(['status' => 'fail', 'reason' => 'error password']);
            exit();
        }
    }

    public function showAccessToken()
    {
        try {
            $ret = WXapi::getAccessToken();
            return response()->json(['status' => 'success', 'reason' => '', 'data' => $ret]);
        } catch (Exception $e) {
            return response()->json(['status' => 'success', 'reason' => $e->getMessage()]);
        }
    }

    public function showWxIpList()
    {
        try {
            $ret = WXapi::getWxIpList();
            return response()->json(['status' => 'success', 'reason' => '', 'data' => $ret]);
        } catch (Exception $e) {
            return response()->json(['status' => 'success', 'reason' => $e->getMessage()]);
        }
    }
}
