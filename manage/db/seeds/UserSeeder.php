<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
                'login_name' => 'strack_test_' . $i,
                'email' => 'admin' . $i . '@strack.com',
                'name' => 'test_' . $i,
                'nickname' => 'test_' . $i,
                'phone' => '88888888888',
                'department_id' => 0,
                'password' => '$P$BRpF99iQ4yAtVa2364s9aJVCga7yJY.',
                'status' => 'in_service',
                'login_session' => '',
                'login_count' => 0,
                'token_time' => 0,
                'forget_count' => 0,
                'forget_token' => '',
                'last_forget' => 0,
                'failed_login_count' => 0,
                'last_login' => 0,
                'created' => 0,
                'uuid' => Webpatser\Uuid\Uuid::generate()->string,
            ];
            array_push($data, $rows);
        }

        $table = $this->table('strack_user');
        $table->insert($data)->save();
    }
}
