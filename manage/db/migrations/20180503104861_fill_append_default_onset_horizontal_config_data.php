<?php


use Phinx\Migration\AbstractMigration;

class FillAppendDefaultOnsetHorizontalConfigData extends AbstractMigration
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
    /**
     * Migrate Up.
     */
    public function up()
    {
        $rows = [
            // 任务与现场数据之间互相关联
            ['src_module_id' => 4, 'dst_module_id' => 18, 'project_template_id' => 0, 'type' => 'has_many', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
        ];

        $moduleData = $this->fetchAll('SELECT id as module_id FROM strack_module WHERE type="entity"');
        $dstModuleData = $this->fetchAll('SELECT id as module_id FROM strack_module WHERE `code` = "onset"');

        foreach ($moduleData as $srcItem) {
            $srcModuleId = $srcItem["module_id"];
            foreach ($dstModuleData as $dstItem) {
                $dstModuleId = $dstItem["module_id"];
                array_push($rows, [
                    'src_module_id' => $srcModuleId,
                    'dst_module_id' => $dstModuleId,
                    'project_template_id' => 0,
                    'type' => 'has_many',
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ]);
            }
        }

        $this->table('strack_horizontal_config')->insert($rows)->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_horizontal_config');
    }
}
