<extend name="tpl/Base/common.tpl"/>

<block name="head-title"><title>{$Think.lang.Cloud_Disk_Title}</title></block>

<block name="head-js">
    <if condition="$is_dev == '1' ">
        <script type="text/javascript" src="__JS__/src/home/cloud_disk.js"></script>
        <else/>
        <script type="text/javascript" src="__JS__/build/home/cloud_disk.min.js"></script>
    </if>
</block>
<block name="head-css">
    <script type="text/javascript">
        Strack.G.MenuName = "cloud_disk";
    </script>
</block>

<block name="main">
    <iframe src="{$cloud_disk_url}" class="page-iframe-base page-iframe-wh-100">
    </iframe>
</block>