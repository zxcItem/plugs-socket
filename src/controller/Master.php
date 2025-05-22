<?php

namespace plugin\socket\controller;

use plugin\socket\model\PluginSocketMaster;
use think\admin\Controller;
use think\admin\extend\CodeExtend;
use think\admin\helper\QueryHelper;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 通信账户管理
 * Class Master
 * @package plugin\socket\controller
 */
class Master extends Controller
{

    /**
     * 通信账户管理
     * @auth true
     * @menu true
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function index()
    {
        PluginSocketMaster::mQuery()->layTable(function () {
            $this->title = '通信账户管理';
        }, function (QueryHelper $query) {
            $query->like('name,code')->dateBetween('create_at');
        });
    }

    /**
     * 添加通信账户
     * @auth true
     */
    public function add()
    {
        PluginSocketMaster::mForm('form');
    }

    /**
     * 编辑通信账户
     * @auth true
     */
    public function edit()
    {
        PluginSocketMaster::mForm('form');
    }

    /**
     * 修改投票项目状态
     * @auth true
     */
    public function state()
    {
        PluginSocketMaster::mSave($this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 表单数据处理
     * @param array $data
     */
    protected function _form_filter(array &$data)
    {
        if (empty($data['code'])) $data['code'] = CodeExtend::uniqidDate(8, 'ST');
    }

    /**
     * 删除通信账户
     * @auth true
     */
    public function remove()
    {
        PluginSocketMaster::mDelete();
    }
}