$(function () {
    var error_type = parseInt(PARSE_VAR["error_type"]);
    var $e_notce = $("#sys_error_notice");
    switch (error_type){
        case 101:
            $e_notce.html(ErrorPHP["User_Illegal_Number"]);
            break;
    }
});
