$(function(){
    obj = {
        //选择模块设置语言
        build_lang_package : function () {
            var rows = $('#datagrid_box').datagrid("getRows");
            var empty_row = true;
            rows.forEach(function (val, index) {
                Gcol_key.forEach(function (col) {
                    if(val[col].length === 0 ){
                        empty_row = false;
                    }
                });
            });
            if(empty_row){
                $.ajax({
                    type:'POST',
                    url: LanguagePHP['generateLanguagePackage'],
                    dataType: 'JSON',
                    contentType :'application/json',
                    data:JSON.stringify({
                        col_key : Gcol_key.join(","),
                        modules: rows
                    }),
                    beforeSend : function () {
                        $.messager.progress({ title:StrackPHP['Waiting'], msg:StrackPHP['loading']});
                    },
                    success : function (data) {
                        $.messager.progress("close");
                        if(parseInt(data['status']) === 200){
                            Strack.top_message({bg:'g',msg: data['message']});
                            $('#datagrid_box').datagrid("reload");
                        }else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }else {
                layer.msg(LanguagePHP["Lang_Fill_Null"], {icon: 2, time: 1200, anim: 6});
            }
        }
    };

    var Gcol_key = [];
    get_lang_list();

    /**
     * 获取语言包
     */
    function get_lang_list() {
        $.ajax({
            type:'POST',
            url: LanguagePHP['getLangList'],
            dataType: 'json',
            success : function (data) {
                var columns = [
                    {field: 'id', checkbox: true},
                    {field: 'name', title:StrackLang['Module'], align: 'center', width: 220}
                ];
                var col_key = [];
                var columns_config = {};
                data.forEach(function (val) {
                    col_key.push(val["id"]);
                    columns.push(grid_column(val));
                    columns_config[val["id"]] = {field_type: 'built_in', field_map: val["id"], field_value_map: val["id"], primary: 'id', module: 'language', table: 'Language'};
                });

                Gcol_key = col_key;
                build_datagrid(col_key, columns, columns_config);
            }
        });
    }

    /**
     * 表格列
     * @param val
     * @returns {{field: *, title: *, align: string, width: number}}
     */
    function grid_column(val) {
        return {field: val["id"], title: val["name"], align: 'center',width: 180, editor: {type: 'text'}};
    }

    /**
     * 生成表格数据
     * @param col_key
     * @param columns
     * @param columns_config
     */
    function build_datagrid(col_key, columns, columns_config) {
        $('#datagrid_box').datagrid({
            url: LanguagePHP['getLanguageModuleData'],
            height: Strack.panel_height('.admin-page-right',76),
            differhigh:true,
            rowheight:30,
            striped:true,
            singleSelect: true,
            cellUpdateMode: 'manual',
            adaptive:{
                dom:'#active-language',
                min_width:360,
                exth:0
            },
            queryParams: {
                col_key: col_key.join(",")
            },
            columnsFieldConfig: columns_config,
            columns: [columns],
            toolbar: '#tb',
            pagination: true,
            pageSize: 200,
            pageList: [200, 400],
            pageNumber: 1,
            pagePosition: 'bottom',
            remoteSort: false
        }).datagrid('enableCellEditing')
            .datagrid('disableCellSelecting')
            .datagrid('gotoCell',
                {
                    index: 0,
                    field: 'id'
                }
            ).datagrid('columnMoving');
    }
});