<?php


use Phinx\Migration\AbstractMigration;

class FillStatusData extends AbstractMigration
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
     */
    public function up()
    {
        $rows = [
            [
                'name' => 'Not started', //未开始
                'code' => 'not_started',
                'color' => 'cccccc',
                'icon' => 'icon-uniEA7E',
                'correspond' => 'not_started',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Waiting to Start', //等待开始
                'code' => 'waiting_to_start',
                'color' => 'c6c6c6',
                'icon' => 'icon-uniF068',
                'correspond' => 'not_started',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Ready to Start', //准备开始
                'code' => 'ready_to_start',
                'color' => 'e7c025',
                'icon' => 'icon-uniEA7E',
                'correspond' => 'not_started',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'On Hold', //暂停
                'code' => 'on_hold',
                'color' => '6310e8',
                'icon' => 'icon-uniEA3F',
                'correspond' => 'blocked',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Normal', //正常
                'code' => 'normal',
                'color' => '10a0e8',
                'icon' => 'icon-uniEAB1',
                'correspond' => 'in_progress',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Open', //打开
                'code' => 'open',
                'color' => 'b0b0b0',
                'icon' => 'icon-uniF1DB',
                'correspond' => 'done',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'In progress', //进行中
                'code' => 'ip',
                'color' => '4e74f2',
                'icon' => 'icon-uniE6B9',
                'correspond' => 'in_progress',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Outsource', //外包
                'code' => 'outsource',
                'color' => 'ff2ef8',
                'icon' => 'icon-uniF045',
                'correspond' => 'in_progress',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Submitted', //提交
                'code' => 'submitted',
                'color' => 'e7c025',
                'icon' => 'icon-uniEA39',
                'correspond' => 'in_progress',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Feedback', //反馈
                'code' => 'feedback',
                'color' => 'f00707',
                'icon' => 'icon-uniF04A',
                'correspond' => 'in_progress',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Pending Review', //评审
                'code' => 'pending_review',
                'color' => 'fabb1b',
                'icon' => 'icon-uniE96C',
                'correspond' => 'daily',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Dailies', //日常会议
                'code' => 'dailies',
                'color' => '00ffa6',
                'icon' => 'icon-uniE6A9',
                'correspond' => 'daily',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Client Review', //客户审核
                'code' => 'client_review',
                'color' => '99e00b',
                'icon' => 'icon-uniF0C0',
                'correspond' => 'daily',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'CBB', //可以做得更好（一般是没有时间了暂时就这样）
                'code' => 'cbb',
                'color' => 'ff5500',
                'icon' => 'icon-uniE645',
                'correspond' => 'done',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Approved', //批准
                'code' => 'approved',
                'color' => '05eb1c',
                'icon' => 'icon-uniE69A',
                'correspond' => 'done',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Director Approved', //导演通过
                'code' => 'director_approved',
                'color' => '44bd15',
                'icon' => 'icon-uniE9F5',
                'correspond' => 'done',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Revision', //修订
                'code' => 'revision',
                'color' => '358500',
                'icon' => 'icon-uniF1B8',
                'correspond' => 'done',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Final', //最终
                'code' => 'final',
                'color' => '05eb1c',
                'icon' => 'icon-uniEA39',
                'correspond' => 'done',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Delivered', //交付
                'code' => 'delivered',
                'color' => '999999',
                'icon' => 'icon-uniE6BF',
                'correspond' => 'done',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Omitted', //删除
                'code' => 'omitted',
                'color' => '575757',
                'icon' => 'icon-uniF00D',
                'correspond' => 'done',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Closed', //关闭
                'code' => 'closed',
                'color' => '454445',
                'icon' => 'icon-uniE6A7',
                'correspond' => 'done',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Hide', //隐藏
                'code' => 'hide',
                'color' => '878787',
                'icon' => 'icon-uniEA01',
                'correspond' => 'hide',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Readed', //阅读
                'code' => 'readed',
                'color' => '9abdd6',
                'icon' => 'icon-uniEACC',
                'correspond' => 'in_progress',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Ignore', //忽略
                'code' => 'ignore',
                'color' => 'ababab',
                'icon' => 'icon-uniE6A7',
                'correspond' => 'blocked',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];

        $this->table('strack_status')->insert($rows)->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_status');
    }
}
