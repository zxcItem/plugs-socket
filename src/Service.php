<?php

declare (strict_types=1);

namespace plugin\socket;

use think\admin\Plugin;

/**
 * 组件注册服务
 * @class Service
 * @package plugin\socket
 */
class Service extends Plugin
{
    /**
     * 定义插件名称
     * @var string
     */
    protected $appName = '通信服务';

    /**
     * 定义安装包名
     * @var string
     */
    protected $package = 'xiaochao/plugs-socket';


    public static function menu(): array
    {
        return [];
    }
}