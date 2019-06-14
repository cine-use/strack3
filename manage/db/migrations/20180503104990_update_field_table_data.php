<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class UpdateFieldTableData extends AbstractMigration
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
        $config = "[{\"id\": \"id\", \"edit\": \"deny\", \"lang\": \"ID\", \"mask\": \"\", \"show\": \"yes\", \"sort\": \"deny\", \"type\": \"int\", \"group\": \"\", \"table\": \"Project\", \"editor\": \"none\", \"fields\": \"id\", \"filter\": \"deny\", \"module\": \"project\", \"multiple\": \"no\", \"validate\": \"\", \"_selected\": true, \"field_type\": \"built_in\", \"value_show\": \"id\", \"allow_group\": \"deny\", \"outreach_edit\": \"deny\", \"is_foreign_key\": \"no\", \"is_primary_key\": \"yes\", \"foreign_key_map\": \"project_id\", \"outreach_editor\": \"\", \"outreach_display\": \"no\", \"outreach_formatter\": \"\"}, {\"id\": \"name\", \"edit\": \"allow\", \"lang\": \"Name\", \"mask\": \"\", \"show\": \"yes\", \"sort\": \"deny\", \"type\": \"varchar\", \"group\": \"\", \"table\": \"Project\", \"editor\": \"text\", \"fields\": \"name\", \"filter\": \"allow\", \"module\": \"project\", \"require\": \"yes\", \"multiple\": \"no\", \"validate\": \"\", \"_selected\": true, \"field_type\": \"built_in\", \"value_show\": \"name\", \"allow_group\": \"deny\", \"data_source\": \"project\", \"outreach_edit\": \"deny\", \"is_foreign_key\": \"no\", \"foreign_key_map\": \"project_id\", \"outreach_editor\": \"none\", \"outreach_display\": \"no\"}, {\"id\": \"code\", \"edit\": \"allow\", \"lang\": \"Code\", \"mask\": \"\", \"show\": \"yes\", \"sort\": \"deny\", \"type\": \"varchar\", \"group\": \"\", \"table\": \"Project\", \"editor\": \"text\", \"fields\": \"code\", \"filter\": \"allow\", \"module\": \"project\", \"require\": \"yes\", \"multiple\": \"no\", \"validate\": \"\", \"_selected\": true, \"field_type\": \"built_in\", \"value_show\": \"code\", \"allow_group\": \"deny\", \"outreach_edit\": \"deny\", \"outreach_display\": \"no\"}, {\"id\": \"is_demo\", \"edit\": \"deny\", \"lang\": \"Is_Demo\", \"mask\": \"\", \"show\": \"no\", \"sort\": \"deny\", \"type\": \"enum(yes,no)\", \"group\": \"\", \"table\": \"Project\", \"editor\": \"none\", \"fields\": \"is_demo\", \"filter\": \"deny\", \"module\": \"project\", \"multiple\": \"no\", \"validate\": \"\", \"_selected\": true, \"field_type\": \"built_in\", \"value_show\": \"is_demo\", \"allow_group\": \"deny\", \"outreach_edit\": \"deny\", \"outreach_display\": \"no\"}, {\"id\": \"status_id\", \"edit\": \"deny\", \"lang\": \"Status\", \"mask\": \"\", \"show\": \"no\", \"sort\": \"deny\", \"type\": \"int\", \"group\": \"\", \"table\": \"Project\", \"editor\": \"combobox\", \"fields\": \"status_id\", \"filter\": \"allow\", \"module\": \"project\", \"require\": \"yes\", \"multiple\": \"no\", \"validate\": \"\", \"_selected\": true, \"field_type\": \"built_in\", \"value_show\": \"status_id\", \"allow_group\": \"deny\", \"data_source\": \"status\", \"outreach_edit\": \"deny\", \"outreach_lang\": \"\", \"create_in_time\": \"deny\", \"is_foreign_key\": \"yes\", \"foreign_key_map\": \"status_id\", \"outreach_editor\": \"combobox\", \"outreach_display\": \"no\"}, {\"id\": \"rate\", \"edit\": \"allow\", \"lang\": \"Rate\", \"mask\": \"\", \"show\": \"yes\", \"sort\": \"deny\", \"type\": \"char\", \"group\": \"\", \"table\": \"Project\", \"editor\": \"text\", \"fields\": \"rate\", \"filter\": \"allow\", \"module\": \"project\", \"multiple\": \"no\", \"validate\": \"\", \"_selected\": true, \"field_type\": \"built_in\", \"value_show\": \"rate\", \"allow_group\": \"deny\", \"outreach_edit\": \"deny\", \"outreach_display\": \"no\"}, {\"id\": \"description\", \"edit\": \"allow\", \"lang\": \"Description\", \"mask\": \"\", \"show\": \"yes\", \"sort\": \"deny\", \"type\": \"text\", \"group\": \"\", \"table\": \"Project\", \"editor\": \"textarea\", \"fields\": \"description\", \"filter\": \"allow\", \"module\": \"project\", \"multiple\": \"no\", \"validate\": \"\", \"_selected\": true, \"field_type\": \"built_in\", \"value_show\": \"description\", \"allow_group\": \"deny\", \"outreach_edit\": \"deny\", \"outreach_display\": \"no\"}, {\"id\": \"start_time\", \"edit\": \"allow\", \"lang\": \"Start_Time\", \"mask\": \"\", \"show\": \"yes\", \"sort\": \"deny\", \"type\": \"int\", \"group\": \"\", \"table\": \"Project\", \"editor\": \"datebox\", \"fields\": \"start_time\", \"filter\": \"allow\", \"format\": \"date\", \"module\": \"project\", \"multiple\": \"no\", \"validate\": \"\", \"_selected\": true, \"field_type\": \"built_in\", \"value_show\": \"start_time\", \"allow_group\": \"deny\", \"outreach_edit\": \"deny\", \"outreach_display\": \"no\"}, {\"id\": \"end_time\", \"edit\": \"allow\", \"lang\": \"End_Time\", \"mask\": \"\", \"show\": \"yes\", \"sort\": \"deny\", \"type\": \"int\", \"group\": \"\", \"table\": \"Project\", \"editor\": \"datebox\", \"fields\": \"end_time\", \"filter\": \"allow\", \"format\": \"date\", \"module\": \"project\", \"multiple\": \"no\", \"validate\": \"\", \"_selected\": true, \"field_type\": \"built_in\", \"value_show\": \"end_time\", \"allow_group\": \"deny\", \"outreach_edit\": \"deny\", \"outreach_display\": \"no\"}, {\"id\": \"created_by\", \"edit\": \"deny\", \"lang\": \"Created_By\", \"mask\": \"\", \"show\": \"yes\", \"sort\": \"deny\", \"type\": \"int\", \"group\": \"\", \"table\": \"Project\", \"editor\": \"combobox\", \"fields\": \"created_by\", \"filter\": \"deny\", \"format\": \"\", \"module\": \"project\", \"multiple\": \"no\", \"validate\": \"\", \"_selected\": true, \"show_from\": \"user.name\", \"field_type\": \"built_in\", \"value_show\": \"created_by\", \"allow_group\": \"deny\", \"outreach_edit\": \"deny\", \"outreach_display\": \"no\"}, {\"id\": \"created\", \"edit\": \"deny\", \"lang\": \"Created\", \"mask\": \"\", \"show\": \"yes\", \"sort\": \"deny\", \"type\": \"int\", \"group\": \"\", \"table\": \"Project\", \"editor\": \"datetimebox\", \"fields\": \"created\", \"filter\": \"deny\", \"format\": \"datetime\", \"module\": \"project\", \"multiple\": \"no\", \"validate\": \"\", \"_selected\": true, \"field_type\": \"built_in\", \"value_show\": \"created\", \"allow_group\": \"deny\", \"outreach_edit\": \"deny\", \"outreach_display\": \"no\"}, {\"id\": \"uuid\", \"edit\": \"deny\", \"lang\": \"Uuid\", \"mask\": \"\", \"show\": \"no\", \"sort\": \"deny\", \"type\": \"char\", \"group\": \"\", \"table\": \"Project\", \"editor\": \"none\", \"fields\": \"uuid\", \"filter\": \"deny\", \"module\": \"project\", \"multiple\": \"no\", \"validate\": \"\", \"_selected\": true, \"field_type\": \"built_in\", \"value_show\": \"uuid\", \"allow_group\": \"deny\", \"outreach_edit\": \"deny\"}, {\"id\": \"public\", \"edit\": \"allow\", \"lang\": \"Public\", \"mask\": \"\", \"show\": \"yes\", \"sort\": \"deny\", \"type\": \"enum(yes,no)\", \"group\": \"\", \"table\": \"Project\", \"editor\": \"combobox\", \"fields\": \"public\", \"filter\": \"deny\", \"module\": \"project\", \"multiple\": \"no\", \"validate\": \"\", \"_selected\": true, \"show_from\": \"\", \"field_type\": \"built_in\", \"value_show\": \"public\", \"allow_group\": \"deny\", \"data_source\": \"public_type\"}]";

        $this->execute("UPDATE `strack_field` SET `config`='{$config}' WHERE `table`= 'project'");
    }

    public function down()
    {
        $this->execute('DELETE FROM strack_field');
    }
}
