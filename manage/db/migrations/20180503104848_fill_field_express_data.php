<?php


use Phinx\Migration\AbstractMigration;

class FillFieldExpressData extends AbstractMigration
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
                'field' => 'base.duration',
                'config' => json_encode([
                    'type' => 'system',
                    'express' => 'duration',
                    'affect_fields' => ['base.start_time', 'base.end_time']
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'field' => 'base.start_time',
                'config' => json_encode([
                    'type' => 'system',
                    'express' => 'duration',
                    'affect_fields' => ['base.duration', 'base.end_time']
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'field' => 'base.end_time',
                'config' => json_encode([
                    'type' => 'system',
                    'express' => 'duration',
                    'affect_fields' => ['base.duration', 'base.start_time']
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'field' => 'base.plan_duration',
                'config' => json_encode([
                    'type' => 'system',
                    'express' => 'duration',
                    'affect_fields' => ['base.plan_start_time', 'base.plan_end_time']
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'field' => 'base.plan_start_time',
                'config' => json_encode([
                    'type' => 'system',
                    'express' => 'duration',
                    'affect_fields' => ['base.plan_duration', 'base.plan_end_time']
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'field' => 'base.plan_end_time',
                'config' => json_encode([
                    'type' => 'system',
                    'express' => 'duration',
                    'affect_fields' => ['base.plan_duration', 'base.plan_start_time']
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'field' => 'base.entity_id',
                'config' => json_encode([
                    'type' => 'system',
                    'express' => 'base_entity_module',
                    'affect_fields' => ['base.entity_module_id']
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'field' => 'entity.duration',
                'config' => json_encode([
                    'type' => 'system',
                    'express' => 'duration',
                    'affect_fields' => ['entity.start_time', 'entity.end_time']
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'field' => 'entity.start_time',
                'config' => json_encode([
                    'type' => 'system',
                    'express' => 'duration',
                    'affect_fields' => ['entity.duration', 'entity.end_time']
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'field' => 'entity.end_time',
                'config' => json_encode([
                    'type' => 'system',
                    'express' => 'duration',
                    'affect_fields' => ['entity.duration', 'entity.start_time']
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'field' => 'entity.parent_id',
                'config' => json_encode([
                    'type' => 'system',
                    'express' => 'entity_parent_module',
                    'affect_fields' => ['entity.parent_module_id']
                ]),
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];

        $this->table('strack_field_express')->insert($rows)->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_field_express');
    }
}
