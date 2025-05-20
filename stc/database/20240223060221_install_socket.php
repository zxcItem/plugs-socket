<?php

use plugin\socket\Service;
use think\admin\extend\PhinxExtend;
use think\migration\Migrator;

class InstallSocket extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->_create_menu();
        $this->_create_socket_master();
        $this->_create_socket_record();
    }

    /**
     * 初始化系统菜单
     * @return void
     */
    private function _create_menu()
    {
        // 初始化菜单数据
        PhinxExtend::write2menu([
            [
                'name' => '通信管理',
                'subs' => Service::menu(),
            ],
        ], ['url|node' => 'plugin-socket/master/index']);
    }

    /**
     * 插件-通信账户
     * @class SocketMaster
     * @table SocketMaster
     * @return void
     */
    private function _create_socket_master()
    {

        // 当前数据表
        $table = 'socket_master';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '插件-通信账户',
        ])
            ->addColumn('name', 'string', ['limit' => 255, 'default' => '', 'null' => true, 'comment' => '账户标题'])
            ->addColumn('code', 'string', ['limit' => 255, 'default' => '', 'null' => true, 'comment' => '账户标识'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '账户状态'])
            ->addColumn('create_time', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间'])
            ->addIndex('code', ['name' => 'idx_socket_master_code'])
            ->addIndex('status', ['name' => 'idx_socket_master_status'])
            ->addIndex('create_time', ['name' => 'idx_socket_master_create_time'])
            ->create();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 11, 'identity' => true]);
    }

    /**
     * 插件-通信记录
     * @class SocketRecord
     * @table SocketRecord
     * @return void
     */
    private function _create_socket_record()
    {

        // 当前数据表
        $table = 'socket_record';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '插件-通信记录',
        ])
            ->addColumn('unid', 'biginteger', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '账号编号'])
            ->addColumn('funid', 'biginteger', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '接收账号'])
            ->addColumn('code', 'string', ['limit' => 255, 'default' => '', 'null' => true, 'comment' => '账号标识'])
            ->addColumn('comment', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '消息内容'])
            ->addColumn('create_time', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间'])
            ->addIndex('unid', ['name' => 'idx_socket_record_unid'])
            ->addIndex('funid', ['name' => 'idx_socket_record_funid'])
            ->addIndex('code', ['name' => 'idx_socket_record_code'])
            ->addIndex('create_time', ['name' => 'idx_socket_record_create_time'])
            ->create();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 11, 'identity' => true]);
    }
}
