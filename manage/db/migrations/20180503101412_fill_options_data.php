<?php


use Phinx\Migration\AbstractMigration;

class FillOptionsData extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    /**
     * Migrate Up.
     * @throws Exception
     */
    public function up()
    {
        $rows = [
            [
                'name' => 'default_settings',
                'type' => 'system',
                'config' => json_encode([
                    "default_lang" => "zh-cn",
                    "default_nation" => "cn",
                    "default_password" => "Strack@Default_Login_123",
                    "default_timezone" => "Etc/GMT-8",
                    "default_emailsuffix" => "@strack.com",
                    "default_admin_password" => "Strack@Default_Admin_123",
                    "default_auto_fill_code" => "1"
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'default_schema',
                'type' => 'system',
                'config' => json_encode([
                    "schema_id" => 1
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'email_settings',
                'type' => 'system',
                'config' => json_encode([
                    "email_ssl" => "0",
                    "email_tls" => "0",
                    "email_code" => "UTF-8",
                    "email_open" => "1",
                    "email_pass" => "password",
                    "email_port" => "25",
                    "email_user" => "strack@strack.com",
                    "email_header" => "Strack",
                    "email_server" => "smtp.strack.com"
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'nation_settings',
                'type' => 'system',
                'config' => json_encode([
                    "nation" => ["us", "gb", "jp", "kr", "nz", "my", "hk", "mo", "cn", "an", "ai", "al", "ad"]
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'schedule_workday',
                'type' => 'system',
                'config' => json_encode([
                    "end" => "66600",
                    "start" => "34200",
                    "days" => "mon,tue,wed,thu,fri",
                    "exDate" => "holiday,non_workday"
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'schedule_reminders',
                'type' => 'system',
                'config' => json_encode([
                    "rbody" => "早点下班注意身体健康",
                    "ropen" => "1",
                    "rtitle" => "零点邮件提醒"
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'system_license',
                'type' => 'system',
                'config' => json_encode([
                    "license" => ""
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'message_settings',
                'type' => 'system',
                'config' => json_encode([
                    "project_change" => 1,
                    "entity_change" => 1,
                    "my_task_change" => 1,
                    "follow_task_change" => 1,
                    "has_review_task" => 1,
                    "has_note" => 1,
                    "has_note_at" => 1
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'review_settings',
                'type' => 'system',
                'config' => json_encode([
                    "direct_jump" => 0
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'system_version',
                'type' => 'system',
                'config' => json_encode([
                    "version" => STRACK_ENV["version"]
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'log_settings',
                'type' => 'system',
                'config' => json_encode([
                    "access_key" => "",
                    "secret_key" => "",
                    "request_url" => ""
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'lang_settings',
                'type' => 'system',
                'config' => json_encode([]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'ldap_login_setting',
                'type' => 'system',
                'config' => json_encode([
                    'ldap_open' => false,
                    'ldap_server_list' => []
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];

        $this->table('strack_options')->insert($rows)->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_options');
    }
}
