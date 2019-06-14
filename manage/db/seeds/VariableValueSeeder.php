<?php


use Phinx\Seed\AbstractSeed;

class VariableValueSeeder extends AbstractSeed
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
                'link_id' => $i,
                'module_id' => 53,
                'variable_id' => $i,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }

        for ($i = 11; $i <= 20; $i++) {
            $rows = [
                'link_id' => $i,
                'module_id' => 53,
                'variable_id' => $i,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }

        for ($i = 21; $i <= 30; $i++) {
            $rows = [
                'link_id' => $i,
                'module_id' => 53,
                'variable_id' => $i,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }

        for ($i = 31; $i <= 40; $i++) {
            $rows = [
                'link_id' => $i,
                'module_id' => 53,
                'variable_id' => $i,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }

        for ($i = 41; $i <= 50; $i++) {
            $rows = [
                'link_id' => $i,
                'module_id' => 53,
                'variable_id' => $i,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }

        $table = $this->table('strack_variable_value');
        $table->insert($data)->save();
    }
}
