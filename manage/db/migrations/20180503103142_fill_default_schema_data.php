<?php


use Phinx\Migration\AbstractMigration;

class FillDefaultSchemaData extends AbstractMigration
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
            ["id" => 1, 'name' => '项目模型', 'code' => 'project', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 2, 'name' => '项目成员模型', 'code' => 'project_member', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 3, 'name' => '任务模型', 'code' => 'base', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 4, 'name' => '文件模型', 'code' => 'file', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 5, 'name' => '文件提交模型', 'code' => 'file_commit', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 6, 'name' => '媒体模型', 'code' => 'media', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 7, 'name' => '回复模型', 'code' => 'note', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 8, 'name' => '现场数据模型', 'code' => 'onset', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 9, 'name' => '时间日志模型', 'code' => 'timelog', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 10, 'name' => '文件类型模型', 'code' => 'file_type', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 11, 'name' => '用户模型', 'code' => 'user', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 12, 'name' => '标签关联', 'code' => 'tag_link', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 13, 'name' => '动作模型', 'code' => 'action', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 14, 'name' => '审核模型', 'code' => 'review', 'type' => 'system', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
        ];

        $this->table('strack_schema')->insert($rows)->save();
    }


    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_schema');
    }
}
