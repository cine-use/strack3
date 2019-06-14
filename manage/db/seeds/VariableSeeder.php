<?php


use Phinx\Seed\AbstractSeed;

class VariableSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $rows = [
                'name' => 'text_custom' . $i,
                'code' => 'text_custom' . $i,
                'type' => 'text',
                'action_scope' => "all",
                'module_id' => 53,
                'project_id' => 1,
                'config' => '{"code": "text_custom' . $i . '", "mask": "*{1,999999999999999999}", "name": "text_custom' . $i . '", "type": "text", "module_id": "53", "input_mask": "arbitrary", "project_id": "1", "action_scope": "current", "input_mask_length": ""}',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }

        for ($i = 1; $i <= 10; $i++) {
            $rows = [
                'name' => 'checkbox_custom' . $i,
                'code' => 'checkbox_custom' . $i,
                'type' => 'checkbox',
                'action_scope' => "all",
                'module_id' => 53,
                'project_id' => 1,
                'config' => '{"code": "checkbox_custom' . $i . '", "mask": "*{1,999999999999999999}", "name": "checkbox_custom' . $i . '", "type": "text", "module_id": "53", "input_mask": "arbitrary", "project_id": "1", "action_scope": "current", "input_mask_length": ""}',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }

        for ($i = 1; $i <= 10; $i++) {
            $rows = [
                'name' => 'textarea_custom' . $i,
                'code' => 'textarea_custom' . $i,
                'type' => 'textarea',
                'action_scope' => "all",
                'module_id' => 53,
                'project_id' => 1,
                'config' => '{"code": "checkbox_custom' . $i . '", "mask": "*{1,999999999999999999}", "name": "checkbox_custom' . $i . '", "type": "checkbox_custom", "module_id": "53", "input_mask": "arbitrary", "project_id": "1", "action_scope": "current", "input_mask_length": ""}',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }

        for ($i = 1; $i <= 10; $i++) {
            $rows = [
                'name' => 'datebox_custom' . $i,
                'code' => 'datebox_custom' . $i,
                'type' => 'datebox',
                'action_scope' => "all",
                'module_id' => 53,
                'project_id' => 1,
                'config' => '{"code": "datebox_custom' . $i . '", "mask": "*{1,999999999999999999}", "name": "datebox_custom' . $i . '", "type": "datebox_custom", "module_id": "53", "input_mask": "arbitrary", "project_id": "1", "action_scope": "current", "input_mask_length": ""}',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }

        for ($i = 1; $i <= 10; $i++) {
            $rows = [
                'name' => 'datetimebox_custom' . $i,
                'code' => 'datetimebox_custom' . $i,
                'type' => 'datetimebox',
                'action_scope' => "all",
                'module_id' => 53,
                'project_id' => 1,
                'config' => '{"code": "datetimebox_custom' . $i . '", "mask": "*{1,999999999999999999}", "name": "datetimebox_custom' . $i . '", "type": "datetimebox_custom", "module_id": "53", "input_mask": "arbitrary", "project_id": "1", "action_scope": "current", "input_mask_length": ""}',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }

        $table = $this->table('strack_variable');
        $table->insert($data)->save();
    }
}
