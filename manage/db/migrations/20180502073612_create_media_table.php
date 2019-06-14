<?php


use Phinx\Migration\AbstractMigration;

class CreateMediaTable extends AbstractMigration
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
        $table = $this->table('strack_media', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '媒体ID'])
            ->addColumn('link_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '关联ID'])
            ->addColumn('module_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '所属模块ID'])
            ->addColumn('description', 'text', ['null' => true, 'comment' => '描述'])
            ->addColumn('md5_name', 'string', ['default' => '0', 'limit' => 255, 'comment' => '存储路径'])
            ->addColumn('thumb', 'text', ['null' => true, 'comment' => '缩略图'])
            ->addColumn('size', 'string', ['default' => '0', 'limit' => 255, 'comment' => '图片大小'])
            ->addColumn('type', 'enum', ['values' => 'thumb,attachment', 'default' => 'thumb', 'comment' => '类型'])
            ->addColumn('media_server_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '媒体服务器ID'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建者'])
            ->addColumn('created', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);


        $table->addIndex(['link_id', 'module_id'], ['type' => 'normal', 'name' => 'idx_link_module']);


        //执行创建
        $table->create();
    }
}
