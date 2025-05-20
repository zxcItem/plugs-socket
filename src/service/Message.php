<?php

namespace plugin\socket\service;


use Exception;
use GatewayWorker\Lib\Gateway;
use plugin\socket\model\SocketMaster;
use plugin\socket\model\SocketRecord;
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
        $master = SocketMaster::mk()->where('code',$code)->findOrEmpty();
        if ($master->isEmpty()) return Socket::closeClient($client,'权限不足,请联系管理员!');
        Gateway::bindUid($client,$code);
    }

    /**
     * 发送指定用户信息
     * @param $data
     * @throws Exception
     */
    public static function sendMessage($data)
    {
        Socket::sendToUid($data['code'],json_encode($data,JSON_UNESCAPED_UNICODE));
        SocketRecord::mk()->save($data);
    }

}