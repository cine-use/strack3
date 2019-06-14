<?php


use Phinx\Migration\AbstractMigration;

class FillDefaultAuthFieldData extends AbstractMigration
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
        // 查询module表
        $moduleData = $this->query('SELECT * FROM strack_module');

        $moduleMapData = [];
        foreach ($moduleData as $moduleItem) {
            $moduleMapData[$moduleItem["code"]] = $moduleItem;
        }

        // 组装字段数据
        $queryFields = $this->query('SELECT * FROM strack_field');

        $rows = [];
        foreach ($queryFields as $fieldConfig) {
            $fieldConfigData = json_decode($fieldConfig["config"], true);

            $moduleId = 0;
            $moduleCode = $fieldConfig["table"];

            if (array_key_exists($fieldConfig["table"], $moduleMapData)) {
                $moduleId = $moduleMapData[$fieldConfig["table"]]["id"];
                $moduleCode = $moduleMapData[$fieldConfig["table"]]["code"];
            }

            foreach ($fieldConfigData as $field) {
                $rows[] = [
                    "name" => $field["fields"],
                    "lang" => $field["lang"],
                    "type" => "built_in",
                    "project_id" => 0,
                    "module_id" => $moduleId,
                    "module_code" => $moduleCode,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ];

            }
        }

        // 初始化table
        $table = $this->table('strack_auth_field');

        $table->insert($rows)->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_auth_node');
    }
}
