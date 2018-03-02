<?php

return [
    '天气' => ['App\Repo\Common\Weather', 'weatherText'],
    '图文测试1' => ['App\Repo\Common\ReturnF', 'imgInfo1'],
    '图文测试2' => ['App\Repo\Common\ReturnF', 'imgInfo2'],
    '测试模板消息' => ['App\Repo\WX\WxTemplate', 'testTemplate'],
    '获取用户信息' => ['App\Repo\WX\WxGetUserInfo', 'testGetUserInfo'],
    '自定义菜单' => ['App\Repo\WX\WxSetMenu', 'testSetMenu']
];
