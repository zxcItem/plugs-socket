<?php

namespace plugin\socket\service;

use think\admin\Exception;
use think\admin\Service;

/**
 * 通信服务参数配置
 */
class Config extends Service
{
    /**
     * 用户配置缓存名
     * @var string
     */
    private static $skey = 'plugin.socket.config';

    /**
     * 读取配置参数
     * @param string|null $name
     * @param $default
     * @return array|mixed|null
     * @throws Exception
     */
    public static function get(?string $name = null, $default = null)
    {
        $syscfg = sysvar(self::$skey) ?: sysvar(self::$skey, sysdata(self::$skey));
        return is_null($name) ? $syscfg : ($syscfg[$name] ?? $default);
    }

    /**
     * 保存签到配置参数
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public static function set(array $data)
    {
        return sysdata(self::$skey, $data);
    }

    /**
     * 获取监听地址
     * @return mixed
     * @throws Exception
     */
    public static function listen()
    {
        return sysdata(self::$skey, 'listen');
    }
}