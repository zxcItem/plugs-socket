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
    protected $package = 'xiaochao/plugs-socket00000000000000000---------';


    /**
     * 菜单配置
     * @return array[]
     */
    public static function menu(): array
    {
        // 设置插件菜单
        $code = app(static::class)->appCode;
        return [
            [
                'name' => '通信记录',
                'subs' => [
                    ['name' => '通信账户管理', 'icon' => 'layui-icon layui-icon-chart', 'node' => "{$code}/master/index"],
                    ['name' => '通信记录管理', 'icon' => 'layui-icon layui-icon-chart', 'node' => "{$code}/record/index"],
                ],
            ],
        ];
    }
}