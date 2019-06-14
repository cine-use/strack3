<?php

use Phinx\Seed\AbstractSeed;

class FileTypeSeeder extends AbstractSeed
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
                'name' => '审核媒体_' . $i,
                'code' => 'Review_media',
                'type' => 'review',
                'ext' => 'gif',
                'project_id' => '0',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }

        for ($i = 11; $i <= 20; $i++) {
            $rows = [
                'name' => '模型工程文件_' . $i,
                'code' => 'Model_project',
                'type' => 'normal',
                'ext' => 'jpg',
                'project_id' => '0',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }
        $table = $this->table('strack_file_type');
        $table->insert($data)->save();
    }
}
