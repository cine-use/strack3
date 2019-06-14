$(function () {
    obj = {
        schema_add : function () {
            Strack.open_dialog('dialog',{
                title: StrackLang['Add_Schema'],
                width: 480,
                height: 350,
                content: Strack.dialog_dom({
                    type:'normal',
                    items:[
                        {case:1,id:'Nname',lang:StrackLang['Name'],name:'name',valid:'1,128',value:""},
                        {case:1,id:'Ncode',lang:StrackLang['Code'],name:'code',valid:'1,128',value:""},
                        {case:2,id:'Ntype',lang:StrackLang['Type'],name:'type',valid:'1',value:""},
                        {case:2,id:'Nschema',lang:StrackLang['Copy_Schema'],name:'id',valid:'',value:""}
                    ],
                    footer:[
                        {obj:'schema_add_submit',type:1,title:StrackLang['Submit']},
                        {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                    ]
                }),
                inits: function () {
                    Strack.combobox_widget('#Ntype', {
                        url: SchemaPHP["getSchemaTypeCombobox"],
                        valueField: 'id',
                        textField: 'name'
                    });

                    Strack.combobox_widget('#Nschema', {
                        url: SchemaPHP["getSchemaCombobox"],
                        valueField: 'id',
                        textField: 'name'
                    });
                },
                close:function(){
                    get_schema_list();
                }
            });
        },
        schema_add_submit: function () {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', SchemaPHP['addSchema'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        Strack.dialog_cancel();
                        obj.schema_right_hide();
                        Strack.top_message({bg:'g',msg: data['message']});
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        },
        schema_modify: function () {
           var schema_id = $("#hide_schema_id").val(),
               name = $("#hide_schema_name").val(),
               code = $("#hide_schema_code").val();
            Strack.open_dialog('dialog',{
                title: StrackLang['Modify_Schema'],
                width: 480,
                height: 240,
                content: Strack.dialog_dom({
                    type:'normal',
                    hidden:[
                        {case:101,id:'Minfo_id',type:'hidden',name:'id',valid:1,value:schema_id}
                    ],
                    items:[
                        {case:1,id:'name',lang:StrackLang['Name'],name:'name',valid:'1,128',value:name},
                        {case:1,id:'code',lang:StrackLang['Code'],name:'code',valid:'1,128',value:code}
                    ],
                    footer:[
                        {obj:'schema_modify_submit',type:1,title:StrackLang['Update']},
                        {obj:'dialog_cancel',type:8,title:StrackLang['Cancel']}
                    ]
                }),
                close:function(){
                    get_schema_list();
                }
            });
        },
        schema_modify_submit: function () {
            Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', SchemaPHP['modifySchema'],{
                back:function(data){
                    if(parseInt(data['status']) === 200){
                        Strack.dialog_cancel();
                        Strack.top_message({bg:'g',msg: data['message']});
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            }, {
                extra: function (param) {
                    $("#hide_schema_name").val(param["name"]);
                    $("#hide_schema_code").val(param["code"]);
                    return param;
                }
            });
        },
        schema_delete: function () {
            var schema_id = $("#hide_schema_id").val();
            if(schema_id > 0){
                //删除数据库
                $.messager.confirm(StrackLang['Confirmation_Box'], StrackLang['Delete_Schema_Notice'], function (flag) {
                    if (flag) {
                        $.ajax({
                            type:'POST',
                            url: SchemaPHP['deleteSchema'],
                            dataType: 'json',
                            data: {
                                'schema_id': schema_id
                            },
                            success : function (data) {
                                if(parseInt(data['status']) === 200){
                                    get_schema_list();
                                    obj.schema_right_hide();
                                    Strack.top_message({bg:'g',msg: data['message']});
                                }else {
                                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                                }
                            }
                        });
                    }
                });
            }else {
                layer.msg(StrackPHP['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
            }
        },
        select_schema: function (i) {

            obj.schema_right_show();

            var schema_id = $(i).attr("data-schemaid"),
                name = $(i).attr("data-name"),
                code = $(i).attr("data-code");

            $("#hide_schema_id").val(schema_id);
            $("#hide_schema_name").val(name);
            $("#hide_schema_code").val(code);

            $('.templates-items').removeClass('templates-active');
            $(i).parent().addClass('templates-active');

            get_module_list(schema_id);
        },
        schema_save: function () {
            var schema_id = $("#hide_schema_id").val();
            var data = toolkit.getGraph().vertices;
            var schema_data = [];
            var edges;
            var exist_schema = [];
            data.forEach(function (val) {
                edges = val.getEdges();
                edges.forEach(function (eitem) {
                    if(eitem.source.id === val.data.id){
                        schema_data.push({
                            schema_id : schema_id,
                            module_id : val.data.module_id,
                            type : eitem.data.label,
                            src_module_id : val.data.module_id,
                            dst_module_id : eitem.target.data.module_id,
                            link_id : 1,
                            node_config : {
                                node_data : {
                                    source : val.data,
                                    target : eitem.target.data
                                },
                                edges : {
                                    source : eitem.source.id,
                                    target : eitem.target.id,
                                    data : {
                                        label: eitem.data.label,
                                        type: eitem.data.type
                                    }
                                }
                            }
                        });

                        exist_schema.push(val.data.module_id);
                        exist_schema.push(eitem.target.data.module_id);
                    }else if(edges.length<=1 && $.inArray(val.data.module_id,exist_schema)<0){
                        schema_data.push({
                            schema_id : schema_id,
                            module_id : val.data.module_id,
                            type : eitem.data.label,
                            src_module_id : val.data.module_id,
                            dst_module_id : eitem.target.data.module_id,
                            link_id : 1,
                            node_config : {
                                node_data: {
                                    source: val.data,
                                    target: eitem.target.data
                                },
                                edges: {}
                            }
                        });
                    }
                });
            });

            if(schema_data.length>0){
                //提交数据库保存
                $.ajax({
                    type:'POST',
                    url: SchemaPHP['saveModuleRelation'],
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        schema_id : schema_id,
                        schema_data : schema_data
                    }),
                    success : function (data) {
                        Strack.top_message({bg:'g',msg: data['message']});
                    }
                });
            }else {
                layer.msg(StrackLang['Please_Select_Module'], {icon: 7, time: 1200, anim: 6});
            }
        },
        //过滤Schema
        schema_filter: function () {
            var search_val = $("#search_val").val(),filter = '';
            if(search_val.length>0){
                filter = search_val;
            }
            get_schema_list(filter);
        },
        //重置Schema
        schema_right_hide: function () {
            $(".structure-m-list").hide();
            $(".structure-m-wrap").hide();
            $(".temp-setlist-no").show();
            $(".templates-items").removeClass('templates-active');
        },
        //过滤Schema
        schema_right_show: function () {
            $(".structure-m-list").show();
            $(".structure-m-wrap").show();
            $(".temp-setlist-no").hide();
        }
    };

    var toolkit;
    var jsplumb_has_load = false;

    get_schema_list();

    /**
     * 键盘事件
     */
    Strack.listen_keyboard_event(function (e, data) {
        if(data["code"] === "enter"){
            // 按回车键搜索
            if($("#search_val").is(':focus')){
                // 搜索数据结构
                e.preventDefault();
                obj.schema_filter(Strack.get_obj_by_id("search_schema_bnt"));
            }
        }
    });

    /**
     * 加载结构列表
     * @param filter_val
     */
    function get_schema_list(filter_val) {
        $.ajax({
            type:'POST',
            url: SchemaPHP['getSchemaList'],
            dataType: 'json',
            data:{
                filter : filter_val
            },
            beforeSend : function () {
                $('#schema_list').empty().append(Strack.loading_dom('null'));
            },
            success : function (data) {
                var lis_dom ='';
                var $schema_list = $('#schema_list');
                var schema_id = $('#hide_schema_id').val();

                data.forEach(function (val) {
                    lis_dom += schema_list(val);
                });

                if(lis_dom){
                    $("#schema_null_notice").remove();
                    $schema_list.append(lis_dom);
                }else {
                    if($("#schema_null_notice").length === 0){
                        $schema_list.before('<div id="schema_null_notice" class="datagrid-empty-no">'+StrackLang["Datagird_No_Data"]+'</div>');
                    }
                }
                if(schema_id > 0){
                    $("#sinfo_id_"+schema_id).addClass("templates-active");
                }

                $('#st-load').remove();
            }
        });
    }

    /**
     * 结构 list DOM
     * @param schemaData
     * @returns {string}
     */
    function schema_list(schemaData){
        var dom ='';
        dom +='<li id="sinfo_id_'+schemaData["id"]+'" class="templates-items" >'+
            '<a href="javascript:;" class="list-item" onclick="obj.select_schema(this);" data-schemaid="'+schemaData["id"]+'" data-name="'+schemaData["name"]+'" data-code="'+schemaData["code"]+'">'+
            schemaData["name"]+
            '</a>'+
            '</li>';
        return dom;
    }


    /**
     * 加载模块列表
     */
    function get_module_list(schema_id) {
        $.ajax({
            type:'POST',
            url: SchemaPHP['getSchemaModuleList'],
            dataType: 'json',
            data: {
                schema_id : schema_id
            },
            beforeSend : function () {
                $("#module_wrap").append(Strack.loading_dom('white', "", "module"));
            },
            success : function (data) {
                var mlist = '',
                    type_list = ['entity','fixed'];

                //模块列表
                type_list.forEach(function (type) {
                    mlist += '<li class="module-items-title">'+type+'</li>';
                    if(data["module_list"][type]){
                        data["module_list"][type].forEach(function (val) {
                            mlist += module_list_dom(val);
                        });
                    }
                });

                $("#module_list").empty().append(mlist);
                $("#st-load_module").remove();

                //模块结构图表
                if(jsplumb_has_load){
                    jsPlumb.empty("schema_graph");
                    toolkit = null;
                }

                load_jsPlumb(data["schema_list"]);
            }
        });
    }


    /**
     * jsPlumb节点图DOM
     * @returns {string}
     */
    function init_jsPlumb_dom() {
        var dom = '';
        dom += '<div class="jtk-demo-canvas">'+
            '<div class="controls">'+
            '<i class="fa icon-uniF047 selected-mode" mode="pan" title="Pan Mode"></i>'+
            '<i class="fa icon-uniE684" mode="select" title="Select Mode"></i>'+
            '<i class="fa  icon-uniE9AD" reset title="Zoom To Fit"></i>'+
            '</div>'+
            '<div class="miniview"></div>'+
            '</div>';
        return dom;
    }

    /**
     * 初始化jsPlumb节点图
     * @param data
     */
    function load_jsPlumb(data) {



        $('#schema_graph').append(init_jsPlumb_dom());

        /* jsPlumb 初始化*/
        jsPlumb.ready(function () {

            // ------------------------ toolkit setup ------------------------------------

            // This function is what the toolkit will use to get an ID from a node.
            var idFunction = function (n) {
                return n.id;
            };

            // This function is what the toolkit will use to get the associated type from a node.
            var typeFunction = function (n) {
                return n.type;
            };

            var mainElement = document.querySelector("#schema_graph"),
                canvasElement = mainElement.querySelector(".jtk-demo-canvas"),
                miniviewElement = mainElement.querySelector(".miniview"),
                nodePalette = document.querySelector("#module_list"),
                controls = mainElement.querySelector(".controls");

            toolkit = jsPlumbToolkit.newInstance({
                idFunction: idFunction,
                typeFunction: typeFunction,
                nodeFactory: function (node, data, callback) {

                    data.type = 'module';
                    data.text = node.module_name;
                    data.module_id = node.module_id;
                    data.module_code = node.module_code;
                    data.module_type = node.module_type;
                    data.id = jsPlumbToolkitUtil.uuid();

                    callback(data);
                },
                beforeStartConnect:function(node, edgeType) {
                    // limit edges from start node to 1. if any other type of node, return
                    return (node.data.type === "start" && node.getEdges().length > 0) ? false : { label:"..." };
                }
            });

            var _editLabel = function(edge, deleteOnCancel) {

                if(edge.source.id !== edge.target.id){
                    Strack.build_dialog('dialog');
                    var edge_label = '';
                    if($.inArray(edge.data.label, ['has_one', 'belong_to', 'has_many', 'many_to_many'])>=0){
                        edge_label = edge.data.label;
                    }
                    $('#dialog').dialog({
                        title: StrackLang["Schema_Link_Type"],
                        width: 460,
                        height: 220,
                        closed: false,
                        cache: false,
                        modal: true,
                        closable: false,
                        content: Strack.dialog_dom({
                            type: 'normal',
                            items: [
                                {case: 1, id: 'Mschema_link_type', type: 'text', lang: StrackLang['Type'], name: 'link_type', valid: 1, value: edge_label}
                            ],
                            footer: []
                        }),
                        onOpen: function () {
                            Strack.combobox_widget('#Mschema_link_type', {
                                url: SchemaPHP["getSchemaConnectType"],
                                valueField: 'id',
                                textField: 'name'
                            });
                        },
                        onClose: function () {
                            $(this).dialog('destroy');
                        },
                        buttons:[{
                            text:StrackLang['Save'],
                            handler:function(){
                                var label = $("#Mschema_link_type").combobox("getValue");
                                if(label.length>0){
                                    toolkit.updateEdge(edge, { label:label || "" });
                                    Strack.dialog_cancel();
                                }else {
                                    layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
                                }
                            }
                        },{
                            text:StrackLang['Delete'],
                            handler:function(){
                                Strack.dialog_cancel();
                                toolkit.removeEdge(edge);
                            }
                        },{
                            text:StrackLang['Cancel'],
                            handler:function(){
                                var label = $("#Mschema_link_type").combobox("getValue");
                                if(label.length>0){
                                    toolkit.updateEdge(edge, { label:label || "" });
                                }else {
                                    toolkit.removeEdge(edge);
                                }
                                Strack.dialog_cancel();
                            }
                        }]
                    });
                }else {
                    toolkit.removeEdge(edge);
                }
            };

            var renderer = window.renderer = toolkit.render({
                container: canvasElement,
                view: {
                    nodes: {
                        "selectable": {
                            events: {
                                tap: function (params) {
                                    toolkit.toggleSelection(params.node);
                                }
                            }
                        },
                        "module": {
                            parent: "selectable",
                            template: "tmplModule"
                        }
                    },
                    // There are two edge types defined - 'yes' and 'no', sharing a common
                    // parent.
                    edges: {
                        "default": {
                            anchor:"AutoDefault",
                            endpoint:"Blank",
                            connector: ["Flowchart", { cornerRadius: 5 } ],
                            paintStyle: { strokeWidth: 2, stroke: "#f76258", outlineWidth: 3, outlineStroke: "transparent" },	//	paint style for this edge type.
                            hoverPaintStyle: { strokeWidth: 2, stroke: "rgb(67,67,67)" }, // hover paint style for this edge type.
                            events: {
                                "dblclick": function (params) {
                                    jsPlumbToolkit.Dialogs.show({
                                        id: "dlgConfirm",
                                        data: {
                                            msg: "Delete Edge"
                                        },
                                        onOK: function () {
                                            toolkit.removeEdge(params.edge);
                                        }
                                    });
                                }
                            },
                            overlays: [
                                [ "Arrow", { location: 1, width: 10, length: 10 }],
                                [ "Arrow", { location: 0.3, width: 10, length: 10 }]
                            ]
                        },
                        "connection":{
                            parent:"default",
                            overlays:[
                                [
                                    "Label", {
                                    label: "${label}",
                                    events:{
                                        click:function(params) {
                                            _editLabel(params.edge);
                                        }
                                    }
                                }
                                ]
                            ]
                        }
                    },
                    ports: {
                        "start": {
                            edgeType: "default"
                        },
                        "source": {
                            maxConnections: -1,
                            edgeType: "connection"
                        },
                        "target": {
                            maxConnections: -1,
                            isTarget: true,
                            dropOptions: {
                                hoverClass: "connection-drop"
                            }
                        }
                    }
                },
                // Layout the nodes using an absolute layout
                layout: {
                    type: "Absolute"
                },
                events: {
                    canvasClick: function (e) {
                        toolkit.clearSelection();
                    },
                    edgeAdded:function(params) {
                        if (params.addedByMouse) {
                            _editLabel(params.edge, true);
                        }
                    },
                    nodeDropped:function(info) {
                        console.log("node ", info.source.id, "dropped on ", info.target.id);
                    }
                },
                miniview: {
                    container: miniviewElement
                },
                lassoInvert:true,
                elementsDroppable:true,
                consumeRightClick: false,
                dragOptions: {
                    filter: ".jtk-draw-handle, .node-action, .node-action i",
                    magnetize:true
                },
                dropManager:true
            });


            //加载数据
            toolkit.load({
                data : data
            });


            // listener for mode change on renderer.
            renderer.bind("modeChanged", function (mode) {
                jsPlumb.removeClass(controls.querySelectorAll("[mode]"), "selected-mode");
                jsPlumb.addClass(controls.querySelectorAll("[mode='" + mode + "']"), "selected-mode");
            });

            // pan mode/select mode
            jsPlumb.on(controls, "tap", "[mode]", function () {
                renderer.setMode(this.getAttribute("mode"));
            });

            // on home button click, zoom content to fit.
            jsPlumb.on(controls, "tap", "[reset]", function () {
                toolkit.clearSelection();
                renderer.zoomToFit();
            });

            // configure Drawing tools.
            new jsPlumbToolkit.DrawingTools({
                renderer: renderer
            });

            // delete node
            jsPlumb.on(canvasElement, "tap", ".node-delete", function () {
                var info = renderer.getObjectInfo(this);
                toolkit.removeNode(info.obj);
            });

            renderer.registerDroppableNodes({
                droppables: nodePalette.querySelectorAll("li.nation-items"),
                dragOptions: {
                    zIndex: 50000,
                    cursor: "move",
                    clone: true
                },
                typeExtractor: function (el) {
                    return {
                        'module_id' : el.getAttribute("data-moduleid"),
                        'module_code' :el.getAttribute("data-modulecode"),
                        'module_type':el.getAttribute("data-moduletype"),
                        'module_icon' : el.getAttribute("data-icon"),
                        'module_name' :el.getAttribute("data-name")
                    }
                },
                dataGenerator: function (type) {
                    return {
                        w:120,
                        h:80
                    };
                }
            });

        });
        jsplumb_has_load = true;
    }

    /**
     * 模块列表DOM
     * @param data
     * @returns {string}
     */
    function module_list_dom(data){
        var list = '';
        list += '<li id="module_'+data["id"]+'" class="nation-items" data-moduleid ="'+data["id"]+'" data-modulecode ="'+data["code"]+'" data-moduletype="'+data["type"]+'" data-icon ="'+data["icon"]+'" data-name ="'+data["name"]+'">'+
                    '<div class="nation-items-wrap min">'+
                        '<div class="aign-left">' +
                            '<i class="'+data["icon"]+' icon-left"></i>'+
                            '<span>'+data["name"]+'</span>'+
                        '</div>'+
                    '</div>'+
                '</li>';
        return list;
    }
});