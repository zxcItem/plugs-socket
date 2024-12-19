<?php

return [
    // 服务监听地址
    'host'     => '127.0.0.1',
    // 服务监听端口
    'port'     => 2346,
    // 套接字上下文选项
    'context'  => [],
    // 高级自定义服务类
    'classes'  => '',
    // 消息请求回调处理
    'callable' => null,
    // 服务进程参数配置
    'worker'   => [
        'name'  => 'ThinkAdmin',
        'count' => 4,
    ],
    // 自定义服务配置（可选）
    'customs' => [
        // 自定义 Gateway 服务  php think xadmin:worker --custom gateway -d
        'gateway' => [
            // 进程类型(Workerman|Gateway|Register|Business)
            'type' => 'Gateway',
            // 监听地址(<协议>://<地址>:<端口>)
            'listen' => 'websocket://127.0.0.1:8689',
            // 高级自定义服务类
            'classes' => '',
            // 套接字上下文选项
            'context' => [],
            // 服务进程参数配置
            'worker' => [
                // 进程名称
                "name" => 'Gateway',
                // 进程数量
                "count" => 4,
                // 心跳发送时间，针对客户端
                'pingInterval' => 30,
                // 心跳容错次数，针对客户端
                'pingNotResponseLimit' => 0,
                // 心跳包内容，针对客户端
                'pingData' => '{"type":"ping"}',
                // 服务器内网IP
                "lanIp" => '127.0.0.1',
                // Business 回复 Gateway 端口
                "startPort" => 2000,
                // 注册服务地址，与 Register 进程对应
                "registerAddress" => '127.0.0.1:1236',
                // 进程启动回调
                "onWorkerStart" => function () {
                    echo "Gateway onWorkerStart" . PHP_EOL;
                },
                // 进程停止回调
                "onWorkerStop" => function () {
                    echo "Gateway onWorkerStop" . PHP_EOL;
                },
            ]
        ],
        // 自定义 Register 服务 php think xadmin:worker --custom register -d
        'register' => [
            // 进程类型(Workerman|Gateway|Register|Business)
            'type' => 'Register',
            // 监听地址(<协议>://<地址>:<端口>)
            // 注意：别改这里的协议，只支持 text 协议
            'listen' => 'text://127.0.0.1:1236'
        ],
        // 自定义 Business 服务 php think xadmin:worker --custom business -d
        'business' => [
            // 进程类型(Workerman|Gateway|Register|Business)
            'type' => 'Business',
            // 高级自定义服务类
            'classes' => '',
            // 服务进程参数配置
            'worker' => [
                // 进程名称
                "name" => 'Business',
                // 进程数量
                "count" => 4,
                // 注册服务地址，与 Register 进程对应
                "registerAddress" => '127.0.0.1:1236',
                // 业务处理类
                "eventHandler" => \plugin\socket\service\socket::class,
                // 进程启动回调
                "onWorkerStart" => function () {
                    echo "Business onWorkerStart" . PHP_EOL;
                },
                // 进程停止回调
                "onWorkerStop" => function () {
                    echo "Business onWorkerStart" . PHP_EOL;
                }
            ]
        ],
    ],
];