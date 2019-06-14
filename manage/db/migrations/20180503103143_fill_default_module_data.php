<?php


use Phinx\Migration\AbstractMigration;

class FillDefaultModuleData extends AbstractMigration
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
            //系统固定模块
            ["id" => 1, 'type' => 'fixed', 'active' => 'yes', 'name' => '动作', 'code' => 'action', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 2, 'type' => 'fixed', 'active' => 'yes', 'name' => '常用动作', 'code' => 'common_action', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 3, 'type' => 'fixed', 'active' => 'yes', 'name' => '项目成员', 'code' => 'project_member', 'icon' => 'icon-uniF0C0', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 4, 'type' => 'fixed', 'active' => 'yes', 'name' => '任务', 'code' => 'base', 'icon' => 'icon-uniE69A', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 5, 'type' => 'fixed', 'active' => 'yes', 'name' => '日历', 'code' => 'calendar', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 6, 'type' => 'fixed', 'active' => 'yes', 'name' => '客户回复', 'code' => 'client_note', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 7, 'type' => 'fixed', 'active' => 'yes', 'name' => '客户会话', 'code' => 'client_session', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 8, 'type' => 'fixed', 'active' => 'yes', 'name' => '部门', 'code' => 'department', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 9, 'type' => 'fixed', 'active' => 'yes', 'name' => '磁盘', 'code' => 'disk', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 10, 'type' => 'fixed', 'active' => 'yes', 'name' => '现场数据关联', 'code' => 'onset_link', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 11, 'type' => 'fixed', 'active' => 'yes', 'name' => '过滤条件', 'code' => 'filter', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 12, 'type' => 'fixed', 'active' => 'yes', 'name' => '关注', 'code' => 'follow', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 13, 'type' => 'fixed', 'active' => 'yes', 'name' => 'ldap域配置', 'code' => 'ldap', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 14, 'type' => 'fixed', 'active' => 'yes', 'name' => '媒体', 'code' => 'media', 'icon' => 'icon-uniEA3E', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 15, 'type' => 'fixed', 'active' => 'yes', 'name' => '媒体服务', 'code' => 'media_server', 'icon' => 'icon-uniEA3E', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 16, 'type' => 'fixed', 'active' => 'yes', 'name' => '成员', 'code' => 'member', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 17, 'type' => 'fixed', 'active' => 'yes', 'name' => '反馈', 'code' => 'note', 'icon' => 'icon-uniE6C3', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 18, 'type' => 'fixed', 'active' => 'yes', 'name' => '现场数据', 'code' => 'onset', 'icon' => 'icon-uniE62A', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 19, 'type' => 'fixed', 'active' => 'yes', 'name' => '角色', 'code' => 'role', 'icon' => 'icon-uniF1ED', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 20, 'type' => 'fixed', 'active' => 'yes', 'name' => '项目', 'code' => 'project', 'icon' => 'icon-uniF1ED', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 21, 'type' => 'fixed', 'active' => 'yes', 'name' => '项目磁盘', 'code' => 'project_disk', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 22, 'type' => 'fixed', 'active' => 'yes', 'name' => '事件日志', 'code' => 'eventlog', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 23, 'type' => 'fixed', 'active' => 'yes', 'name' => '项目模板', 'code' => 'project_template', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 24, 'type' => 'fixed', 'active' => 'yes', 'name' => '文件', 'code' => 'file', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 25, 'type' => 'fixed', 'active' => 'yes', 'name' => '目录模板', 'code' => 'dir_template', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 26, 'type' => 'fixed', 'active' => 'yes', 'name' => '软件', 'code' => 'software', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 27, 'type' => 'fixed', 'active' => 'yes', 'name' => '状态', 'code' => 'status', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 28, 'type' => 'fixed', 'active' => 'yes', 'name' => '工序', 'code' => 'step', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 29, 'type' => 'fixed', 'active' => 'yes', 'name' => '标签', 'code' => 'tag', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 30, 'type' => 'fixed', 'active' => 'yes', 'name' => '标签关联', 'code' => 'tag_link', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 31, 'type' => 'fixed', 'active' => 'yes', 'name' => '时间日志', 'code' => 'timelog', 'icon' => 'icon-uniE974', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 32, 'type' => 'fixed', 'active' => 'yes', 'name' => '时间日志记录事项', 'code' => 'timelog_issue', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 33, 'type' => 'fixed', 'active' => 'yes', 'name' => '角色用户', 'code' => 'role_user', 'icon' => 'icon-uniF0C0', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 34, 'type' => 'fixed', 'active' => 'yes', 'name' => '用户', 'code' => 'user', 'icon' => 'icon-uniF0C0', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 35, 'type' => 'fixed', 'active' => 'yes', 'name' => '用户配置', 'code' => 'user_config', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 36, 'type' => 'fixed', 'active' => 'yes', 'name' => '文件提交', 'code' => 'file_commit', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 37, 'type' => 'fixed', 'active' => 'yes', 'name' => '页面权限', 'code' => 'page_auth', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 38, 'type' => 'fixed', 'active' => 'yes', 'name' => '文件类型', 'code' => 'file_type', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 39, 'type' => 'fixed', 'active' => 'yes', 'name' => '页面权限关联', 'code' => 'page_link_auth', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 40, 'type' => 'fixed', 'active' => 'yes', 'name' => '自定义字段', 'code' => 'variable', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 41, 'type' => 'fixed', 'active' => 'yes', 'name' => '自定义字段值', 'code' => 'variable_value', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 42, 'type' => 'fixed', 'active' => 'yes', 'name' => '目录变量', 'code' => 'dir_variable', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 43, 'type' => 'fixed', 'active' => 'yes', 'name' => '视图', 'code' => 'view', 'icon' => 'icon-uniE6FB', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 44, 'type' => 'fixed', 'active' => 'yes', 'name' => '使用视图', 'code' => 'view_use', 'icon' => 'icon-uniE6FB', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 45, 'type' => 'fixed', 'active' => 'yes', 'name' => '水平关联', 'code' => 'horizontal', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 46, 'type' => 'fixed', 'active' => 'yes', 'name' => '水平关联配置', 'code' => 'horizontal_config', 'icon' => 'icon-uniEAB1', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 47, 'type' => 'fixed', 'active' => 'yes', 'name' => '权限控制', 'code' => 'auth_access', 'icon' => 'icon-uniF0C0', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 48, 'type' => 'fixed', 'active' => 'yes', 'name' => '权限分组', 'code' => 'auth_group', 'icon' => 'icon-uniF21D', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 49, 'type' => 'fixed', 'active' => 'yes', 'name' => '权限组节点', 'code' => 'group_node', 'icon' => 'icon-uniF21D', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 50, 'type' => 'fixed', 'active' => 'yes', 'name' => '权限节点', 'code' => 'auth_node', 'icon' => 'icon-uniE9F5', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 51, 'type' => 'fixed', 'active' => 'yes', 'name' => '审核关联', 'code' => 'review_link', 'icon' => 'icon-uniE9F5', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 52, 'type' => 'fixed', 'active' => 'yes', 'name' => '实体', 'code' => 'entity', 'icon' => 'icon-uniE9F5', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            ["id" => 53, 'type' => 'fixed', 'active' => 'yes', 'name' => '模块', 'code' => 'module', 'icon' => 'icon-uniE9F5', 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
            // 系统动态模块
            ["id" => 54, 'type' => 'entity', 'active' => 'yes', 'name' => '审核', 'code' => 'review', 'icon' => 'icon-uniF1B2', 'number' => 10, 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
//            ["id" => 51, 'type' => 'entity', 'active' => 'yes', 'name' => '集数', 'code' => 'episode', 'icon' => 'icon-uniEACF', 'number' => 20, 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
//            ["id" => 52, 'type' => 'entity', 'active' => 'yes', 'name' => '序列', 'code' => 'sequence', 'icon' => 'icon-small_shots', 'number' => 50, 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
//            ["id" => 53, 'type' => 'entity', 'active' => 'yes', 'name' => '镜头', 'code' => 'shot', 'icon' => 'icon-icon_shots', 'number' => 70, 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
//            ["id" => 54, 'type' => 'entity', 'active' => 'yes', 'name' => '前期制作', 'code' => 'pre_production', 'icon' => 'icon-uniF1E9', 'number' => 30, 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
//            ["id" => 55, 'type' => 'entity', 'active' => 'yes', 'name' => '资产', 'code' => 'asset', 'icon' => 'icon-uniF1B2', 'number' => 40, 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
//            ["id" => 56, 'type' => 'entity', 'active' => 'yes', 'name' => '资产分类', 'code' => 'asset_type', 'icon' => 'icon-uniF1B2', 'number' => 41, 'uuid' => Webpatser\Uuid\Uuid::generate()->string],
        ];

        $this->table('strack_module')->insert($rows)->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_module');
    }
}
