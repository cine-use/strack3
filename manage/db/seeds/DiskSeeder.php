<?php

use Phinx\Seed\AbstractSeed;

class DiskSeeder extends AbstractSeed
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
                'name' => '测试磁盘',
                'code' => 'test_disk',
                'type' => 'local',
                'config' => "{\"wwww\": \"\"}",
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
        ];
        $table = $this->table('strack_disk');
        $table->insert($data)->save();
    }
}
