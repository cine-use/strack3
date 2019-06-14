$(function(){
    obj={
        // 新增ldap
        ldap_add: function (i) {
            var formData = Strack.validate_form('add_ldap');
            if(formData['status'] === 200){
                formData['data']["domain_controllers"] = str_split_newline(formData['data']["domain_controllers"]);
                formData['data']["dn_whitelist"] = str_split_newline(formData['data']["dn_whitelist"]);
                if(!formData['data']["port"]){
                    formData['data']["port"] = 389;
                }
                $.ajax({
                    type : 'POST',
                    url : LdapPHP['addLdap'],
                    data : JSON.stringify(formData['data']),
                    dataType : 'json',
                    contentType: "application/json",
                    beforeSend : function () {
                        $.messager.progress({ title:StrackPHP['Waiting'], msg:StrackPHP['loading']});
                    },
                    success : function (data) {
                        $.messager.progress('close');
                        if(parseInt(data['status']) === 200){
                            obj.ldap_reset();
                            Strack.top_message({bg:'g',msg: data['message']});
                        }else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }
        },
        // 修改域ldap信息
        ldap_modify: function () {
            var rows = $('#datagrid_box').datagrid('getSelections');
            if(rows.length <1){
                layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
            }else if(rows.length > 1){
                layer.msg(StrackLang['Only_Choose_One'], {icon: 2, time: 1200, anim: 6});
            }else{
                modify_ldap_dialog(rows[0], 'datagrid_box');
            }
        },
        ldap_update:function(){
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', LdapPHP['modifyLdap'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        Strack.dialog_cancel();
                        Strack.top_message({bg:'g',msg: data['message']});
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            },{
                extra: function (data) {
                    // 处理数据
                    data["domain_controllers"] = str_split_newline(data["domain_controllers"]);
                    data["dn_whitelist"] = str_split_newline(data["dn_whitelist"]);
                    if(!data["port"]){
                        data["port"] = 389;
                    }
                    return data;
                }
            });
        },
        // 删除域ldap
        ldap_delete: function () {
            Strack.ajax_grid_delete('datagrid_box', 'id', StrackLang['Delete_Ldap_Notice'], LdapPHP['deleteLdap'], param);
        },
        ldap_reset:function(){
            $('#datagrid_box').datagrid('reload');
        }
    };

    Strack.init_open_switch({
        dom: '#ldap_ssl,#ldap_tsl',
        value: 0,
        onText: StrackLang['Switch_ON'],
        offText: StrackLang['Switch_OFF'],
        width: 100
    });

    var param = Strack.generate_hidden_param();

    load_ldap_data();

    /**
     * 按换行符切割
     * @param input_str
     */
    function str_split_newline(input_str) {
        return input_str.split(/[\n]/);
    }

    /**
     * 加载域数据表格
     */
    function load_ldap_data() {
        $('#datagrid_box').datagrid({
            url: LdapPHP['getLdapGridData'],
            rownumbers: true,
            nowrap: true,
            height: Strack.panel_height('.admin-dept-right',0),
            DragSelect:true,
            adaptive:{
                dom:'.admin-dept-right',
                min_width:1004,
                exth:0
            },
            frozenColumns:[[
                {field: 'id', checkbox:true}
            ]],
            columns: [[
                {field: 'ldap_id', title: StrackLang['ID'], align: 'center', width: 80,frozen:"frozen",findex:0,
                    formatter: function(value,row,index) {
                        return row["id"];
                    }
                },
                {field: 'name', title: StrackLang['Ldap_Name'], align: 'center', width: 180},
                {field: 'domain_controllers', title: StrackLang['Ldap_Server_Address'], align: 'center', width: 320,
                    formatter: function(value,row,index) {
                       return value.join(" ; ");
                    }
                },
                {field: 'base_dn', title: StrackLang['Ldap_Base_DN'], align: 'center', width: 160},
                {field: 'admin_username', title: StrackLang['Ldap_Admin_Name'], align: 'center', width: 140},
                {field: 'admin_password', title: StrackLang['Ldap_Admin_Password'], align: 'center', width: 140},
                {field: 'port', title: StrackLang['Ldap_Port'], align: 'center', width: 120},
                {field: 'ssl', title: StrackLang['Ldap_Open_Ssl'], align: 'center', width: 90,
                    formatter: function(value,row,index) {
                        return parseInt(value) === 0? "off": "on";
                    }
                },
                {field: 'tsl', title: StrackLang['Ldap_Open_Tls'], align: 'center', width: 90,
                    formatter: function(value,row,index) {
                        return parseInt(value) === 0? "off": "on";
                    }
                },
                {field: 'dn_whitelist', title: StrackLang['Ldap_DN_Whitelist'], align: 'center', width: 480,
                    formatter: function(value,row,index) {
                        return value.join(" ; ");
                    }
                }
            ]],
            toolbar: '#tb',
            pagination: true,
            pageSize: 100,
            pageList: [100, 200],
            pageNumber: 1,
            pagePosition: 'bottom',
            remoteSort: false,
            onDblClickRow: function(index,row){
                $(this).datagrid('selectRow',index);
                modify_ldap_dialog(row, 'datagrid_box');
            }
        });
    }


    /**
     * 编辑状态
     * @param row
     * @param id
     */
    function modify_ldap_dialog(row, id) {
        Strack.open_dialog('dialog',{
            title: StrackLang['Modify_Ldap_Title'],
            width: 490,
            height: 460,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mldap_id',type:'hidden',name:'id',valid:1,value:row['id']}
                ],
                items:[
                    {case:1,id:'Mldap_name',type:'text',lang:StrackLang['Ldap_Name'],name:'name',valid:'1,128',value:row['name']},
                    {case:7,id:'Mdomain_controllers',type:'text',lang:StrackLang['Ldap_Server_Address'],name:'domain_controllers',valid:'1',value:(row['domain_controllers']).join("\n")},
                    {case:1,id:'Mbase_dn',type:'text',lang:StrackLang['Ldap_Base_DN'],name:'base_dn',valid:'1,255',value:row['base_dn']},
                    {case:1,id:'Madmin_username',type:'text',lang:StrackLang['Ldap_Admin_Name'],name:'admin_username',valid:'1,255',value:row['admin_username']},
                    {case:1,id:'Madmin_password',type:'text',lang:StrackLang['Ldap_Admin_Password'],name:'admin_password',valid:'1,255',value:row['admin_password']},
                    {case:1,id:'Mport',type:'text',lang:StrackLang['Ldap_Port'],name:'port',valid:'',value:row['port']},
                    {case:2,id:'Mldap_ssl',lang:StrackLang['Ldap_Open_Ssl'],name:'ssl',valid:''},
                    {case:2,id:'Mldap_tsl',lang:StrackLang['Ldap_Open_Tls'],name:'tsl',valid:''},
                    {case:7,id:'Mdn_whitelist',type:'text',lang:StrackLang['Ldap_DN_Whitelist'],name:'dn_whitelist',valid:'',value:(row['dn_whitelist']).join("\n")}
                ],
                footer:[
                    {obj:'ldap_update',type:1,title:StrackLang['Update']},
                    {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                ]
            }),
            inits:function(){
                Strack.init_open_switch({
                    dom: '#Mldap_ssl',
                    value: row['ssl'],
                    onText: StrackLang['Switch_ON'],
                    offText: StrackLang['Switch_OFF'],
                    width: 100
                });
                Strack.init_open_switch({
                    dom: '#Mldap_tsl',
                    value: row['tsl'],
                    onText: StrackLang['Switch_ON'],
                    offText: StrackLang['Switch_OFF'],
                    width: 100
                });
            },
            close:function(){
                $('#'+id).datagrid('reload');
            }
        });
    }
});