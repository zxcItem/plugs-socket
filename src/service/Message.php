<?php

namespace plugin\socket\service;


use Exception;
use GatewayWorker\Lib\Gateway;
use plugin\socket\model\PluginSocketMaster;
use plugin\socket\model\PluginSocketRecord;
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
        $master = PluginSocketMaster::mk()->where('code',$code)->findOrEmpty();
        if ($master->isEmpty()) return Socket::closeClient($client,'权限不足,请联系管理员!');
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
        PluginSocketRecord::mk()->insert(['code'=>$code,'comment'=>json_encode($data,JSON_UNESCAPED_UNICODE)]);
    }

}