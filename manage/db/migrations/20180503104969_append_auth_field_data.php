<?php


use Phinx\Migration\AbstractMigration;

class AppendAuthFieldData extends AbstractMigration
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
        $rows = [
            'name' => 'id',
            'lang' => 'ID',
            'type' => 'built_in',
            'variable_id' => 0,
            'project_id' => 0,
            'module_id' => 54,
            'module_code' => 'review',
            'uuid' => Webpatser\Uuid\Uuid::generate()->string
        ];
        $this->table('strack_auth_field')->insert($rows)->save();
    }


    public function down()
    {
        $this->execute('DELETE FROM strack_auth_field');
    }
}
