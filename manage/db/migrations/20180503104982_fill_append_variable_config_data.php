<?php


use Phinx\Migration\AbstractMigration;

class FillAppendVariableConfigData extends AbstractMigration
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

        $variableListData = $this->fetchAll('SELECT `id`,`config` FROM strack_variable WHERE `type` = "horizontal_relationship"');
        foreach ($variableListData as $item) {
            $configData = json_decode($item["config"], true);
            if (!array_key_exists("horizontal_config_id", $configData)) {
                $horizontalConfigData = $this->fetchRow('SELECT `id` FROM strack_horizontal_config WHERE src_module_id = "' . $configData["module_id"] . '" and dst_module_id = "' . $configData["relation_module_id"] . '"');
                $configData["horizontal_config_id"] = $horizontalConfigData["id"];
            }
            $updateConfig = addslashes(json_encode($configData));
            $this->execute("UPDATE `strack_variable` SET `config`='{$updateConfig}' WHERE `id`= {$item["id"]}");
        }
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_variable');
        $this->execute('DELETE FROM strack_horizontal_config');
    }
}
