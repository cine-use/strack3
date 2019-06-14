<?php


use Phinx\Migration\AbstractMigration;

class CreateMediaServerTable extends AbstractMigration
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
        $table = $this->table('strack_media_server', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '媒体服务器ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '媒体服务器名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '媒体服务器编码'])
            ->addColumn('request_url', 'string', ['default' => '', 'limit' => 255, 'comment' => '媒体服务器请求地址'])
            ->addColumn('upload_url', 'string', ['default' => '', 'limit' => 255, 'comment' => '媒体服务器上传地址'])
            ->addColumn('access_key', 'string', ['default' => '', 'limit' => 128, 'comment' => '许可码'])
            ->addColumn('secret_key', 'string', ['default' => '', 'limit' => 128, 'comment' => '密钥'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
