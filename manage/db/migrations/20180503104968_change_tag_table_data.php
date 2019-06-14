<?php


use Phinx\Migration\AbstractMigration;

class ChangeTagTableData extends AbstractMigration
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
        $table = $this->table('strack_tag');


        // 添加数据字段
        $table->addColumn('parent_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '父级ID']);

        // 修改数据字段
        $table->changeColumn('type', 'enum', ['values' => 'system,review,approve,publish,custom,liber', 'default' => 'system', 'comment' => '标签类型']);

        $table->save();
    }

    public function down()
    {
        $this->execute('DELETE FROM strack_tag');
    }
}
