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
     * 停止监听服务
     * @login true
     */
    public function stop()
    {
        if (AdminService::isSuper()) try {
            $map = [['--custom','register','stop'], ['--custom','gateway','stop'], ['--custom','business','stop']];
            foreach ($map as $item) {
                $message = $this->app->console->call('xadmin:worker', $item)->fetch();
                if (stripos($message, 'Send stop signal to Worker daemons')) {
                    sysoplog('系统运维管理', '尝试停止任务监听服务');
                    $success = '停止任务监听服务成功！';
                } elseif (stripos($message, 'The Worker daemons')) {
                    $success = '任务监听服务已停止！';
                } else {
                    $this->error(nl2br($message));
                }
            }
            $this->success($success);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            trace_file($exception);
            $this->error($exception->getMessage());
        } else {
            $this->error('请使用超管账号操作！');
        }
    }

    /**
     * 启动通信服务
     * @login true
     */
    public function start()
    {
        try {
            $map = [['--custom','register','-d'], ['--custom','gateway','-d'], ['--custom','business','-d']];
            foreach ($map as $item) {
                $message = $this->app->console->call('xadmin:worker', $item)->fetch();
                if (stripos($message, 'started successfully for Process')) {
                    sysoplog('通信服务管理', "尝试启动通信{$item[1]}服务");
                    $success = '任务监听服务启动成功';
                } elseif (stripos($message, 'already exists for Process')) {
                    $success = '任务监听服务已经启动';
                } else {
                    $this->error(nl2br($message));
                }
            }
            $this->success($success);
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            trace_file($exception);
            $this->error($exception->getMessage());
        }
    }

    /**
     * 检查监听服务
     * @login true
     */
    public function status()
    {
        if (AdminService::isSuper()) try {
            $message = $this->app->console->call('xadmin:worker', ['status'])->fetch();
            if (preg_match('/Process.*?\d+.*?running/', $message)) {
                preg_match_all("/\[(.*?)\]/", $message, $matches);$matches = $matches ? implode(',',$matches[0]) : '';
                echo "<span class='color-green pointer' data-tips-text='{$message}'>{$this->app->lang->get('已启动')}:{$matches}</span>";
            } else {
                echo "<span class='color-red pointer' data-tips-text='{$message}'>{$this->app->lang->get('未启动')}</span>";
            }
        } catch (\Error|\Exception $exception) {
            echo "<span class='color-red pointer' data-tips-text='{$exception->getMessage()}'>{$this->app->lang->get('异 常')}</span>";
        } else {
            $message = lang('只有超级管理员才能操作！');
            echo "<span class='color-red pointer' data-tips-text='{$message}'>{$this->app->lang->get('无权限')}</span>";
        }
    }
}