<?php

namespace plugin\socket\controller;

use plugin\socket\model\SocketRecord;
use think\admin\Controller;
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
        SocketRecord::mQuery()->layTable(function () {
            $this->title = '通信记录管理';
        }, function (QueryHelper $query) {
            $query->equal('code')->dateBetween('create_time');
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
        SocketRecord::mDelete();
    }
}