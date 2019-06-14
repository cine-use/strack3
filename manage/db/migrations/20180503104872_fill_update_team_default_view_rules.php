<?php


use Phinx\Migration\AbstractMigration;

class FillUpdateTeamDefaultViewRules extends AbstractMigration
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

        $this->execute('UPDATE `strack_page_auth` SET `category`="tab_team" WHERE `code`="save_default_view" and `page`="home_project_overview"');


        $this->execute('UPDATE `strack_page_auth` SET `category`="tab_my_review,tab_my_create,tab_follow,tab_all_playlist,tab_all_task,tab_my_review" WHERE `code`="save_default_view" and `page`="home_project_media" and `parent_id`=280');

    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_page_auth');
    }
}
