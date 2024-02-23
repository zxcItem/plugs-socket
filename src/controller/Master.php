<?php

namespace plugin\socket\controller;

use plugin\socket\model\SocketMaster;
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
        SocketMaster::mQuery()->layTable(function () {
            $this->title = '通信账户管理';
        }, function (QueryHelper $query) {
            $query->like('name,code')->dateBetween('create_time');
        });
    }

    /**
     * 添加通信账户
     * @auth true
     */
    public function add()
    {
        SocketMaster::mForm('form');
    }

    /**
     * 编辑通信账户
     * @auth true
     */
    public function edit()
    {
        SocketMaster::mForm('form');
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
        SocketMaster::mDelete();
    }
}