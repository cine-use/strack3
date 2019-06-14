<?php

use Phinx\Seed\AbstractSeed;

class ProjectSeeder extends AbstractSeed
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
        $data = [
            [
                'name' => '测试项目',
                'code' => 'test',
                'status_id' => 1,
                'rate' => 1,
                'description' => "",
                'start_time' => 1537459200,
                'end_time' => 1537977600,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
        ];
        $table = $this->table('strack_project');
        $table->insert($data)->save();
    }
}
