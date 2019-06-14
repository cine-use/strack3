<?php

use Phinx\Seed\AbstractSeed;

class FileCommitSeeder extends AbstractSeed
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
                'name' => '测试提交_' . $i,
                'code' => 'test_commit_' . $i,
                'project_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }
        $table = $this->table('strack_file_commit');
        $table->insert($data)->save();
    }
}
