<?php


use Phinx\Migration\AbstractMigration;

class FillDefaultPageSchemaUseData extends AbstractMigration
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
            ['page' => 'project_overview', 'schema_id' => '1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ['page' => 'project_member', 'schema_id' => '2', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ['page' => 'project_base', 'schema_id' => '3', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ['page' => 'project_file', 'schema_id' => '4', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ['page' => 'project_file_commit', 'schema_id' => '5', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ['page' => 'project_media', 'schema_id' => '6', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ['page' => 'project_note', 'schema_id' => '7', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ['page' => 'project_onset', 'schema_id' => '8', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ['page' => 'project_timelog', 'schema_id' => '9', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ['page' => 'admin_account', 'schema_id' => '11', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ['page' => 'tag_link', 'schema_id' => '12', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ['page' => 'admin_action', 'schema_id' => '13', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ['page' => 'project_review', 'schema_id' => '14', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
        ];

        $this->table('strack_page_schema_use')->insert($rows)->save();
    }


    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_page_schema_use');
    }
}
