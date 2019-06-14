<?php

use Phinx\Seed\AbstractSeed;

class BaseSeeder extends AbstractSeed
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
        for ($i = 1; $i <= 20; $i++) {
            $rows = [
                'name' => '测试任务_' . $i,
                'code' => 'test_base_' . $i,
                'project_id' => '1',
                'entity_id' => "1",
                'status_id' => '1',
                'step_id' => "1",
                'priority' => "normal",
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }
        $table = $this->table('strack_base');
        $table->insert($data)->save();
    }
}
