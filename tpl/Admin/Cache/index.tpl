<extend name="tpl/Base/common_admin.tpl" />

<block name="head-title"><title>{$Think.lang.Cache_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/admin/admin_cache.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/admin/admin_cache.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        var CachePHP = {
            'getCacheStatistics'  : '{:U("Admin/Cache/getCacheStatistics")}',
            'clearSystemCache' : '{:U("Admin/Cache/clearSystemCache")}',
            'clearSystemLogsCache' : '{:U("Admin/Cache/clearSystemLogsCache")}',
            'clearUploadsTempCache' : '{:U("Admin/Cache/clearUploadsTempCache")}'
        };
        Strack.G.MenuName="cache";
    </script>
</block>

<block name="admin-main-header">
    {$Think.lang.Admin_Cache}
</block>

<block name="admin-main">
    <div id="active-cache" class="admin-content-dept">
        <div class="admin-full-wrap">
            <div class="admin-server-sta admin-cache-item">
                <div id="sys_disk" style="width:580px;"></div>
                <div class="admin-cache-title">
                    {$Think.lang.System_Disk_Total}：<span id="disk_total"></span> / {$Think.lang.System_Disk_Free}：<span id="disk_free"></span>
                </div>
            </div>
            <eq name="view_rules.clear_system_cache" value="yes">
                <div class="admin-full-title">
                    <label class="stcol-lg-1 control-label">
                        {$Think.lang.System_Cache_Size}
                    </label>
                </div>
                <div class="admin-server-sta admin-cache-item">
                    <a href="javascript:;" class="admin-clear-bnt" onclick="obj.clear_system_cache()">
                        {$Think.lang.ClearCache}
                        <span id="sys_cache"></span>
                    </a>
                </div>
            </eq>
            <eq name="view_rules.clear_system_logs_cache" value="yes">
                <div class="admin-full-title">
                    <label class="stcol-lg-1 control-label">
                        {$Think.lang.Logs_Cache_Size}
                    </label>
                </div>
                <div class="admin-server-sta admin-cache-item">
                    <a href="javascript:;" class="admin-clear-bnt" onclick="obj.clear_system_logs_cache()">
                        {$Think.lang.ClearLogs}
                        <span id="logs_cache"></span>
                    </a>
                </div>
            </eq>
            <eq name="view_rules.clear_uploads_temp_cache" value="yes">
                <div class="admin-full-title">
                    <label class="stcol-lg-1 control-label">{$Think.lang.Upload_Cache_Size}</label>
                </div>
                <div class="admin-server-sta admin-cache-item">
                    <a href="javascript:;" class="admin-clear-bnt" onclick="obj.clear_upload_temp_cache()">
                        {$Think.lang.ClearCache}
                        <span id="upload_cache"></span>
                    </a>
                </div>
            </eq>
        </div>
    </div>
</block>