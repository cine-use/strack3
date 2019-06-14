$(function(){
    obj = {
        modify_options: function () {
           var direct_jump=Strack.get_switch_val('#direct_jump_player');
            $.ajax({
                type :'POST',
                url :ReviewPHP['UPOPReview'],
                data :{
                    direct_jump:direct_jump
                },
                beforeSend:function(){
                    $.messager.progress({ title:StrackPHP['Waiting'], msg:StrackPHP['loading']});
                },
                success:function(data){
                    $.messager.progress('close');
                    Strack.top_message({bg:'g',msg:ReviewPHP['Review_Settings_Save_SC']});
                }
            });
        }
    };



    //AJAX填充数据
    $.ajax({
        type:'POST',
        url:ReviewPHP['getReviewOptions'],
        data :{
            options_field:'review_settings'
        },
        dataType:"json",
        success:function(data){
            Strack.init_open_switch({
                dom: '#direct_jump_player',
                value: data["direct_jump"],
                onText: StrackLang['Switch_ON'],
                offText: StrackLang['Switch_OFF'],
                width: 100
            });
        }
    });
});