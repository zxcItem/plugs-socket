<?php

namespace plugin\socket\controller;

use plugin\socket\model\PluginSocketRecord;
use plugin\socket\service\Config;
use think\admin\Controller;
use think\admin\Exception;
use think\admin\helper\QueryHelper;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 通信记录管理
 * Class Record
 * @package plugin\socket\controller
 */
class Record extends Controller
{

    /**
     * 通信记录管理
     * @auth true
     * @menu true
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function index()
    {
        PluginSocketRecord::mQuery()->layTable(function () {
            $this->title = '通信记录管理';
        }, function (QueryHelper $query) {
            $query->with('socketMaster')->equal('code')->dateBetween('create_at');
        });
    }

    /**
     * 数据列表处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {

    }

    /**
     * 删除通信记录
     * @auth true
     */
    public function remove()
    {
        PluginSocketRecord::mDelete();
    }

    /**
     * 修改签到配置
     * @auth true
     * @return void
     * @throws Exception|Exception
     */
    public function config()
    {
        if ($this->request->isGet()) {
            $this->vo = Config::get();
            $this->fetch('config');
        } else {
            Config::set($this->request->post());
            $this->success('配置更新成功！');
        }
    }
}