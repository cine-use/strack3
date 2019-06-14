<?php


use Phinx\Migration\AbstractMigration;

use Phinx\Db\Adapter\MysqlAdapter;

class CreatePageAuthTable extends AbstractMigration
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
        $table = $this->table('strack_page_auth', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '页面权限ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '页面权限名'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '页面权限编码'])
            ->addColumn('lang', 'string', ['default' => '', 'limit' => 128, 'comment' => '语言包'])
            ->addColumn('page', 'string', ['default' => '', 'limit' => 128, 'comment' => '所属页面'])
            ->addColumn('param', 'string', ['default' => '', 'limit' => 128, 'comment' => '所属页面'])
            ->addColumn('category', 'string', ['default' => '', 'limit' => 128, 'comment' => '所属分类'])
            ->addColumn('type', 'enum', ['values' => 'none,belong,children,client', 'default' => 'none', 'comment' => '是否有权限配置'])
            ->addColumn('menu', 'string', ['default' => '', 'limit' => 255, 'comment' => '所属菜单'])
            ->addColumn('parent_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '父级ID'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
