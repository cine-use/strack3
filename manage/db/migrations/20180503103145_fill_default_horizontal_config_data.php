<?php


use Phinx\Migration\AbstractMigration;

class FillDefaultHorizontalConfigData extends AbstractMigration
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
            // 任务之间互相关联
            ['src_module_id' => 4, 'dst_module_id' => 4, 'project_template_id' => 0, 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            // 任务与用户之间互相关联
            ['src_module_id' => 4, 'dst_module_id' => 34, 'project_template_id' => 0, 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            // 媒体之间互相关联
            ['src_module_id' => 14, 'dst_module_id' => 14, 'project_template_id' => 0, 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            // 现场数据之间互相关联
            ['src_module_id' => 18, 'dst_module_id' => 18, 'project_template_id' => 0, 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            // 发布之间互相关联
            ['src_module_id' => 24, 'dst_module_id' => 24, 'project_template_id' => 0, 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            // 时间日志之间互相关联
            ['src_module_id' => 31, 'dst_module_id' => 31, 'project_template_id' => 0, 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            // 版本之间互相关联
            ['src_module_id' => 42, 'dst_module_id' => 42, 'project_template_id' => 0, 'uuid' => Webpatser\Uuid\Uuid::generate()->string]
        ];

        $moduleData = $this->fetchAll('SELECT id as module_id FROM strack_module WHERE type="entity"');

        foreach ($moduleData as $srcItem) {
            $srcModuleId = $srcItem["module_id"];
            foreach ($moduleData as $dstItem) {
                $dstModuleId = $dstItem["module_id"];
                array_push($rows, [
                    'src_module_id' => $srcModuleId,
                    'dst_module_id' => $dstModuleId,
                    'project_template_id' => 0
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
