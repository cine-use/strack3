<?php

use Phinx\Seed\AbstractSeed;

class MediaSeeder extends AbstractSeed
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
                'link_id' => $i,
                'module_id' => 36,
                'md5_name' => '1538123324DtzRUFqD',
                'thumb' => 'http://192.168.31.108:9092/uploads/1538123324DtzRUFqD/1538123324DtzRUFqD_250x140.jpg',
                'size' => 'origin,250x140',
                'media_server_id' => 1,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }
        $table = $this->table('strack_media');
        $table->insert($data)->save();
    }
}
