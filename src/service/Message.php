<?php

namespace plugin\socket\service;


use Exception;
use GatewayWorker\Lib\Gateway;
use think\admin\Service;

/**
 * 通信逻辑处理
 */
class Message extends Service
{

    /**
     * 判断用户权限
     * @param $client
     * @param $code
     * @return bool|null
     */
    public static function onConnect($client,$code): ?bool
    {
        return Gateway::bindUid($client,$code);
    }

    /**
     * 发送指定用户信息
     * @param $code
     * @param $data
     * @throws Exception
     */
    public static function sendMessage($code,$data)
    {
        Socket::sendToUid($code,json_encode($data,JSON_UNESCAPED_UNICODE));
    }

}