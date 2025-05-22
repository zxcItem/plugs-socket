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
        $this->_create_plugin_socket_master();
        $this->_create_plugin_socket_record();
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
     * 通信账户
     * @class PluginSocketMaster
     * @table plugin_socket_master
     * @return void
     */
    private function _create_plugin_socket_master()
    {
        // 创建数据表对象
        $table = $this->table('plugin_socket_master', [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '通信账户',
        ]);
        PhinxExtend::upgrade($table, [
            ['name', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '账户标题']],
            ['code', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '账户标识']],
            ['status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '状态']],
            ['create_at', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间']],
        ], [
            'code','create_at'
        ], true);
    }

    /**
     * 通信记录
     * @class PluginSocketRecord
     * @table plugin_socket_record
     * @return void
     */
    private function _create_plugin_socket_record()
    {
        // 创建数据表对象
        $table = $this->table('plugin_socket_record', [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '通信记录',
        ]);
        PhinxExtend::upgrade($table, [
            ['unid', 'biginteger', ['limit' => 20,'default' => 0, 'null' => true, 'comment' => '账号编号']],
            ['funid', 'biginteger', ['limit' => 20,'default' => 0, 'null' => true, 'comment' => '接收账号']],
            ['code', 'string', ['limit' => 255,'default' => null, 'null' => true, 'comment' => '账户标识']],
            ['comment', 'text', ['default' => null, 'null' => true, 'comment' => '消息内容']],
            ['create_at', 'datetime', ['default' => NULL, 'null' => true, 'comment' => '创建时间']],
        ], [
            'unid','funid','code','create_at'
        ], true);
    }
}
