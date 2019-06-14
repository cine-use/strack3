<?php


use Phinx\Seed\AbstractSeed;

class EntitySeeder extends AbstractSeed
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
        for ($i = 1; $i <= 160000; $i++) {
            $rows = [
                'name' => '镜头' . $i,
                'code' => 'shot' . $i,
                'project_id' => 1,
                'module_id' => 53,
                'status_id' => 3,
                'parent_id' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ];
            array_push($data, $rows);
        }

        $table = $this->table('strack_entity');
        $table->insert($data)->save();
    }
}
