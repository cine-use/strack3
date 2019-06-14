<?php


use Phinx\Seed\AbstractSeed;

class ViewUseSeeder extends AbstractSeed
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
        $rows = [
            [
                'view_id' => 1,
                'project_id' => 1,
                'page' => "project_sequence",
                'user_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'view_id' => 2,
                'project_id' => 1,
                'page' => 'project_note',
                'user_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'view_id' => 3,
                'project_id' => 1,
                'page' => 'project_timelog',
                'user_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'view_id' => 4,
                'project_id' => 1,
                'page' => 'project_file_commit',
                'user_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'view_id' => 5,
                'project_id' => 1,
                'page' => 'project_episode',
                'user_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'view_id' => 6,
                'project_id' => 1,
                'page' => 'project_pre_production',
                'user_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'view_id' => 7,
                'project_id' => 1,
                'page' => 'project_shot',
                'user_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'view_id' => 8,
                'project_id' => 1,
                'page' => 'project_base',
                'user_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'view_id' => 9,
                'project_id' => 1,
                'page' => 'project_file',
                'user_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'view_id' => 10,
                'project_id' => 1,
                'page' => 'project_review',
                'user_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'view_id' => 11,
                'project_id' => 1,
                'page' => 'project_asset',
                'user_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'view_id' => 12,
                'project_id' => 1,
                'page' => 'admin_account',
                'user_id' => '1',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];
        $this->table('strack_view_use')->insert($rows)->save();
    }
}
