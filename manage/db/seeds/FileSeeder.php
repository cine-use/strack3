<?php

use Phinx\Seed\AbstractSeed;

class FileSeeder extends AbstractSeed
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
                'name' => '测试文件_' . $i,
                'md5_name' => '',
                'code' => 'test_file_' . $i,
                'file_commit_id' => $i,
                'file_type_id' => $i,
                'project_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }
        $table = $this->table('strack_file');
        $table->insert($data)->save();
    }
}
