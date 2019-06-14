$(function(){

    $.ajax({
        type :'POST',
        url :DiagnosticsPHP['getServStatus'],
        data :{
            options_field:'default_settings'
        },
        success : function (data) {
            var Jdata = JSON.parse(data),ser_dom = '';
            Jdata.forEach(function (value) {
                ser_dom +=StaBaseDOM(value["status"],value["serv_name"]);
            });
            $("#Servsta").empty().append(ser_dom);
        }
    });

    /**
     * 状态Base DOM
     * @returns {string}
     */
    function StaBaseDOM(sta,serv) {
        var dsta = '';
        dsta +='<div class="server-sta-item aign-left '+StaCSSCK(sta)+'">'+
                    '<div class="server-item-name">'+
                        StaCheck(sta)+
                    '</div>'+
                    '<div class="server-item-sta">'+
                        ServNameCheck(serv)+
                    '</div>'+
                '</div>';
        return dsta;
    }
    
    function StaCSSCK(sta) {
        var sta_css = "";
        switch (sta){
            case "open":
                sta_css = "background-success";
                break;
            case "down":
                sta_css = "background-danger ";
                break;
        }
        return sta_css;
    }

    /**
     * 获得状态
     */
    function StaCheck(sta) {
        var sta_name = "";
        switch (sta){
            case "open":
                sta_name = DiagnosticsPHP['Status_OK'];
                break;
            case "down":
                sta_name = DiagnosticsPHP['Status_Lose'];
                break;
        }
        return sta_name;
    }

    /**
     * 获得服务名
     */
    function ServNameCheck(serv) {
        var serv_name = "";
        switch (serv){
            case "Email_Server":
                serv_name = DiagnosticsPHP['Server_Email'];
                break;
            case "Transcode_Server":
                serv_name = DiagnosticsPHP['Server_Transcode'];
                break;
            case "IM_Server":
                serv_name = DiagnosticsPHP['Server_IM'];
                break;
            case "WebSocket_Server":
                serv_name = DiagnosticsPHP['Server_WebSocket'];
                break;
            case "Oiio_Server":
                serv_name = DiagnosticsPHP['Server_OIIO'];
                break;
        }
        return serv_name;
    }
});