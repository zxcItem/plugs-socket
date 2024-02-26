<?php

namespace plugin\socket\service;


use Exception;
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
     * @return void
     */
    public static function onConnect($client,$code)
    {
        $master = SocketMaster::mk()->where('code',$code)->findOrEmpty();
        if ($master->isEmpty()) Socket::closeClient($client,'权限不足,请联系管理员!');
    }

    /**
     * 发送指定用户信息
     * @throws Exception
     */
    public static function sendMessage($data)
    {
        Socket::sendToUid($data['code'],$data['message']);
        SocketRecord::mk()->save([
            'code'    => $data['code'],
            'comment' => $data['message']
        ]);
    }

}