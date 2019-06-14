<?php


use Phinx\Migration\AbstractMigration;

class ChangeApiAuthFieldRulesData extends AbstractMigration
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
        $this->execute('UPDATE `strack_auth_group` SET `code`="get_all_table_name",`lang`="Get_All_Table_Name" WHERE `id`= 459');
        $this->execute('UPDATE `strack_page_auth` SET `code`="get_all_table_name",`lang`="Get_All_Table_Name",`param`="getalltablename" WHERE `name`= "获取所有表名"');
    }

    public function down()
    {
        $this->execute('DELETE FROM strack_auth_group');
        $this->execute('DELETE FROM strack_page_auth');
    }
}
