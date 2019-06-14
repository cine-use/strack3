<?php


use Phinx\Migration\AbstractMigration;

class FillStepData extends AbstractMigration
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
                'name' => 'Lookdev',
                'code' => 'lookdev',
                'color' => '00E6FE',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Previz',
                'code' => 'previz',
                'color' => 'ffbf36',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'EFX',
                'code' => 'efx',
                'color' => '127bc7',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Model',
                'code' => 'model',
                'color' => 'ba61ff',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Rig',
                'code' => 'rig',
                'color' => 'FE5CFF',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'MG',
                'code' => 'mg',
                'color' => 'dcf026',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'MP',
                'code' => 'mp',
                'color' => 'd526de',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Matchmove',
                'code' => 'matchmove',
                'color' => '26ded5',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Rotopaint',
                'code' => 'rotopaint',
                'color' => '3bd9cc',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Composting',
                'code' => 'comp',
                'color' => 'bcd93b',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Concept',
                'code' => 'concept',
                'color' => 'eb137b',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'StoryBoard',
                'code' => 'StoryBoard',
                'color' => 'f2a2c9',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Surface',
                'code' => 'surface',
                'color' => '2e99e6',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Animation',
                'code' => 'anim',
                'color' => '54d9e8',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Lighting',
                'code' => 'lighting',
                'color' => '23eb23',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Teamleader Review',
                'code' => 'teamleaderreview',
                'color' => '0073c4',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Supervisor Review',
                'code' => 'supervisorreview',
                'color' => '004170',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ],
            [
                'name' => 'Director Review',
                'code' => 'directorreview',
                'color' => '6c0087',
                'uuid' => Webpatser\Uuid\Uuid::generate()->string
            ]
        ];

        $this->table('strack_step')->insert($rows)->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_step');
    }
}
