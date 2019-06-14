<?php


use Phinx\Migration\AbstractMigration;

class ChangeTableTextFieldEmpty extends AbstractMigration
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
    public function up()
    {

        $this->execute('UPDATE `strack_base` SET `description`="" WHERE `description` is null');

        $this->execute('UPDATE `strack_dir_template` SET `pattern`="" WHERE `pattern` is null');

        $this->execute('UPDATE `strack_dir_variable` SET `record`="" WHERE `record` is null');

        $this->execute('UPDATE `strack_download` SET `path`="" WHERE `path` is null');

        $this->execute('UPDATE `strack_entity` SET `description`="" WHERE `description` is null');

        $this->execute('UPDATE `strack_file` SET `description`="" WHERE `description` is null');

        $this->execute('UPDATE `strack_file_commit` SET `description`="" WHERE `description` is null');

        $this->execute('UPDATE `strack_media` SET `description`="" WHERE `description` is null');

        $this->execute('UPDATE `strack_media` SET `thumb`="" WHERE `thumb` is null');

        $this->execute('UPDATE `strack_project` SET `description`="" WHERE `description` is null');

        $this->execute('UPDATE `strack_timelog` SET `description`="" WHERE `description` is null');

        $this->execute('UPDATE `strack_variable_value` SET `value`="" WHERE `value` is null');

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_base');
        $this->execute('DELETE FROM strack_dir_template');
        $this->execute('DELETE FROM strack_dir_variable');
        $this->execute('DELETE FROM strack_download');
        $this->execute('DELETE FROM strack_entity');
        $this->execute('DELETE FROM strack_file');
        $this->execute('DELETE FROM strack_file_commit');
        $this->execute('DELETE FROM strack_media');
        $this->execute('DELETE FROM strack_project');
        $this->execute('DELETE FROM strack_timelog');
        $this->execute('DELETE FROM strack_variable_value');
    }
}
