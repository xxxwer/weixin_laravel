<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Repo\Common\Log;
use App\Repo\Common\WXToken;
use App\Repo\Common\ReturnF;
use Exception;

class Index extends Controller
{
    public function __construct()
    {
        if (!WXToken::check()) {
            echo "no wx param";
            exit();
        }
    }

    public function wxTokenCheck()
    {
        $data = Request::all();
        if (!empty($data['echostr'])) {
            echo $data['echostr'];
            exit();
        } else {
            return $this->handleWX();
        }
    }

    // 接受消息参数 转发处理
    private function handleWX()
    {
        $data = Request::all();
        $xmlData = Request::getContent();
        Log::info('handleWX_data', [$xmlData]);
        $xmlData = simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (!empty($xmlData->Event) && !empty($xmlData->MsgType)) {
            return $this->handle($xmlData->MsgType . $xmlData->Event, $xmlData);
        }
        if (!empty($xmlData->MsgType)) {
            return $this->handle($xmlData->MsgType, $xmlData);
        }
        return ReturnF::returnTextXML($xmlData, '错误微信请求， 请联系管理员');
    }

    // 进一步转发
    private function handle($methodName, $xmlData)
    {
        $methodName = (string) $methodName;
        if (method_exists('App\Http\Controllers\Index\Index', $methodName))
        {
            return $this->$methodName($xmlData);
        } else {
            Log::info('Index::handle', [$methodName]);
            return ReturnF::returnTextXML('功能建设中，请联系管理员', $xmlData);
        }
    }

    // location 类型消息
    private function location($xmlData)
    {
        return ReturnF::returnTextXML(
            'x:' . (string)$xmlData->Location_X . "\n" .
            'y:' . (string)$xmlData->Location_Y . "\n" .
            'scale:' . (string)$xmlData->Scale . "\n",
            $xmlData);
    }

    // 接收普通消息
    private function text($xmlData)
    {
        $command = explode(' ', $xmlData->Content);
        $wxTextCommand = config('wxTextCommand');
        // 若已配置文本命令则转发文本命令
        if (!empty($wxTextCommand[$command[0]])) {
            $className = $wxTextCommand[$command[0]][0];
            $methodName = $wxTextCommand[$command[0]][1];
            return $className::$methodName($command, $xmlData);
        }
        return ReturnF::returnTextXML($xmlData->Content, $xmlData);
    }

    // 自定义菜单 view类型按钮 点击事件
    private function eventVIEW($xmlData)
    {
        Log::info('Index::eventVIEW', [$xmlData->asXML()]);
        return;
    }

    // 自定义菜单 click类型按钮 点击事件
    private function eventCLICK($xmlData)
    {
        switch ((string)$xmlData->EventKey) {
            case 'V1001_USER_INFO':
                $xmlData->Content = '获取用户信息';
                return $this->text($xmlData);
                break;
            case 'V1001_GOOD':
                return ReturnF::returnTextXML('thanks', $xmlData);
                break;
            case 'V1001_ALL_COMMAND':
                return ReturnF::returnTextXML(implode("\n", array_keys(config('wxTextCommand'))), $xmlData);
                break;
        }

        return ReturnF::returnTextXML('调试：漏掉click事件：' . $xmlData->EventKey, $xmlData);
    }

    // 自定义菜单中 location_select类型按钮点击事件
    private function eventlocation_select($xmlData)
    {
        switch ((string)$xmlData->EventKey) {
            case 'V1001_SEND_LOCATION':
                Log::info('Index::eventlocation_select', [$xmlData->asXML()]);
                return ReturnF::returnTextXML(
                    'x:' . (string)$xmlData->SendLocationInfo->Location_X . "\n" .
                    'y:' . (string)$xmlData->SendLocationInfo->Location_Y . "\n" .
                    'scale:' . (string)$xmlData->SendLocationInfo->Scale . "\n",
                    $xmlData);
                break;
        }

        return ReturnF::returnTextXML('调试：漏掉location_select事件：' . $xmlData->EventKey, $xmlData);
    }

    // 调用模板消息后的事件
    private function eventTEMPLATESENDJOBFINISH($xmlData)
    {
        Log::info('Index::eventTEMPLATESENDJOBFINISH', [$xmlData->asXML()]);
        return;
    }

    // 关注 事件
    private function eventsubscribe($xmlData)
    {
        return ReturnF::returnTextXML('正在学习 微信后端开发。', $xmlData);
    }

    // 取消关注 事件
    private function eventunsubscribe($xmlData)
    {
        Log::info('eventunsubscribe_event', [$xmlData->FromUserName . '用户取消关注']);
    }
}
