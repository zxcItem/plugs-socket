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

    /**
     * 判断用户权限
     * 将 client_id 与 token 绑定
     * @param $client_id
     * @param $data
     * @return bool
     */
    public static function onWebSocketConnect($client_id, $data): ?bool
    {
        if(empty($data['get']['token'])) return self::closeClient($client_id,'权限不足,请联系管理员!');
        return Message::onConnect($client_id,$data['get']['token']);
    }


    /**
     * 有消息时触发该方法
     * @param int|string $client 发消息的client_id
     * @param mixed $message 消息
     * @throws Exception
     */
    public static function onMessage($client, $message)
    {

    }

    /**
     * 通过client_id获取uid
     * @param $client
     * @return mixed
     */
    public static function getUidByClientId($client)
    {
       return Gateway::getUidByClientId($client);
    }

    /**
     * 发送指定用户信息
     * @param int|string $uid 发消息的uid
     * @param mixed $message 消息
     * @throws Exception
     */
    public static function sendToUid($uid, $message)
    {
        Gateway::sendToUid($uid,$message);
    }

    /**
     * 踢掉某个客户端，并以$message通知被踢掉客户端
     * @param string $client_id
     * @param string|null $message
     * @return bool|null
     */
    public static function closeClient(string $client_id, string $message = null): ?bool
    {
        return Gateway::closeClient($client_id,$message);
    }


}