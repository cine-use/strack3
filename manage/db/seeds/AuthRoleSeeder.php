<?php

use Phinx\Seed\AbstractSeed;

class AuthRoleSeeder extends AbstractSeed
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
                'name' => '管理员',
                'code' => 'administrators',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => '艺术家',
                'code' => 'Artist',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
        ];
        $table = $this->table('strack_auth_role');
        $table->insert($data)->save();
    }
}
