<?php

namespace plugin\socket\controller\api;

use think\admin\Controller;
use think\admin\service\AdminService;
use think\exception\HttpResponseException;

/**
 * 通信服务
 */
class Worker extends Controller
{

    /**
     * 启动通信服务
     * @login true
     */
    public function start()
    {
        if (AdminService::isSuper()) try {
            $message = exec('xadmin:worker --custom gateway status');
            if (stripos($message, 'daemons started successfully for pid')) {
                sysoplog('系统运维管理', '尝试启动任务监听服务');
                $this->success('任务监听服务启动成功！');
            } elseif (stripos($message, 'daemons already exist for pid')) {
                $this->success('任务监听服务已经启动！');
            } else {
                $this->error(nl2br($message));
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            trace_file($exception);
            $this->error($exception->getMessage());
        } else {
            $this->error('请使用超管账号操作！');
        }
    }
}