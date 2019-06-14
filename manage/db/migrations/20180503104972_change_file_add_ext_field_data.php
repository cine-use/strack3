<?php

use Phinx\Migration\AbstractMigration;

class ChangeFileAddExtFieldData extends AbstractMigration
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

    public function up()
    {
        $fileTable = $this->table('strack_file');
        // 添加文件数据字段
        $fileTable->addColumn('ext', 'string', ['default' => '', 'limit' => 255, 'comment' => '文件后缀名']);
        $fileTable->save();

        // 添加文件类型数据字段
        $fileTypeTable = $this->table('strack_file_type');
        $fileTypeTable->addColumn('naming_rule', 'text', ['null' => true, 'comment' => '命名规则']);
        $fileTypeTable->save();
    }

    public function down()
    {
        $this->execute('DELETE FROM strack_file');
        $this->execute('DELETE FROM strack_file_type');
    }
}
