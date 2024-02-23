<?php

namespace plugin\socket\service;

use Exception;
use GatewayWorker\Lib\Gateway;
use think\admin\Service;

class Socket extends Service
{

    public static function onConnect($client_id)
    {
        $data = [
            'type' => 'init',
            'data' => '连接成功'
        ];
        Gateway::sendToClient($client_id,json_encode($data,JSON_UNESCAPED_UNICODE));
    }


    public static function onWebSocketConnect($client_id, $data)
    {
        $uid = $data['get']['token'];
        Gateway::bindUid($client_id,$uid);
    }


    /**
     * 有消息时触发该方法
     * @param int $clientid 发消息的client_id
     * @param mixed $message 消息
     * @throws Exception
     */
    public static function onMessage($clientid, $message)
    {
        // 群聊，转发请求给其它所有的客户端
        //Gateway::sendToAll("{$clientid} : {$message}");
    }

    /**
     * 发送指定用户信息
     * @param int $uid 发消息的uid
     * @param mixed $message 消息
     * @throws Exception
     */
    public static function sendToUid($uid, $message)
    {
        Gateway::sendToUid($uid,$message);
    }


}