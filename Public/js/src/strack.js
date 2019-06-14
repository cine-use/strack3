var Strack = {
    //设置Cookie
    set_cookie: function (name, value, duration) {
        Strack.remove_cookie(name);
        var d = new Date();
        if (duration <= 0)
            duration = 1;
        d.setTime(d.getTime() + 1000 * 60 * 60 * 24 * duration);
        document.cookie = name + "=" + encodeURI(value) + "; expires=" + d.toGMTString() + ";path=/";
    },
    //获取Cookie
    get_cookie: function (name) {
        var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
        if (arr != null)
            return decodeURIComponent(arr[2]);
        return "";
    },
    //移除Cookie
    remove_cookie: function (name) {
        var d = new Date();
        if (Strack.get_cookie(name) !== "") {
            d.setTime(d.getTime() - (86400 * 1000 * 1));
            document.cookie = name + "=;expires=" + d.toGMTString();
        }
    },
    is_string: function(str){
        return (typeof str=='string')&&str.constructor==String;
    },
    deep_copy: function  (obj) {
        if (!Strack.isObject(obj)) {
            throw new Error('obj 不是一个对象！')
        }
        var isArray = Array.isArray(obj)
        var cloneObj = isArray ? [] : {}
        for (var key in obj) {
            cloneObj[key] = Strack.isObject(obj[key]) ? Strack.deep_copy(obj[key]) : obj[key]
        }
        return cloneObj
    },
    // 判断是否为对象
    isObject :function (o) {
        return (typeof o === 'object' || typeof o === 'function') && o !== null
    },
    //sessionStorage存入 修改
    save_storage: function (key, val) {
        sessionStorage.setItem(key, val);
    },
    //sessionStorage读取
    read_storage: function (key) {
        return sessionStorage.getItem(key);
    },
    //sessionStorage删除
    delete_storage: function (key) {
        sessionStorage.removeItem(key);
    },
    //sessionStorage清除所有
    clear_all_storage: function () {
        sessionStorage.clear();
    },
    // 获取页面唯一身份ID
    get_page_uuid: function()
    {
        var $body = $(document.body);
        var param = {
            identity: $body.data("identity"),
            created: $body.data("created")
        };
        param["uid"] = param.identity + '_' + param.created;
        param["group"] = "message";
        return param;
    },
    // 字符串转换为DOM对象
    parse_dom : function(txt)
    {
        try
        {
            var parser=new DOMParser();
            var xmlDoc = parser.parseFromString(txt, "text/xml");
            return(xmlDoc);
        }
        catch(e) {alert(e.message)}
        return(null);
    },
    /**
     * Get the index of array item, return -1 when the item is not found.
     */
    indexOfArray: function(a, o, id){
        for(var i=0,len=a.length; i<len; i++){
            if (id == undefined){
                if (a[i] == o){return i;}
            } else {
                if (a[i][o] == id){return i;}
            }
        }
        return -1;
    },
    //动态加载CSS 和 JS
    css: function (headid, path) {
        if (!path || path.length === 0) {
            throw new Error('CSS "path" is required !');
        }
        var head = document.getElementById(headid);
        $(head).append("<link type='text/css' rel='stylesheet' href='" + path + "' />");
    },
    js: function (headid, path) {
        if (!path || path.length === 0) {
            throw new Error('JS "path" is required !');
        }
        var head = document.getElementById(headid);
        $(head).append("<script type='text/javascript' language='javascript' src='" + path + "'/></script>");
    },
    //编码
    html_encode: function (str) {
        return $('<div/>').text(str).html();
    },
    //解码
    html_decode: function (str) {
        return $('<div/>').html(str).text();
    },
    // 原生获取ID DOM对象
    get_obj_by_id: function(id)
    {
        return document.getElementById(id);
    },
    //数组操作方法
    array_distinct: function (a, b) {
        var c = [],
            tmp = a.concat(b),
            o = {};
        for (var i = 0; i < tmp.length; i++) {
            (tmp[i] in o) ? o[tmp[i]]++ : o[tmp[i]] = 1;
        }
        for (x in o) if (o[x] == 1) {
            c.push(x)
        }
        return c;
    },
    //数组分组方法
    array_group: function (data, gname) {
        return data.reduce(function (pre, current, index) {
            pre[current[gname]] = pre[current[gname]] || [];
            pre[current[gname]].push(current);
            return pre
        }, {});
    },
    //获取基本路径
    get_base_path: function (path) {
        var basearr = path.split("/");
        basearr.pop();
        return basearr.join('/');
    },
    //去除空格
    trim_spaces: function (str, is_global) {
        var result = str.replace(/(^\s+)|(\s+$)/g, "");
        if (is_global.toLowerCase() === "g") {
            result = result.replace(/\s/g, "");
        }
        return result;
    },
    // 字符串首字母大写
    string_ucwords: function(string)
    {
        if(string.indexOf("_") != -1){
            var str_arr = string.split("_");
            var str_format = [];
            str_arr.forEach(function (val) {
                str_format.push(val.substring(0,1).toUpperCase()+val.substring(1));
            });
            return str_format.join("_");
        }else {
            return string.substring(0,1).toUpperCase()+string.substring(1);
        }
    },
    //数字补零
    prefix_integer: function (num, n) {
        return (Array(n).join(0) + num).slice(-n);
    },
    //把视频duration转化为帧数
    time_to_frame: function (duration, rate) {
        var f_rate = rate ? rate : Strack.G.FrameRates.film;
        var frame = duration * f_rate;
        return Math.round(frame);
    },
    //替换textarea中空格
    replace_textarea: function (str) {
        if (str) {
            var reg = new RegExp("\r\n", "g");
            str = str.replace(reg, "<br>");
        }
        return str;
    },
    //还原textarea中空格
    revert_textarea: function (str) {
        var reg = new RegExp("＜br＞", "g");
        var reg1 = new RegExp("＜p＞", "g");

        str = str.replace(reg, "\r\n");
        str = str.replace(reg1, " ");

        return str;
    },
    //去除HTML tag
    replace_html_tag: function (str) {
        str = str.replace(/<\/?[^>]*>/g, '');
        return str;
    },
    //去除url后缀html
    remove_html_ext: function (url) {
        return url.replace('.html', '');
    },
    // 16进制颜色转为RGB格式
    hex_to_rgb: function (c, a) {
        var lc = '#' + c,
            reg = /^#([0-9a-fA-f]{3}|[0-9a-fA-f]{6})$/;
        var sColor = lc.toLowerCase();
        if (sColor && reg.test(sColor)) {
            if (sColor.length === 4) {
                var sColorNew = "#";
                for (var i = 1; i < 4; i += 1) {
                    sColorNew += sColor.slice(i, i + 1).concat(sColor.slice(i, i + 1));
                }
                sColor = sColorNew;
            }
            //处理六位的颜色值
            var sColorChange = [];
            for (var j = 1; j < 7; j += 2) {
                sColorChange.push(parseInt("0x" + sColor.slice(j, j + 2)));
            }
            return "RGBA(" + sColorChange.join(",") + "," + a + ")";
        } else {
            return sColor;
        }
    },
    //当前时间戳
    current_time: function () {
        return Date.parse(new Date()) / 1000;
    },
    //删除当前父级
    remove_parent: function (i) {
        $(i).parent().remove();
    },
    //格式化日期
    date_format: function (date, format) {
        var o = {
            "M+": date.getMonth() + 1, //month
            "d+": date.getDate(), //day
            "h+": date.getHours(), //hour
            "m+": date.getMinutes(), //minute
            "s+": date.getSeconds(), //second
            "q+": Math.floor((date.getMonth() + 3) / 3), //quarter
            "S": date.getMilliseconds() //millisecond
        };
        if (/(y+)/.test(format)) format = format.replace(RegExp.$1,
            (date.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o) if (new RegExp("(" + k + ")").test(format))
            format = format.replace(RegExp.$1,
                RegExp.$1.length == 1 ? o[k] :
                    ("00" + o[k]).substr(("" + o[k]).length));
        return format;
    },
    /**
     If the date is:
     Today - show as "Today";
     Tomorrow - show as "Tomorrow"
     Yesterday - show as "Yesterday"
     Else - show in "Month - Day format"
     */
    MDFormat: function (MMDD) {
        MMDD = new Date(MMDD);
        var NYear = (new Date()).getFullYear(),
            cyear = MMDD.getFullYear(),
            fctime = Strack.date_format(MMDD, "yyyy-M-d"),
            strDate = "";
        var months = [StrackLang["January"], StrackLang["February"], StrackLang["March"], StrackLang["April"], StrackLang["May"], StrackLang["June"], StrackLang["July"], StrackLang["August"], StrackLang["September"], StrackLang["October"], StrackLang["November"], StrackLang["December"]];

        var today = new Date(),
            yesterday = new Date(),
            tomorrow = new Date(),
            ftoday, fyesterday, ftomorrow;

        ftoday = Strack.date_format(today, "yyyy-M-d");

        yesterday.setHours(0, 0, 0, 0);
        yesterday.setDate(yesterday.getDate() - 1);
        fyesterday = Strack.date_format(yesterday, "yyyy-M-d");

        tomorrow.setHours(0, 0, 0, 0);
        tomorrow.setDate(tomorrow.getDate() + 1);
        ftomorrow = Strack.date_format(tomorrow, "yyyy-M-d");


        if (ftoday == fctime) {
            strDate = StrackLang["Today"];
        } else if (fyesterday == fctime) {
            strDate = StrackLang["Yesterday"];
        } else if (ftomorrow == fctime) {
            strDate = StrackLang["Tomorrow"];
        } else {
            strDate = months[MMDD.getMonth()] + " " + MMDD.getDate() + StrackLang["UnitTH"];
            if (cyear != NYear) {
                strDate = "(" + cyear + ") " + strDate;
            }
        }

        return strDate;
    },
    //上个月第一天的日期
    lastMFirst: function (today) {
        var nowdays = new Date();
        var year = nowdays.getFullYear();
        var month = nowdays.getMonth() + 1;
        if (month == 0) {
            month = 12;
            year = year - 1;
        }
        if (month < 10) {
            month = "0" + month;
        }
        if (today == 'today') {
            return year + "-" + month + "-" + nowdays.getDate();//上个月的第一天
        } else {
            return year + "-" + month + "-" + "01";//上个月的第一天
        }
    },
    //获得某月的最后一天
    getLastDay: function (year, month) {
        var new_year = year;
        var new_month = month++;
        if (month > 12) {
            new_month -= 12;
            new_year++;
        }
        var new_date = new Date(new_year, new_month, 1);
        return (new Date(new_date.getTime() - 1000 * 60 * 60 * 24)).getDate();
    },
    //上个月日期
    lastMonthDate: function () {
        var Nowdate = new Date();
        var vYear = Nowdate.getFullYear();
        var vMon = Nowdate.getMonth() + 1;
        var vDay = Nowdate.getDate();
        //每个月的最后一天日期（为了使用月份便于查找，数组第一位设为0）
        var daysInMonth = new Array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        if (vMon == 1) {
            vYear = Nowdate.getFullYear() - 1;
            vMon = 12;
        } else {
            vMon = vMon - 1;
        }
        //若是闰年，二月最后一天是29号
        if (vYear % 4 == 0 && vYear % 100 != 0) {
            daysInMonth[2] = 29;
        }
        if (daysInMonth[vMon] < vDay) {
            vDay = daysInMonth[vMon];
        }
        if (vDay < 10) {
            vDay = "0" + vDay;
        }
        if (vMon < 10) {
            vMon = "0" + vMon;
        }
        var date = vYear + "-" + vMon + "-" + vDay;
        return date;
    },
    //两个日期间的相隔天数
    getTime2Time: function ($time1, $time2) {
        var time1 = arguments[0], time2 = arguments[1];
        time1 = Date.parse(time1) / 1000;
        time2 = Date.parse(time2) / 1000;
        var time_ = time1 - time2;
        return (time_ / (3600 * 24));
    },
    // 生成当前页面隐藏数据
    generate_hidden_param: function (id) {
        var param = {};
        var key;
        var hid = id? id : "#page_hidden_param";
        $(hid).find("input").each(function () {
            key = $(this).attr("name");
            param[key] = $(this).val();
        });
        Strack.G.pageHiddenParam = param;
        return param;
    },
    //执行单元格拷贝
    copy_to_clipboard: function () {
        layer.msg(StrackLang["Copy_Clipboard_SC"]);
    },
    //数字前面加零
    number_add_zero: function (num, length) {
        return ('' + num).length < length ? ((new Array(length + 1)).join('0') + num).slice(-length) : '' + num;
    },
    //添加动画效果
    add_animate_effect: function (c_dom, animate_name, checked, hidedom, showdom, notices) {
        if (!$(c_dom).hasClass(animate_name)) {
            $(c_dom).addClass(animate_name);
            if (checked) {
                $(hidedom).hide();
                $(c_dom).append(notices);
            }
            window.setTimeout(function () {
                $(c_dom).removeClass(animate_name);
            }, 1000);
        }
    },
    //初始化延迟加载init_lazy_load
    init_lazy_load: function (imgdom, condom) {
        $(imgdom).lazyload({
            container: $(condom),
            event: 'scroll',
            effect: 'fadeIn'
        });
    },
    //瀑布模式加载
    fall_load_data: function (page_id, param, after_callback, before_callback) {
        $(page_id).on("scroll", function () {
            var scrollT = this.scrollTop || this.scrollTop;
            var scrollH = this.scrollHeight || this.scrollHeight;
            var clientH = this.clientHeight || this.clientHeight;

            if(before_callback){
                before_callback();
            }

            if (scrollT === scrollH - clientH) {
                param.page_number++;
                var max_number = Math.ceil(param.total / param.page_size);
                //当超过当前页数后不加载
                if (param.page_number <= max_number) {
                    if(after_callback){
                        after_callback(param);
                    }
                }
            }
        });
    },
    //数组转Ajax data文本
    array_to_json: function (jsonOb) {
        var newJson = '';
        for (var key in jsonOb) {
            newJson += key + '=' + jsonOb[key] + '&';
        }
        newJson = newJson.substring(0, newJson.length - 1);
        return newJson;
    },
    //验证表单数据
    validate_form: function (id) {
        var formData = {}, status = 200;
        $('#' + id + ' .form-input').each(function () {
            var id = $(this).attr('id'),
                type = $(this).attr('wiget-type'),
                need = $(this).attr('wiget-need'),
                field = $(this).attr('wiget-field'),
                name = $(this).attr('wiget-name');
            var val = '';
            switch (type) {
                case 'input':
                case 'textarea':
                    val = $('#' + id).val();
                    break;
                case 'combobox':
                    val = Strack.get_combos_val('#' + id, 'combobox', 'getValue');
                    break;
                case 'combobox_s':
                    val = Strack.get_combos_val('#' + id, 'combobox', 'getValues');
                    break;
                case 'switch':
                    val = Strack.get_switch_val('#' + id);
                    break;
                case 'datebox':
                    val = $('#' + id).datebox('getValue');
                    val = (!val) ? '' : val;
                    break;
                case 'json':
                    val = Strack.get_json_editor_val(id);
                    break;
            }
            if (need === 'yes' && val.length === 0) {
                status = 404;
                layer.msg(name + ' : ' + StrackLang['Required_Field'], {icon: 2, time: 1200, anim: 6});
                return false;
            } else {
                formData[field] = val;
            }
        });
        return {'status': status, 'message': '', 'data': formData};
    },
    //验证日期格式 dd/MM/yyyy HH:mm
    validate_date_format: function (dt) {
        var isValidDate = false;
        var arr1 = dt.split('-');
        var year = 0;
        var month = 0;
        var day = 0;
        var hour = 0;
        var minute = 0;
        var sec = 0;
        if (arr1.length == 3) {
            var arr2 = arr1[2].split(' ');
            if (arr2.length == 2) {
                var arr3 = arr2[1].split(':');
                year = arr1[0];
                month = arr1[1];
                day = arr2[0];
                hour = arr3[0];
                minute = arr3[1];
                sec = 0;
                var isValidTime = false;
                if (hour >= 0 && hour <= 23 && minute >= 0 && minute <= 59 && sec >= 0 && sec <= 59)
                    isValidTime = true;
                else if (hour == 24 && minute == 0 && sec == 0)
                    isValidTime = true;

                if (isValidTime) {
                    var isLeapYear = false;
                    if (year % 4 == 0)
                        isLeapYear = true;

                    if ((month == 4 || month == 6 || month == 9 || month == 11) && (day >= 0 && day <= 30))
                        isValidDate = true;
                    else if ((month != 2) && (day >= 0 && day <= 31))
                        isValidDate = true;

                    if (!isValidDate) {
                        if (isLeapYear) {
                            if (month == 2 && (day >= 0 && day <= 29))
                                isValidDate = true;
                        }
                        else {
                            if (month == 2 && (day >= 0 && day <= 28))
                                isValidDate = true;
                        }
                    }
                }
            }

        }
        return isValidDate;
    },
    //验证邮箱
    check_email: function (email) {
        var re = /^([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]$/;
        var objExp = new RegExp(re);
        if (!objExp.test(email) === true) {
            return false;
        } else {
            return true;
        }
    },
    //验证权限方法
    check_auth_format: function (auth) {
        if (auth.length < 1 || auth.indexOf('/') < 1) {
            return false;
        } else {
            return true;
        }
    },
    //固定长度验证
    check_long: function (val, long) {
        if (val.length != long) {
            return false;
        } else {
            return true;
        }
    },
    //验证dialog form表单返回错误代码
    valid_form: function (valid, val, field_name) {
        if (isNaN(valid)) {
            //区间验证
            var valid_range = valid.split(",");
            var first_num = parseInt(valid_range[0]),
                second_num = parseInt(valid_range[1]);
            if (first_num === second_num) {
                //固定值
                if (val.length < first_num) {
                    return {
                        'status': false,
                        'error_num': -1,
                        'message': field_name + '' + StrackLang['Error_Valid_Fixed'] + ' ' + first_num
                    };
                } else {
                    return {'status': true, 'error_num': 0, 'message': ''};
                }
            } else {
                //区域范围
                if (val.length < first_num || val.length > second_num) {
                    return {
                        'status': false,
                        'error_num': -1,
                        'message': field_name + '' + StrackLang['Error_Valid_Range'] + ' ' + first_num + '-' + second_num
                    };
                } else {
                    return {'status': true, 'error_num': 0, 'message': ''};
                }
            }
        } else {
            switch (valid) {
                case 0://直接返回true
                    return {'status': true, 'error_num': 0, 'message': ''};
                case 1://验证是否为空
                    if (val === '' || val === null) {
                        return {
                            'status': false,
                            'error_num': -1,
                            'message': field_name + '' + StrackLang['Error_Valid_Empty']
                        };
                    } else {
                        return {'status': true, 'error_num': 0, 'message': ''};
                    }
                case 2://邮箱验证
                    if (Strack.check_email(val)) {
                        return {'status': true, 'error_num': 0, 'message': ''};
                    } else {
                        return {
                            'status': false,
                            'error_num': -1,
                            'message': field_name + '' + StrackLang['Error_Format']
                        };
                    }
                case 3://权限方法验证
                    if (Strack.check_auth_format(val)) {
                        return {'status': true, 'error_num': 0, 'message': ''};
                    } else {
                        return {
                            'status': false,
                            'error_num': -1,
                            'message': field_name + '' + StrackLang['Error_Format']
                        };
                    }
                default ://非法操作
                    return {'status': false, 'error_num': 666, 'message': StrackLang['Illegal_Operation']};
            }
        }
    },
    //dialog 对话框内容
    dialog_dom: function (data) {
        var dom = '', footer = '', h_div = '', h_extra = '', b_dom = '', hid_data;
        if (data.hidden) {
            hid_data = data.hidden;
        } else {
            hid_data = [];
        }
        //判断dialog类型
        switch (data.type) {
            case 'normal':
                //普通dialog
                h_div += '<div class="st-dialog-main">';
                b_dom += Strack.dialog_hide(hid_data);
                b_dom += Strack.dialog_form(data.items);
                footer = Strack.dialog_footer(data.footer, '');
                dom += Strack.dialog_build(h_div, h_extra, b_dom, footer);
                break;
            case 'adv_filter':
                h_div += '<div class="st-dialog-datalist pitem-wrap">';
                b_dom += Strack.dialog_hide(hid_data);
                b_dom += '<div id="adv_fdialog" class="adv-filter-main">' +
                    '<div class="dgcb-query-all">' +
                    '<div class="query-all-name aign-left">' + StrackLang["ConditionalLogic"] + '</div>' +
                    '<div class="query-all-input aign-left"><input id="logic_comb"></div>' +
                    '<a href="javascript:;" onclick="Strack.add_filter_group(this)" class="query-all-btn aign-left"><i class="icon-uniEA33"></i>' + StrackLang["AddFilterGroup"] + '</a>' +
                    '</div>' +
                    '<div id="dg_adv_filter" class="dgcb-query-wrap">' +
                    '</div>' +
                    '</div>';
                footer = Strack.dialog_footer(data.footer, '');
                dom += Strack.dialog_build(h_div, h_extra, b_dom, footer);
                break;
            case 'adv_sort':
                var sort_data = [
                    {case: 106, lang: StrackLang["Sort_First_By"], index: "first"},
                    {case: 106, lang: StrackLang["Then_By"], index: "second"},
                    {case: 106, lang: StrackLang["Then_By"], index: "third"}];
                b_dom += Strack.dialog_hide(hid_data);
                footer = Strack.dialog_footer(data.footer, '');
                var sort_dom = '';
                sort_data.forEach(function (item) {
                    sort_dom += Strack.dialog_items(item);
                });
                h_div += '<div class="st-dialog-main">';
                b_dom += '<div>' + sort_dom + '</div>';
                dom += Strack.dialog_build(h_div, h_extra, b_dom, footer);
                break;
            case 'relationship_set':
                b_dom += Strack.dialog_hide(hid_data);
                h_div += '<div class="st-dialog-main">';
                b_dom += '<div class="st-dg-relate-r">' +
                    '<div class="dg-relate-r-t">' + StrackLang["Related_Module_Title"] + '</div>' +
                    '<div class="dg-relate-r-list">' +
                    '<table class="ui celled striped table">' +
                    '<tbody id="related_module_list" >' +
                    '</tbody>' +
                    '</table>' +
                    '</div>' +
                    '</div>';
                b_dom += '<div class="st-dg-relate-l">' +
                    '<div class="st-dialog-toolbar">' +
                    '<a href="javascript:;" class="easyui-linkbutton" iconCls="icon-add" plain="true"onclick="Strack.dialog_relationship_item();">' +
                    StrackLang["Add"] +
                    '</a>' +
                    '</div>' +
                    '<div id="st_relationship" class="st-dialog-relate"></div>' +
                    '</div>';
                footer = Strack.dialog_footer(data.footer, '');
                dom += Strack.dialog_build(h_div, h_extra, b_dom, footer);
                break;
            case 'download':
                break;
            case 'avatar':
                h_div += '<div class="st-dialog-main">';
                b_dom += Strack.dialog_hide(hid_data);
                b_dom += Strack.dialog_avatar(data.header_extra, data.footer);
                dom += Strack.dialog_build(h_div, h_extra, b_dom, footer);
                break;
            case 'item_operation':
                h_div += '<div class="st-dialog-main">';
                b_dom += Strack.dialog_hide(hid_data);
                b_dom += Strack.dialog_form(data.items);
                b_dom += '<div class="st-dialog-up"><ul id="st_dialog_item" class="dg-report-list"></ul></div>';
                footer = Strack.dialog_footer(data.footer, '');
                dom += Strack.dialog_build(h_div, h_extra, b_dom, footer);
                break;
            case 'datagrid':
                h_div += '<div class="st-dialog-datalist pitem-wrap">';
                b_dom += Strack.dialog_hide(hid_data);
                b_dom += Strack.dialog_grid(data.grid);
                footer = Strack.dialog_footer(data.footer, '');
                dom += Strack.dialog_build(h_div, h_extra, b_dom, footer);
                break;
            case 'add_custom_field':
                h_div += '<div class="st-dialog-datalist pitem-wrap">';
                b_dom += Strack.dialog_hide(hid_data);
                b_dom += Strack.dialog_custom_field();
                footer = Strack.dialog_footer(data.footer, '');
                dom += Strack.dialog_build(h_div, h_extra, b_dom, footer);
                break;
            case 'add_entity_task':
                h_div += '<div class="st-dialog-entity-task pitem-wrap">';
                b_dom += Strack.dialog_hide(hid_data);
                b_dom += Strack.dialog_add_entity_task(data.entity_title);
                footer = Strack.dialog_footer(data.footer, '');
                dom += Strack.dialog_build(h_div, h_extra, b_dom, footer);
                break;
            case 'action':
                break;
        }
        return dom;
    },
    //生成dialog 对话框 dom
    dialog_build: function (h_div, h_extra, b_dom, footer) {
        var dom = '';
        dom += h_div;
        dom += h_extra;
        dom += '<form id="st_dialog_form" style="height: 100%">' + b_dom + '</form>';
        dom += footer;
        dom += '</div>';
        return dom;
    },
    //dialog 对话框 隐藏数据
    dialog_hide: function (hide) {
        var dom = '';
        hide.forEach(function (val) {
            dom += Strack.dialog_items(val);
        });
        return '<div id="st_dialog_form_hide">' + dom + '</div>';
    },
    //dialog 对话框 表单区域
    dialog_form: function (form) {
        var dom = '';
        form.forEach(function (val) {
            dom += Strack.dialog_base_item(val['lang'], val);
        });
        return dom;
    },
    //dialog 对话框 底部按钮区域
    dialog_footer: function (right, left) {
        var dom = '<footer>';
        if (left) {
            dom += '<div class="st-dialog-lfooter">' + Strack.dialog_button(0, left) + '</div>';
        }
        dom += '<div class="st-dialog-footer">' + Strack.dialog_button(0, right) + '</div>';
        dom += '</footer>';
        return dom;
    },
    //dialog 自定义字段列表
    dialog_grid: function (param) {
        var dom = '';
        dom += '<div id="' + param["wrap_dom"] + '" class="entity-datalist" style="height: ' + param["height"] + 'px ;width: 100%" >';
        if (param["toolbar_show"]) {
            dom += '<div id="' + param["toolbar_id"] + '" class="proj_tb tb-padding-grid-small st-buttons-blue" style="overflow: hidden">' +
                Strack.dialog_grid_toolbar(param.toolbar_dom) +
                '</div>';
        }
        if (param["top_notice"]) {
            dom += '<div class="dg-data-notice text-ellipsis">' +
                param["top_notice"] +
                '</div>';
        }
        dom += '<table id="' + param["table_dom"] + '" ></table>' +
            '</div>';
        return dom;
    },
    //dialog grid 工具栏生成
    dialog_grid_toolbar: function (conf) {
        var dom = '';
        conf.forEach(function (val) {
            dom += Strack.toolbar_dom_build(val);
        });
        return dom;
    },
    // 工具栏生成
    toolbar_dom_build: function (item) {
        var dom = '';
        switch (item.type) {
            case "button":
                dom += '<a href="javascript:;" class="easyui-linkbutton" iconCls="' + item.icon + '" plain="true" onclick="' + item.obj + '(this);">' + item.title + '</a>';
                break;
        }
        return dom;
    },
    //dialog 自定义字段dom
    dialog_custom_field: function () {
        var dom = '';
        dom += '<div class="stdg-add-field">' +
            '<div class="stdg-field-left aign-left">' +
            '<div class="stdg-left-header">' + StrackLang["Field_Type"] + '</div>' +
            '<div id="stdg_fd_list" class="stdg-left-wrap"></div>' +
            '</div>' +
            '<div class="stdg-field-right aign-left">' +
            '<div id="stdg_fd_title" class="stdg-right-header">' + StrackLang["Please_One_Field_Type"] + '</div>' +
            '<div id="stdg_fd_main" class="stdg-right-wrap"></div>' +
            '</div>' +
            '</div>';
        return dom;
    },
    //dialog 添加实体任务
    dialog_add_entity_task: function (entity_title) {
        var dom = '';
        var input_dom = Strack.dialog_form([
            {case: 2, id: 'Mentity', lang: entity_title, name: 'entity_ids', valid: '1'},
            {case: 2, id: 'Mstep', lang: StrackLang['Step'], name: 'step_ids', valid: '1'}
        ]);
        var task_input = Strack.dialog_form([
            {case: 2, id: 'Nup_fields', type: 'text', lang: StrackLang['Fields'], name: 'fields', valid: 1, value: ""}
        ]);
        dom += '<div class="stdg-etask-wrap">' +
            '<div class="stdg-etask-left">' +
            '<div class="stdg-etask-l-input">' +
            input_dom +
            '</div>' +
            '<div id="stdg_etask_list" class="stdg-etask-l-list">' +
            '<div class="datagrid-empty-no">' + StrackLang["Please_Select_Step"] + '</div>' +
            '</div>' +
            '</div>' +
            '<div class="stdg-etask-right">' +

            '<div class="etask-right-null">' +
            '<div class="datagrid-empty-no">' + StrackLang["Please_Select_Base"] + '</div>' +
            '</div>' +

            '<div class="etask-right-main">' +
            '<div class="etask-right-input">' +
            task_input +
            '</div>' +
            '<div class="st-dialog-up">' +
            '<ul id="st_dialog_item" class="dg-report-list"></ul>' +
            '</div>' +
            '</div>' +


            '</div>' +
            '</div>';
        return dom;
    },
    // dialog 移除工序任务
    remove_entity_step_task: function (i) {
        var $item_parent = $(i).closest(".stdg-etask-l-item");
        var md5_name = $item_parent.attr("id"),
            step_code = $item_parent.attr("data-stepcode"),
            step_id = $item_parent.attr("data-stepid");

        var $lists = $(i).closest(".etask-l-lists");

        // 删除当前选择的item
        $item_parent.remove();
        Strack.reset_entity_step_task_data({type: 'remove', param: {id: step_id, code: step_code}, step_code:step_code, md5_name: md5_name});

        // 判断当前分组下面还有没有item
        var lists = $lists.find(".stdg-etask-l-item");
        if (lists.length === 0) {
            // 取消step combobox 选中
            var step = $(i).data("step");
            $("#"+step).combobox("unselect", step_id);
        }
    },
    // dialog 工序任务清除指定分组
    remove_entity_step_task_group: function (ids, param) {
        $("#etask_g_" + param.code).remove();
        Strack.check_entity_step_task_list(ids);
    },
    // dialog 复制工序任务
    copy_entity_step_task: function (i) {
        var $item_parent = $(i).closest(".stdg-etask-l-item");
        var id = $item_parent.attr("id"),
            step_code = $item_parent.attr("data-stepcode"),
            step_id = $item_parent.attr("data-stepid");

        var step_ids = {
            step_id : $(i).data("step"),
            list_id : $(i).data("list"),
            combox_id : $(i).data("combox"),
            edit_id : $(i).data("edit")
        };
        var md5_name = $(i).data("md5name");

        var check_data = Strack.check_item_operate_fields('#'+step_ids.combox_id,'#'+step_ids.edit_id);
        Strack.G.entityStepTaskAddData.data[step_code][md5_name] = check_data.up_data;

        if(check_data.allow_up){
            $item_parent.after(Strack.entity_step_task_item_dom(step_ids, {id: step_id, code: step_code, md5_name: md5_name}, 'new'));
        }
    },
    // dialog 添加工序任务分组
    add_entity_step_task_group: function (ids, param, mode) {
        var item_dom = Strack.entity_step_task_item_dom(ids, param, mode);
        var $task_list = $('#'+ids.list_id);
        if ($task_list.find(".etask-l-list-g").length === 0) {
            $task_list.empty();
        }
        if(mode === 'new'){
            $task_list.append(Strack.entity_step_task_group_dom(param, item_dom, mode));
        }else {
            var $task_group = $("#etask_g_" + param.step_code);
            if($task_group.length > 0){
                $task_group.find('.etask-l-lists').append(item_dom);
            }else {
                $task_list.append(Strack.entity_step_task_group_dom(param, item_dom, mode));
            }
        }
    },
    // dialog 工序任务单项 item dom
    entity_step_task_item_dom: function (ids, param, mode) {
        var dom = '';
        var md5_name = mode === 'new' ? param.code + '_' + Math.floor(Math.random() * 10000 + 1) : param.code;
        var step_code = mode === 'new' ? param.code : param.step_code;
        dom += '<div id="' + md5_name + '" class="stdg-etask-l-item" data-stepcode="' + step_code + '" data-stepid="' + param.id + '">' +
            '<a href="javascript:;" class="etask-l-item-bnt etask-l-remove" onclick="Strack.remove_entity_step_task(this)" title="' + StrackLang["Delete"] + '" data-step="'+ids.step_id+'"><i class="icon-uniE6DB"></i></a>' +
            '<a href="javascript:;" class="etask-l-item-bnt etask-l-copy" onclick="Strack.copy_entity_step_task(this)" title="' + StrackLang["Copy"] + '" data-md5name="'+md5_name+'" data-combox="'+ids.combox_id+'" data-step="'+ids.step_id+'" data-list="'+ids.list_id+'" data-edit="'+ids.edit_id+'"><i class="icon-uniE92A"></i></a>' +
            '<a href="javascript:;" class="text-ellipsis etask-l-item-name" onclick="Strack.set_entity_step_task(this)" data-combox="'+ids.combox_id+'" data-list="'+ids.list_id+'" data-edit="'+ids.edit_id+'">' +
            md5_name +
            '</a>' +
            '</div>';

        Strack.reset_entity_step_task_data({type: 'add', param: param, step_code:step_code, md5_name: md5_name, mode: mode});

        return dom;
    },
    // dialog 重置工序任务数据
    reset_entity_step_task_data: function (data) {
        if (data.type === 'add') {
            // 添加item
            if (!Strack.G.entityStepTaskAddData.data.hasOwnProperty(data.step_code)) {
                Strack.G.entityStepTaskAddData.data[data.step_code] = {};
            }

            if(data.mode !== 'old'){
                if(data.param.md5_name && $("#"+data.param.md5_name).hasClass("etask-l-active")){
                    // 如果是 copy 则拿到复制源已经配置的所有数据
                    var from_data = Strack.G.entityStepTaskAddData.data[data.step_code][data.param.md5_name];
                    var new_base_data = [];
                    from_data['base'].forEach(function (val) {
                        if($.inArray(val.field, ['base-name', 'base-code']) >= 0){
                            val.value = data.md5_name;
                        }
                        new_base_data.push(val);
                    });
                    from_data['base'] = new_base_data;
                    Strack.G.entityStepTaskAddData.data[data.step_code][data.md5_name] = from_data;
                }else {
                    Strack.G.entityStepTaskAddData.data[data.step_code][data.md5_name] = {
                        base: [
                            {
                                field : "base-name",
                                field_type: "built_in",
                                value: data.md5_name,
                                variable_id: 0
                            },
                            {
                                field : "base-code",
                                field_type: "built_in",
                                value: data.md5_name,
                                variable_id: 0
                            }
                        ]
                    };
                }
            }

        } else if (data.type === 'remove') {
            // 删除item
            var old_step_data = Strack.G.entityStepTaskAddData.data[data.step_code],
                new_step_data = {};
            for (var item in old_step_data) {
                if (data.md5_name !== item) {
                    new_step_data[item] = old_step_data[item];
                }
            }
            Strack.G.entityStepTaskAddData.data[data.step_code] = new_step_data;
        }
    },
    // dialog 工序任务分组 group dom
    entity_step_task_group_dom: function (param, item_dom, mode) {
        var dom = '';
        var name = mode === 'new' ? param.name : param.step_name;
        var code = mode === 'new' ? param.code : param.step_code;
        dom += '<div id="etask_g_' + code + '" class="etask-l-list-g">' +
            '<div class="etask-l-list-title text-ellipsis">' +
            name +
            '</div>' +
            '<div class="etask-l-lists">' +
            item_dom +
            '</div>' +
            '</div>';
        return dom;
    },
    // dialog 设置工序任务
    set_entity_step_task: function (i) {
        var $item_parent = $(i).closest(".stdg-etask-l-item");
        var id = $item_parent.attr("id"),
            step_code = $item_parent.attr("data-stepcode");

        // 获取当前激活的item
        var list_id = $(i).data("list");
        var combox_id = $(i).data("combox");
        var edit_id = $(i).data("edit");
        var $etask_list = $('#'+list_id);
        var $edit_list = $('#'+edit_id);
        var active_item = $etask_list.find(".etask-l-active");
        var allow = true;

        if (active_item.length > 0) {
            var ac_id = active_item.attr("id"),
                ac_step_code = active_item.attr("data-stepcode");
            var check_data = Strack.check_item_operate_fields('#'+combox_id, '#'+edit_id);
            allow = check_data.allow_up;
            Strack.G.entityStepTaskAddData.data[ac_step_code][ac_id] = check_data.up_data;
        } else {
            if( edit_id === 'm_review_task_item'){
                // 添加播放列表面板
                $("#step_task_details").show();
            }
            $(".etask-right-null").hide();
            $(".etask-right-main").show();
        }

        if (allow) {
            // 取消其他项选中
            $etask_list.find(".stdg-etask-l-item")
                .removeClass("etask-l-active");
            $item_parent.addClass("etask-l-active");

            active_item.addClass("form_ok");

            // 重置表单赋值
            var form_data = Strack.G.entityStepTaskAddData.data[step_code][id];

            var old_form_data = {};
            if (!$.isEmptyObject(form_data)) {
                for (var item in form_data) {
                    form_data[item].forEach(function (val) {
                        old_form_data[val["field"]] = val.value;
                    });
                }
            } else {
                old_form_data["base-name"] = id;
                old_form_data["base-code"] = id;
            }

            $(".form-tip").remove();


            // 给存在的控件赋值
            $edit_list.find(".field_edit_item").each(function () {
                var editor = $(this).attr("data-editor"),
                    field = $(this).attr("data-field"),
                    multiple = $(this).attr("data-multiple");

                if (old_form_data.hasOwnProperty(field)) {
                    switch (editor) {
                        case "combobox":
                            // 判断是不是多选框
                            if(multiple === 'yes'){
                                $(this).combobox('setValues', old_form_data[field]);
                            }else {
                                $(this).combobox('setValue', old_form_data[field]);
                            }
                            break;
                        case "datebox":
                            $(this).datebox("setValue", old_form_data[field]);
                            break;
                        case "checkbox":
                            if (old_form_data[field] === 'yes') {
                                $(this).attr("checked", 'checked');
                            } else {
                                $(this).attr("checked", '');
                            }
                            break;
                        default:
                            $(this).val(old_form_data[field]);
                            break;
                    }
                } else {
                    switch (editor) {
                        case "combobox":
                            $(this).combobox('clear');
                            break;
                        case "datebox":
                            $(this).datebox("clear");
                            break;
                        case "checkbox":
                            $(this).attr("checked", '');
                            break;
                        default:
                            $(this).val('');
                            break;
                    }
                }
            });
        } else {
            active_item.removeClass("form_ok");
        }
    },
    // dialog 判断工序任务列表是否被清空
    check_entity_step_task_list: function (ids) {
        var $list = $('#'+ids.list_id);
        var group = $list.find(".etask-l-list-g");
        if (group.length === 0) {
            $list.empty().append('<div class="datagrid-empty-no">' + StrackLang["Please_Select_Step"] + '</div>');
            $(".etask-right-main").hide();
            $(".etask-right-null").show();
        }
    },
    //dialog 对话框 头像
    dialog_avatar: function (extra, footer) {
        var dom = '';
        var avatar_dom = $('#'+extra["user_data"]["dom_id"]).html();
        dom += '<div class="up-avatar">' +
            '<header id="crop_avatar_js"></header>' +
            '<div class="user-avatar">' +
            avatar_dom+
            '</div>' +
            '<div class="user-avatar-wrap">' +
            '<span class="avatar-w-title">' +
            '<p>' + extra['lang'] + '</p>' +
            '</span>' +
            '</div>' +
            '</div>' +
            '<div class="crop-avatar-wrap">' +
            '<div class="crop-avatar-img">' +
            '</div>' +
            '<div class="crop-avatar-view">' +
            '<div class="avatar-view-sm1"></div><div class="avatar-view-sm2"></div><div class="avatar-view-sm3"></div>' +
            '</div>' +
            '<div class="crop-avatar-footer">' +
            '<a href="javascript:;" class="file">' + StrackLang["Select_Image_File"] + '' +
            '<input id="img_upload" type="file" name="" id="">' +
            '</a>' +
            '<div class="user-avatar-button">' +
            Strack.dialog_button(0, footer) +
            '</div>' +
            '</div>' +
            '</div>';
        return dom;
    },
    //生成dialog footer button dom
    dialog_button: function (s, data) {
        var f_button = '';
        for (var i = s; i < data.length; i++) {
            switch (data[i]['type']) {
                case 1:
                    f_button += '<a href="javascript:;" class="st-dialog-button st-button-base button-dgsub" onclick="obj.' + data[i]['obj'] + '();">';
                    break;
                case 2:
                    f_button += '<a href="javascript:;" class="st-dialog-button st-button-base button-dgcel" onclick="obj.' + data[i]['obj'] + '();">';
                    break;
                case 3:
                    f_button += '<a href="javascript:;" id="' + data[i]['id'] + '" class="st-dialog-button button-dgcel">';
                    break;
                case 4://上传图片按钮
                    f_button += '<a href="javascript:;" class="st-dialog-button file">' + StrackLang['Select_Image_File'] + '<input id="img_up_bnt" type="file" name="">';
                    break;
                case 5://边侧栏上传按钮
                    f_button += '<a href="javascript:;" class="st-dialog-button st-button-base button-dgsub" onclick="Strack.' + data[i]['obj'] + '(this);">';
                    break;
                case 6://上传队列选择按钮
                    f_button += '<input id="' + data[i]['obj'] + '" class="aign-left" name="' + data[i]['obj'] + '" type="file" multiple="true">';
                    break;
                case 7://更多选项下来菜单
                    f_button += '<a href="javascript:;" class="st-dialog-button st-button-base stdown-filter project_filter" onclick="Strack.' + data[i]['obj'] + '(this,' + data[i]["value"][3] + ',' + data[i]["value"][0] + ',' + data[i]["value"][1] + ',' + data[i]["value"][2] + ');" data-dtype="' + data[i]["value"][3] + '" data-height="' + data[i]["value"][1] + '">' +
                        data[i]['title'] + '<i class="dropdown icon project_filter"></i>' +
                        '</a>';
                    break;
                case 8://边侧栏上传按钮
                    f_button += '<a href="javascript:;" class="st-dialog-button st-button-base button-dgcel" onclick="Strack.' + data[i]['obj'] + '(this);">';
                    break;
                case 9://左侧错误提示栏
                    f_button += '<div id="dailog_error" class="dailog-error aign-left" style="width:' + data[i]["width"] + '">' +
                        '<div class="error-icon aign-left icon-left"><i class="icon-uniEA30"></i></div>' +
                        '<div class="error-notice aign-left text-ellipsis"></div>' +
                        '</div>';
                    break;
                case 10://上一页
                    f_button += '<a href="javascript:;" class="st-dialog-button st-button-base button-dgcel" onclick="Strack.' + data[i]['obj'] + '(this);" data-tab="prev">';
                    break;
                case 11://下一页
                    f_button += '<a href="javascript:;" class="st-dialog-button st-button-base button-dgsub" onclick="Strack.' + data[i]['obj'] + '(this);" data-tab="next">';
                    break;
                case 12://excel上传队列选择按钮
                    f_button += '<div class="dailog-upexcel aign-left">' +
                        '<input id="' + data[i]['obj'] + '" class="aign-left" name="' + data[i]['obj'] + '" type="file" multiple="true">' +
                        '</div>';
                    break;
                case 13://deleted button
                    f_button += '<a href="javascript:;" class="st-dialog-button st-button-base button-dgsstop" onclick="obj.' + data[i]['obj'] + '();">';
                    break;
                case 14://deleted button
                    f_button += '<a href="javascript:;" class="st-dialog-button st-button-base button-dgsstop" onclick="Strack.' + data[i]['obj'] + '();">';
                    break;
                default :
                    f_button += '<a href="javascript:;" class="st-dialog-button st-button-base button-dgsub" onclick="obj.' + data[i]['obj'] + '();">';
                    break;
            }
            var earr = [7, 9];
            if (earr.indexOf(data[i]['type']) < 0) {
                f_button += data[i]['title'];
                f_button += '</a>';
            }
        }
        return f_button;
    },
    //新增映射关系
    dialog_relationship_item: function () {
        var random = Math.floor(Math.random() * 1000 + 1);
        var module_id = $("#Mmodule_id").val();
        var temp_id = $("#hide_temp_id").val();
        $("#st_relationship").append(Strack.dialog_items({case: 108, index: random}));

        Strack.combobox_widget('#first_' + random, {
            url: StrackPHP["getRelationshipModuleList"],
            valueField: 'id',
            textField: 'name',
            width: 160,
            value: module_id,
            queryParams: {
                module_id: module_id,
                template_id: temp_id,
                type: "entity",
                position: "first"
            }
        });

        Strack.combobox_widget('#second_' + random, {
            url: StrackPHP["getRelationshipModuleList"],
            valueField: 'id',
            textField: 'name',
            width: 160,
            queryParams: {
                module_id: module_id,
                template_id: temp_id,
                type: "entity",
                position: "second"
            }
        });

        return random;
    },
    //对话框基础DOM
    dialog_items: function (items) {
        var type = items.case,
            i_dom = '', inmask = "";
        if (items.mask) {
            inmask = items.mask;
        }
        switch (type) {
            case 1:
                // input 输入框
                i_dom = '<input id="' + items.id + '" class="dialog-widget-val" data-widget="input" type="' + items.type + '" autocomplete="off" data-name="' + items.name + '" data-valid="' + items.valid + '" value="' + items.value + '" data-inputmask="\'alias\':\'' + inmask + '\'">';
                break;
            case 2:
                // input 控件
                i_dom = '<input id="' + items.id + '" class="dialog-widget-val" data-widget="widget" data-name="' + items.name + '" data-valid="' + items.valid + '" >';
                break;
            case 3:
                // json editor 编辑器
                i_dom = '<div class="dialog-json-editor"><div id="' + items.id + '" class="dialog-widget-val" data-widget="json" data-name="' + items.name + '" data-valid="' + items.valid + '"></div></div>';
                break;
            case 4://datalist 数据列表
                i_dom = '<div id="' + items.id + '" class="dialog-widget-val" data-widget="datalist" data-name="' + items.name + '" ></div>';
                break;
            case 5://template columns 设置
                i_dom = '<div class="template-columns-wrap" >' +
                    '<div class="template-columns-item template-margin" >' +
                    '<div id="template-field" ></div>' +
                    '</div>' +
                    '<div class="template-columns-item" >' +
                    '<table id="template-columns" ></table>' +
                    '</div>' +
                    '</div>';
                break;
            case 6://images
                i_dom += '<a class="admin-softicon-amd" href="javascript:;" onclick="obj.' + items.name + '(' + items.sid + ');">';
                i_dom += '<img class="admin-softicon-md" src="' + StrackPHP["UPLOADS"] + '/SoftwareIcon/' + items.value + '.jpg">';
                i_dom += '</a>';
                break;
            case 7:
                // 文本框域
                i_dom = '<textarea id="' + items.id + '" class="dialog-widget-val" data-widget="textarea" data-name="' + items.name + '" data-valid="' + items.valid + '">' + items.value + '</textarea>';
                break;
            case 8:
                //software icon show
                i_dom += '<div id="' + items.id + '" data-name="' + items.name + '" data-valid="' + items.valid + '"><div class="' + items.value + '"></div></div>';
                break;
            case 9://上传队列多个文件
                i_dom += '<div id="queue" class="img_queue"></div>';
                break;
            case 10://编辑tag控件
                i_dom += '<div style="" class="st-dialog-tags">' +
                    '<input id="' + items.id + '" class="combo-tags dialog-widget-val" data-widget="tags" data-name="' + items.name + '" placeholder="' + StrackLang["InputTag"] + '" style="width: calc(100% - 10px); padding: 2px 5px 3px;">' +
                    '</div>';
                break;
            case 11://上传队列单个个文件
                i_dom += '<div id="queue" class="single_queue"></div>';
                break;
            case 12:// 水平关联设置
                i_dom = '<div class="template-columns-wrap" >' +
                    '<div class="template-columns-item" >' +
                    '<input id="h_relationship_search">'+
                    '<table id="h_relationship_src" ></table>' +
                    '</div>' +
                    '<div class="template-columns-bnt">' +
                    '<a href="javascript:;" class="move-bnt" onclick="Strack.remove_h_relate_set(this)"><i class="icon-uniF100"></i></a>'+
                    '<a href="javascript:;" class="move-bnt" onclick="Strack.move_to_h_relation_panel(this)"><i class="icon-uniF101"></i></a>'+
                    '</div>' +
                    '<div class="template-columns-item" >' +
                    '<table id="h_relationship_dst" ></table>' +
                    '</div>' +
                    '</div>';
                break;
            case 14:
                // note 图片列表
                i_dom = '<div id="dialog_img_list" class="dialog-imgs"></div>';
                break;
            case 101:
                // 隐藏输入域
                i_dom = '<input id="' + items.id + '" class="dialog-widget-val" data-widget="input" type="' + items.type + '" data-name="' + items.name + '"  data-valid="' + items.valid + '" value="' + items.value + '">';
                break;
            case 102://canvas画布
                i_dom = '<div id="' + items.id + '" class="hidden"></div>';
                break;
            case 103:// add field combobox list
                i_dom = '<div id="dg_comb_list" class="dg-comb-list"></div>';
                break;
            case 104://add field display
                i_dom = '<div id="dg_comb_display" class="dg-cb-display">' +
                    '<div class="dgcb-disp-name aign-left">' +
                    StrackLang["Summafield"] +
                    '</div>' +
                    '<div class="dgcb-disp-input aign-left">' +
                    '<input id="Fdgcb_field" >' +
                    '</div>' +
                    '<div class="dgcb-cal-name aign-left">' +
                    StrackLang["Calculation"] +
                    '</div>' +
                    '<div class="dgcb-cal-input aign-left">' +
                    '<input id="Fdgcb_cal" >' +
                    '</div>' +
                    '</div>';
                break;
            case 105://add field query
                i_dom = '<div id="dg_comb_query" class="dg-cb-query">' +
                    '<div class="dgcb-query-all">' +
                    '<div class="query-all-name aign-left">' + StrackLang["ConditionalLogic"] + '</div>' +
                    '<div class="query-all-input aign-left"><input id="logic_comb"></div>' +
                    '<a href="javascript:;" onclick="Strack.add_filter_group(this)" class="query-all-btn aign-left"><i class="icon-uniEA33"></i>' + StrackLang["AddFilterGroup"] + '</a>' +
                    '</div>' +
                    '<div id="dgcb_qwrap" class="dgcb-query-wrap">' +
                    '</div>' +
                    '</div>';
                break;
            case 106://advance sort dom
                i_dom = '<div class="st-dialog-items">' +
                    '<div class="st-dialog-name">' + items.lang + '</div>' +
                    '<div id="shang_' + items.index + '" class="st-dialog-input" data-name="' + items.index + '" style="overflow: hidden;">' +
                    '<div class="input-left aign-left">' +
                    '<input  id="sort_' + items.index + '" autocomplete="off" type="text">' +
                    '</div>' +
                    '<div class="input-right aign-left">' +
                    '<input id="sort_' + items.index + '_func" autocomplete="off" type="text">' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                break;
            case 107:
                i_dom = '<div class="template-columns-wrap" >' +
                    '<div class="template-columns-item template-margin" >' +
                    '<div id="template_field" ></div>' +
                    '</div>' +
                    '<div class="template-columns-item" >' +
                    '<input id="m_view_id" value="0" type="hidden"/>' +
                    '<div class="st-dialog-items">' +
                    '<div class="st-dialog-name">' + StrackLang['Name'] + '</div>' +
                    '<div class="st-dialog-input"><input id="m_view_name" /></div>' +
                    '</div>' +
                    '<div class="st-dialog-items">' +
                    '<div class="st-dialog-name">' + StrackLang['Public'] + '</div>' +
                    '<div class="st-dialog-input"><input id="m_view_share" /></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                break;
            case 108://tow input dom
                i_dom = '<div class="st-dialog-items">' +
                    '<div class="st-dialog-input" data-name="' + items.index + '" style="overflow: hidden;">' +
                    '<div class="input-left aign-left">' +
                    '<input  id="first_' + items.index + '" autocomplete="off" type="text">' +
                    '</div>' +
                    '<div class="input-right aign-left">' +
                    '<input id="second_' + items.index + '" autocomplete="off" type="text">' +
                    '</div>' +
                    '<a href="javascript:;" class="a-close-bnt aign-left" onclick="Strack.remove_parent(this)">' +
                    '<i class=" icon-uniE6DB"></i>' +
                    '</a>' +
                    '</div>' +
                    '</div>';
                break;
            case 109:// add field status combobox list
                i_dom = '<div id="dg_status_comb_list" class="dg-comb-list"></div>';
                break;
            default :
                i_dom = '404';
                break;
        }
        return i_dom;
    },
    dialog_base_item: function (lang, data) {
        var dim = '<div class="st-dialog-items">';
        var required = data["valid"].length > 0 ? 'required' : '';
        switch (parseInt(data["case"])) {
            case 103:
                dim += '<div class="st-dialog-name ' + required + '">' +
                    '<div class="g-comb-name aign-left">' + lang + '</div>' +
                    '<a href="javascript:;" onclick="Strack.add_cf_comb_item(this)" class="dg-comb-add aign-left"><i class="icon-uniEA33 icon-right"></i></a>' +
                    '</div>';
                break;
            case 109:
                dim += '<div class="st-dialog-name ' + required + '">' +
                    '<div class="g-comb-name aign-left">' + lang + '</div>' +
                    '<a href="javascript:;" onclick="Strack.add_cf_status_comb_item(this)" class="dg-comb-add aign-left"><i class="icon-uniEA33 icon-right"></i></a>' +
                    '</div>';
                break;
            default:
                dim += '<div class="st-dialog-name ' + required + '">' + lang + '</div>';
                break;
        }
        dim += '<div class="st-dialog-input">' + Strack.dialog_items(data) + '</div>' + '</div>';
        return dim;
    },
    // 填充数据表格边侧栏页面参数
    fill_slider_page_param: function (param)
    {
        $("#datagrid_slider_action").attr("data-moduleid", param["module_id"])
            .attr("data-projectid", param["project_id"])
            .attr("data-linkid", param["item_id"]);

        $("#datagrid_top_fields_config").attr("data-id", param["item_id"])
            .attr("data-page", param["page"])
            .attr("data-moduleid", param["module_id"])
            .attr("data-modulecode", param["module_code"])
            .attr("data-projectid", param["project_id"])
            .attr("data-templateid", param["template_id"]);
    },
    // 打开数据表格边侧栏
    open_datagrid_slider: function (param){
        var $main_dom = $("#datagrid_slider");
        $main_dom.show()
            .addClass("grid-slider-in");

        // 填充dom参数
        Strack.fill_slider_page_param(param);

        Strack.G.gridSliderParam = param;

        // 加载数据表格边侧栏顶部面包屑
        Strack.init_breadcrumb("datagrid_slider_breadcrumb", param);

        // 加载数据表格边侧栏顶部缩略图
        Strack.get_datagrid_slider_thumb(param);

        // 加载数据表格边侧栏顶部信息数据
        Strack.get_datagrid_slider_topinfo(param);

        // 加载数据表格边侧栏动态生成Tabs
        param["position"] = "grid_slider";


        Strack.init_tab_list("grid_slider_tab", param, function (data) {
            // 加载数据表格
            var first_tab = null;
            if(!$.isEmptyObject(Strack.G.gridSliderActiveTab)){
                first_tab = Strack.G.gridSliderActiveTab;
            }else {
                data.forEach(function (val) {
                    if (!first_tab) {
                        first_tab = val;
                    }
                });
            }

            Strack.show_datagrid_slider_tab(first_tab);
        });



        // 初始化页面调整事件
        if(!$main_dom.hasClass("init-active")){
            $main_dom.addClass("init-active");
            Strack.init_grid_resize_envent($main_dom);
        }

        //定时300ms后删除in css动画
        setTimeout(function () {
            $main_dom.removeClass("grid-slider-in");
        }, 300);
    },
    // 关闭数据表格边侧栏
    close_datagrid_slider: function(i)
    {
        var $grid_slider = $('#datagrid_slider');
        $grid_slider.addClass("grid-slider-out");

        Strack.G.gridSliderParam = {};

        //定时500ms后销毁dom
        setTimeout(function () {
            $grid_slider.hide().removeClass("grid-slider-out");
        }, 500);
    },
    // 获取边侧栏缩略图
    get_datagrid_slider_thumb: function(param)
    {
        $.ajax({
            type: 'POST',
            url: StrackPHP['getDetailTopThumb'],
            data: param,
            dataType: 'json',
            beforeSend: function () {
                $('#grid_slider_thumb').prepend(Strack.loading_dom('white', '', 'slider_thumb'));
            },
            success: function (data) {
                var media_data = data['data'];
                media_data['link_id'] = param["item_id"];
                media_data['module_id'] = param["module_id"];
                media_data['param']['icon'] = "icon-uniE61A";
                Strack.thumb_media_widget('#grid_slider_thumb', media_data, {modify_thumb:param.rule_side_thumb_modify, clear_thumb:param.rule_side_thumb_clear});
                $('#st-load_slider_thumb').remove();
            }
        });
    },
    // 加载数据表格边侧栏顶部信息数据
    get_datagrid_slider_topinfo:function(param){
        param["category"] = "top_field";
        var $grid_slider_tg_bnt = $("#grid_slider_tg_bnt");
        $grid_slider_tg_bnt.hide();
        Strack.G.sliderTopfieldsRequestParam = {
            id: "#grid_slider_top_info",
            mask: 'top_info',
            pos: 'min',
            url: StrackPHP["getModuleItemInfo"],
            data: param,
            loading_type: 'white'
        };
        Strack.load_info_panel(Strack.G.sliderTopfieldsRequestParam, function (data) {
            $grid_slider_tg_bnt.attr("data-linkid", param["item_id"])
                .attr("data-moduleid", param["module_id"]);
            if(param["module_code"] === "base" && param["is_my_task"] === "yes") {
                $grid_slider_tg_bnt.show();
                Strack.init_timelog_bnt('#grid_slider_tg_bnt', data["timelog"]);
            }
        });
    },
    // 加载数据边侧栏数据
    show_datagrid_slider_tab: function(tab_param)
    {
        if(tab_param){
            Strack.G.gridSliderActiveTab = tab_param;
            Strack.active_select_tab("grid_slider_tab", tab_param.tab_id);
            $(".grid-slider-main .pitem-wrap").hide();
            var $tab_page;
            var request_filter = [];
            var grid_param = Strack.deep_copy(Strack.G.gridSliderParam);
            switch (tab_param.type) {
                case "fixed":
                    if($.inArray(tab_param.tab_id, ["correlation_base", "file_commit", "file", "base"]) >= 0){
                        $tab_page = $("#grid_slider_tab_table");
                        $tab_page.show();
                        switch (tab_param.tab_id) {
                            case "base":
                                request_filter = [
                                    {
                                        field: 'id',
                                        value: grid_param.item_id,
                                        condition: 'NEQ',
                                        module_code: tab_param.module_code,
                                        table: 'Base'
                                    }
                                ];
                                break;
                            case "file":
                                request_filter = [
                                    {
                                        field: 'module_id',
                                        value: grid_param.module_id,
                                        condition: 'EQ',
                                        module_code: tab_param.tab_id,
                                        table: 'File'
                                    },
                                    {
                                        field: 'link_id',
                                        value: grid_param.item_id,
                                        condition: 'EQ',
                                        module_code: tab_param.tab_id,
                                        table: 'File'
                                    }
                                ];
                                break;
                            case "file_commit":
                                request_filter = [
                                    {
                                        field: 'module_id',
                                        value: grid_param.module_id,
                                        condition: 'EQ',
                                        module_code: tab_param.tab_id,
                                        table: 'File'
                                    },
                                    {
                                        field: 'link_id',
                                        value: grid_param.item_id,
                                        condition: 'EQ',
                                        module_code: tab_param.tab_id,
                                        table: 'File'
                                    }
                                ];
                                break;
                            case "correlation_base":
                                request_filter = [
                                    {
                                        field: 'id',
                                        value: grid_param.item_id,
                                        condition: 'NEQ',
                                        module_code: grid_param.module_code,
                                        table: 'Base'
                                    },
                                    {
                                        field: 'entity_id',
                                        value: grid_param.entity_id,
                                        condition: 'EQ',
                                        module_code: grid_param.module_code,
                                        table: 'Base'
                                    }
                                ];
                                break;
                        }
                        Strack.load_grid_slider_grid_data(grid_param, tab_param, request_filter);
                    }else {
                        $tab_page = $("#grid_slider_tab_" + tab_param.tab_id);
                        $tab_page.show();
                        switch (tab_param.tab_id) {
                            case "note":
                                // 动态页面
                                Strack.grid_slider_note_panel();
                                break;
                            case "info":
                                // 详细信息页面
                                Strack.grid_slider_info_panel();
                                break;
                            case "history":
                                // 历史记录页面
                                Strack.grid_slider_history_panel();
                                break;
                            case "onset":
                                // 现场数据页面
                                Strack.grid_slider_onset_panel();
                                break;
                            case "onset_att":
                                // 现场数据页面
                                Strack.grid_slider_onset_att_panel();
                                break;
                        }
                    }
                    break;
                case "entity_child":
                case "horizontal_relationship":
                case "be_horizontal_relationship":
                    $tab_page = $("#grid_slider_tab_table");
                    $tab_page.show();
                    Strack.load_grid_slider_grid_data(grid_param, tab_param, request_filter);
                    break;
                case "other_page":
                    $tab_page = $("#grid_slider_tab_iframe_page");
                    $tab_page.show();
                    switch (tab_param.tab_id){
                        case "cloud_disk":
                            Strack.grid_slider_cloud_disk_panel();
                            break;
                    }
                    break;
            }
        }
    },
    // 加载数据边侧栏note页面数据
    grid_slider_note_panel:function(){
        var note_param = Strack.deep_copy(Strack.G.gridSliderParam);
        note_param['status'] = 'new';
        note_param['page_number'] = 1;
        note_param['page_size'] = 20;
        Strack.load_notes({
            page_id: '#slider_note_list',
            content_id: '.grid-slider-main',
            avatar_id: '',
            editor_id: 'grid_slider_comments_editor',
            list_id: 'grid_slider_comments_list',
            tab_id: '.grid_slider_tab',
            details_top_bar: false,
            tab_bar_id: ''
        }, note_param);
    },
    // 加载数据边侧栏信息页面数据
    grid_slider_info_panel: function()
    {
        var info_param = Strack.deep_copy(Strack.G.gridSliderParam);
        info_param["category"] = "main_field";
        Strack.load_info_panel({
            id: "#grid_slider_info_main",
            mask: 'main_info',
            pos: 'max',
            url: StrackPHP["getModuleItemInfo"],
            data: info_param,
            loading_type: 'white'
        });
    },
    // 边侧栏云盘页面数据
    grid_slider_cloud_disk_panel: function()
    {
        var param = Strack.deep_copy(Strack.G.gridSliderParam);
        $.ajax({
            type: 'POST',
            url: StrackPHP['getDataGridSliderOtherPageData'],
            data: {
                type: 'cloud_disk',
                project_id: param.project_id,
                module_code: param.module_code,
                module_type: param.module_type,
                item_id: param.item_id
            },
            beforeSend: function () {
                $('#grid_slider_tab_iframe_page').prepend(Strack.loading_dom('white','','slider_iframe_page'));
            },
            success: function (data) {
                if(parseInt(data['status']) === 200){
                    $('#grid_slider_tab_iframe_page').empty()
                        .append('<iframe src="'+data['data']['cloud_disk_url']+'" class="page-iframe-base page-iframe-wh-100"></iframe>');
                }else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
                $("#st-load_slider_iframe_page").remove();
            }
        });
    },
    // 边侧栏现场数据查看
    grid_slider_onset_panel: function()
    {
        // 判断当前实体是否已经关联了OnSet数据，获取可以显示OnSet任务所属实体是否关联了OnSet数据
        $("#grid_slider_onset_entity_not_exit,#grid_slider_onset_link_not_exit,#grid_slider_onset_info_main").hide();
        Strack.get_item_onset_data( Strack.G.gridSliderParam, function (data) {
            if(parseInt(data["status"]) === 200){
                if(data["data"]["has_link_onset"] === "yes"){
                    // 加载 Onset 现场数据
                    $("#grid_slider_onset_info_main").show();
                    Strack.grid_slider_load_onset_info(data["data"]);
                }else {
                    $("#grid_slider_onset_link_not_exit").show();
                    $("#grid_slider_onset_select_module_id").val(data["data"]["module_id"]);
                    $("#grid_slider_onset_select_entity_id").val(data["data"]["entity_id"]);
                    $("#grid_slider_onset_select_entity_module_id").val(data["data"]["entity_module_id"]);
                    Strack.combobox_widget('#grid_slider_onset_select_list', {
                        url: StrackPHP["getProjectOnsetList"],
                        valueField: 'id',
                        textField: 'name',
                        width: 300,
                        height: 30,
                        queryParams: {
                            "project_id" : Strack.G.gridSliderParam.project_id
                        }
                    });
                }
            }else {
                // 当前任务模块没有关联实体
                $("#grid_slider_onset_entity_not_exit").show();
            }
        });
    },
    // 边侧栏现场数据附件
    grid_slider_onset_att_panel: function()
    {
        // 判断当前实体是否已经关联了OnSet数据，获取可以显示OnSet任务所属实体是否关联了OnSet数据
        $("#grid_slider_onset_att_entity_not_exit,#grid_slider_onset_att_link_not_exit,#grid_slider_onset_att_link_main").hide();
        Strack.get_item_onset_data( Strack.G.gridSliderParam, function (data) {
            if(parseInt(data["status"]) === 200){
                if(data["data"]["has_link_onset"] === "yes"){
                    // 加载 Onset 现场数据
                    $("#grid_slider_onset_att_link_main").show();

                    Strack.grid_slider_load_onset_attachment({
                        module_id : data["data"]["module_id"],
                        onset_id : data["data"]["onset_id"]
                    });
                }else {
                    $("#grid_slider_onset_att_link_not_exit").show();
                    $("#grid_slider_onset_att_select_module_id").val(data["data"]["module_id"]);
                    $("#grid_slider_onset_att_select_entity_id").val(data["data"]["entity_id"]);
                    $("#grid_slider_onset_att_select_entity_module_id").val(data["data"]["entity_module_id"]);
                    Strack.combobox_widget('#grid_slider_onset_att_select_list', {
                        url: StrackPHP["getProjectOnsetList"],
                        valueField: 'id',
                        textField: 'name',
                        width: 300,
                        height: 30,
                        queryParams: {
                            "project_id" : Strack.G.gridSliderParam.project_id
                        }
                    });
                }
            }else {
                // 当前任务模块没有关联实体
                $("#grid_slider_onset_att_entity_not_exit").show();
            }
        });
    },
    // 添加关联onset
    add_link_onset: function(i)
    {
        var tab = $(i).attr("data-tab");
        var dom_id = tab === "info" ? 'grid_slider_onset_add_link_onset' : 'grid_slider_onset_att_add_link_onset';
        var formData = Strack.validate_form(dom_id);
        if(parseInt(formData['status']) === 200){
            $.ajax({
                type: 'POST',
                url: StrackPHP['addEntityLinkOnset'],
                data: formData["data"],
                dataType: 'json',
                beforeSend: function () {
                    $('#grid_slider_tab_onset_att').prepend(Strack.loading_dom('white', '', 'onset_add'));
                },
                success: function (data) {
                    if(parseInt(data['status']) === 200){
                        Strack.top_message({bg:'g',msg: data['message']});
                        if(tab === "info"){
                            $('#grid_slider_onset_select_list').combobox("clear");
                            $("#grid_slider_onset_entity_not_exit,#grid_slider_onset_link_not_exit").hide();
                            $("#grid_slider_onset_info_main").show();
                            Strack.grid_slider_load_onset_info(data["data"]);
                        }else {

                            $('#grid_slider_onset_att_select_list').combobox("clear");
                            $("#grid_slider_onset_att_entity_not_exit,#grid_slider_onset_att_link_not_exit").hide();
                            $("#grid_slider_onset_att_link_main").show();
                            Strack.grid_slider_load_onset_attachment({
                                module_id : formData['data']['onset_module_id'],
                                onset_id : formData['data']['onset_id']
                            });
                        }
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                    $('#st-load_onset_add').remove();
                }
            });
        }
    },
    // 初始化边侧栏现场数据信息
    grid_slider_load_onset_info: function(onset_param)
    {
        // 加载 Onset 现场数据
        var onset_info_param = Strack.deep_copy(Strack.G.gridSliderParam);
        onset_info_param["category"] = "detail_onset_field";
        onset_info_param["module_id"] = onset_param["entity_module_id"];
        onset_info_param["onset_id"] = onset_param["onset_id"];

        Strack.load_info_panel({
            id: "#grid_slider_onset_info",
            mask: 'grid_slider_onset_info',
            pos: 'onset',
            url: StrackPHP["getOnsetInfoData"],
            data: onset_info_param,
            loading_type: 'white'
        }, function (data) {
        });
    },
    // 初始化边侧栏现场数据附件
    grid_slider_load_onset_attachment: function(onset_param)
    {
        $("#grid_slider_onset_att_bnt").attr("data-linkid", onset_param["onset_id"])
            .attr("data-moduleid", onset_param["module_id"]);

        Strack.load_onset_attachment("#grid_slider_onset_att_wrap",{
            module_id : onset_param["module_id"],
            link_id : onset_param["onset_id"]
        });
    },
    // 边侧栏历史记录查看
    grid_slider_history_panel: function()
    {
        var history_param = Strack.deep_copy(Strack.G.gridSliderParam);
        history_param['status'] = 'new';
        history_param['page_number'] = 1;
        history_param['page_size'] = 30;
        Strack.grid_slider_history_data(history_param);
    },
    // 获取数据表格边侧栏历史数据
    grid_slider_history_data: function(param){
        $.ajax({
            type: 'POST',
            url: StrackPHP['getDataGridSliderHistoryData'],
            data: param,
            beforeSend: function () {
                $('#grid_slider_tab_history').prepend(Strack.loading_dom('white','','slider_history'));
            },
            success: function (data) {
                var $list_id = $("#grid_slider_history");

                //第一次加载时触发
                if (param.status === 'new') {
                    // 给列表dom添加class标识
                    param.total = data['total'];

                    Strack.fall_load_data("#grid_slider_history", param,
                        function (data) {
                            param.status = 'more';
                            Strack.grid_slider_history_data(ids, param);
                        });

                    $list_id.empty();

                    $('#st-load_slider_history').remove();
                }

                $list_id.append(Strack.grid_slider_history_list_dom(data['rows']));
            }
        });
    },
    // 边侧栏数据表格
    load_grid_slider_grid_data: function(grid_param, tab_param, request_filter) {
        $.ajax({
            type: 'POST',
            url: StrackPHP['getDataGridSliderTableConfig'],
            data: JSON.stringify({
                tab_param : tab_param,
                grid_param : grid_param
            }),
            dataType: 'json',
            contentType: "application/json",
            beforeSend: function () {
                $('#grid_slider_tab_table').prepend(Strack.loading_dom('white','','slider_table'));
            },
            success: function (data) {
                if(parseInt(data["status"]) === 200){
                    Strack.init_grid_slider_grid_data(grid_param, tab_param, data, request_filter);
                }
                $("#st-load_slider_table").remove();
            }
        });
    },
    // 实例化边侧栏数据表格
    init_grid_slider_grid_data: function(grid_param, tab_param, columns_data, request_filter)
    {
        //过滤条件
        var c_request_filter = request_filter ? request_filter : [];

        var param = {
            page: 'details_' + tab_param.tab_id,
            schema_page: Strack.generate_schema_page(tab_param["module_code"]),
            module_id: tab_param["module_id"],
            project_id: grid_param["project_id"],
            item_id: grid_param["item_id"],
            grid_id: 'grid_slider_datagrid_box',
            view_type: "grid",
        };

        var data = Strack.generate_grid_columns_data(param, columns_data);

        var filter_data = {
            filter: {
                temp_fields: {
                    add: {},
                    cut: {}
                },
                group: data['grid']["group_name"],
                sort: data['grid']["sort_config"]["sort_query"],
                request:c_request_filter,
                filter_input: data['grid']["filter_config"]["filter_input"],
                filter_panel: data['grid']["filter_config"]["filter_panel"],
                filter_advance: data['grid']["filter_config"]["filter_advance"]
            },
            page: param["page"],
            schema_page: param["schema_page"],
            module_id: param["module_id"],
            project_id: grid_param["project_id"],
            item_id: grid_param["item_id"],
            module_code: tab_param["tab_id"],
            module_type: tab_param["type"],
            horizontal_type: tab_param["horizontal_type"],
            parent_module_id: grid_param["module_id"]
        };

        var $tab_single_grid = $("#grid_slider_tab_table");

        if ($tab_single_grid.hasClass("load_active")) {
            // datagrid 配置参数
            gird_param = {
                moduleId: tab_param['module_id'],
                projectId: param['project_id'],
                queryParams: {
                    filter_data: JSON.stringify(filter_data)
                },
                panelConfig: {
                    active_filter_id: data['grid']["filter_config"]["filter_id"]
                },
                sortConfig: data['grid']["sort_config"],
                sortData: data['grid']["sort_config"]["sort_data"],
                renderNewPage: true,
                columnsFieldConfig: data['grid']["columnsFieldConfig"],
                frozenColumns: data['grid']["frozenColumns"],
                columns: data['grid']["columns"],
            };

            //是否应用分组
            if (!$.isEmptyObject(data['grid']["group_name"])){
                gird_param["groupActive"] = true;
                gird_param["groupField"] = Strack.get_grid_group_field(data['grid']["group_name"])["field"];
                gird_param["groupFormatter"] = function (value, rows) {
                    return '<span class="">' + value + '( ' + rows.length + ' )</span>';
                };
            }

            // 重置 datagrid 数据
            $('#grid_slider_datagrid_box').datagrid("setOptions", gird_param)
                .datagrid('reload');
        }else {
            // 第一次加载初始化
            $tab_single_grid.addClass("load_active");

            // datagrid 配置参数
            var gird_param = {
                url: StrackPHP['getDetailGridData'],
                height: Strack.panel_height(".grid-slider-tab-table", 215),
                view: scrollview,
                rowheight: 50,
                differhigh: false,
                singleSelect: false,
                adaptive: {
                    dom: "#datagrid_slider",
                    min_width: 680,
                    exth: 215,
                    domresize: 1
                },
                ctrlSelect: true,
                multiSort: true,
                DragSelect: true,
                moduleId: param['module_id'],
                projectId: param['project_id'],
                queryParams: {
                    filter_data: JSON.stringify(filter_data)
                },
                panelConfig: {
                    active_filter_id: data['grid']["filter_config"]["filter_id"]
                },
                sortConfig: data['grid']["sort_config"],
                sortData: data['grid']["sort_config"]["sort_data"],
                columnsFieldConfig: data['grid']["columnsFieldConfig"],
                frozenColumns: data['grid']["frozenColumns"],
                columns: data['grid']["columns"],
                toolbar: '#grid_slider_tb',
                pagination: true,
                pageNumber: 1,
                pageSize: 200,
                pageList: [100, 200, 300, 400, 500],
                pagePosition: 'bottom',
                remoteSort: false
            };

            //是否应用分组
            if (!$.isEmptyObject(data['grid']["group_name"])) {
                gird_param["groupActive"] = true;
                gird_param["groupField"] = Strack.get_grid_group_field(data['grid']["group_name"])["field"];
                gird_param["groupFormatter"] = function (value, rows) {
                    return '<span class="">' + value + '( ' + rows.length + ' )</span>';
                };
            }

            $('#grid_slider_datagrid_box').datagrid(gird_param)
                .datagrid('enableCellEditing')
                .datagrid('disableCellSelecting')
                .datagrid('gotoCell',
                    {
                        index: 0,
                        field: 'id'
                    }
                ).datagrid('columnMoving');
        }
    },
    // 边侧栏历史dom
    grid_slider_history_list_dom: function(data){
        var dom = '';
        data.forEach(function (val) {
            dom += Strack.grid_slider_history_item_dom(val);
        });
        return dom;
    },
    // 边侧栏历史记录DOM
    grid_slider_history_item_dom: function(data)
    {
        var dom = '', title='';

        switch (data["operate"]){
            case "update":
                title += data["created_by"]+' '+ StrackLang["Modify"]+' '+data["module_name"]+' '+data["link_name"]+' ( '+data['id']+' )';
                break;
            case "create":
                title += data["created_by"]+' '+ StrackLang["Create"]+' '+data["module_name"]+' '+data["link_name"]+' ( '+data['id']+' )';
                break;
            case "delete":
                title += data["created_by"]+' '+ StrackLang["Delete"]+' '+data["module_name"]+' '+data["link_name"]+' ( '+data['id']+' )';
                break;
        }

        dom += '<div class="history-items">'+
            '<div class="history-items-thumb">'+
            Strack.build_avatar(data["avatar"]["id"], data["avatar"]["avatar"], Strack.upper_first_str(data["avatar"]["pinyin"]))+
            '</div>'+
            '<div class="history-items-info">'+
            '<div class="history-content text-ellipsis">'+title+'</div>'+
            '<div class="history-date">'+
            data["created"] +
            '</div>'+
            '</div>'+
            '</div>';
        return dom;
    },
    /**
     * 绑定当前边侧栏resize事件
     * 面板最小宽度 离右边 600px
     * 面板最大宽度 离左边 400px
     * @param $main_dom
     */
    init_grid_resize_envent: function ($main_dom) {
        var $dotted_dom = $main_dom.find('.grid-slider-dotted'),
            $wrap_dom = $main_dom.find('.grid-slider-wrap'),
            $handle_dom = $main_dom.find('.x-resizable-handle');
        var c_left, c_width, min_width;
        $handle_dom.on('mousedown', function (e) {
            e.preventDefault();
            //mousemove 鼠标按下 绑定鼠标移动事件
            //mouseup 鼠标释放 解除鼠标移动事件
            $(document).on("mousemove", function (e) {
                //鼠标当前坐标
                c_left = e.pageX;
                min_width = document.documentElement.clientWidth - 660;
                //动态改变虚线框
                c_left = c_left <= 400 ? 400 : c_left > min_width ? min_width : c_left;
                c_width = document.documentElement.clientWidth - c_left;
                $dotted_dom.show()
                    .addClass("st_wrap_dotted")
                    .css({"width": c_width + 'px'});
                $main_dom.css({'left': c_left + 'px'});
            }).on("mouseup", function (e) {
                $(this).off("mousemove");
                $dotted_dom.hide()
                    .removeClass("st_wrap_dotted");
                $wrap_dom.css({"width": c_width + 'px'});
            });
        });
    },
    // top menu 方法
    switch_top_nav: function (i) {
        var tools = $(i).attr("data-tools");
        switch (tools){
            case 'timelog':
                Strack.load_side_timelog('active');
                break;
            case 'inbox':
                Strack.load_side_inbox('all');
                break;
        }
        $('#tools_slider_' + tools).sidebar('toggle');
    },
    // 切换边侧栏 Tab
    toggle_slider_tab: function(i)
    {
        var panel = $(i).attr("data-panel"),
            tab = $(i).attr("data-tab");
        switch (panel){
            case 'timelog':
                Strack.load_side_timelog(tab);
                break;
            case 'inbox':
                Strack.load_side_inbox(tab);
                break;
        }
    },
    // 加载消息盒子边侧栏数据
    load_side_inbox: function(tab){
        // 激活面板tab标签
        $("#slider_inbox_wrap")
            .find(".sd-msg-tab")
            .removeClass("active");
        $("#slider_msg_tab_"+tab).addClass("active");
        $(".slider-inbox-list").removeClass('active');
        $("#slider_msg_main_"+tab).addClass('active');
        $("#slider_msg_refresh").attr("data-tab", tab);

        Strack.load_side_inbox_data(tab, {
            page_number : 1,
            page_size : 30,
            tab: tab,
            status: 'new'
        });
    },
    // 加载消息盒子数据
    load_side_inbox_data: function(tab, param)
    {
        var page = '#slider_msg_list_'+tab;
        var $list_dom = $(page);

        // 标记已读消息
        Strack.marked_read_message();

        $.ajax({
            type: 'POST',
            url: StrackPHP['getSideInboxData'],
            dataType: 'json',
            contentType: "application/json",
            data: JSON.stringify(param),
            beforeSend: function () {
                $('#slider_inbox_wrap').prepend(Strack.loading_dom('white', '', 'inbox'));
            },
            success: function (data) {

                if(param.status === 'new'){
                    if(data.total > 0){
                        $list_dom.empty();
                        param.status = 'more';
                        param.total = data.total;
                        Strack.fall_load_data(page, param,
                            function (res_data) {
                                Strack.load_side_inbox_data(tab, param);
                            }
                        );
                    }else {
                        $list_dom.html('<div class="datagrid-empty-no text-center">'+StrackLang["Datagird_No_Data"]+'</div>');
                    }
                }

                Strack.fill_inbox_list($list_dom, data.rows);

                $("#st-load_inbox").remove();
            }
        });
    },
    // 标记已读消息
    marked_read_message: function()
    {
        if(Strack.G.UnReadMessageData && Strack.G.UnReadMessageData.created > 0){
            $.ajax({
                type: 'POST',
                url: StrackPHP['readMessage'],
                dataType: 'json',
                data: {
                    created : Strack.G.UnReadMessageData.created
                },
                success: function (data) {
                    if(parseInt(data["status"]) === 200){
                        Strack.G.UnReadMessageData.created = 0;
                        Strack.G.UnReadMessageData.massage_number = 0;
                        Strack.top_tool_number('#top_msg_number', 0);
                    }
                }
            });
        }
    },
    // 刷新inbox消息盒子
    refresh_inbox_slider: function(i){
        var tab = $(i).attr("data-tab");
        Strack.load_side_inbox_data(tab, {
            page_number : 1,
            page_size : 30,
            tab: tab,
            status: 'new'
        });
    },
    // 填充inbox数据
    fill_inbox_list: function($list_dom, data){
        data.forEach(function (val) {
            $list_dom.append(Strack.inbox_list_dom(val));
        });
    },
    // inbox 消息盒子
    inbox_list_dom: function(data) {
        var dom = '';
        dom += '<div class="event">'+
            '<div class="label">'+
            '<img src="'+data['user_avatar']+'">'+
            '</div>'+
            '<div class="content">';

        // 消息头
        dom += Strack.inbox_list_title_item_dom(data['content'], data['created']);

        // 更新项信息
        dom += Strack.inbox_list_text_item_dom(data['content']["operate"], data['content']['update_list']);

        // 图片附件
        dom += Strack.inbox_list_img_item_dom(data['media_data']);

        dom += '</div>';

        return dom;
    },
    // inbox 消息盒子 title dom
    inbox_list_title_item_dom: function(content, created) {
        var dom = '';
        dom +='<div class="summary">'+
            '<a class="user">'+content["title"]["created_by"]+'</a>'+
            Strack.inbox_list_title_lang(content["operate"])+
            '<a class="project"> '+content["title"]["module_name"]+
            ' '+content["title"]["item_name"]+
            '</a>'+
            '<div class="date">'+ created +'</div>'+
            '</div>';
        return dom;
    },
    // inbox 消息盒子 title lang
    inbox_list_title_lang: function(operate) {
        var lang = '';
        switch (operate){
            case "add":
                lang = StrackLang["Create"];
                break;
            case "update":
                lang = StrackLang["Modify"];
                break;
            case "delete":
                lang = StrackLang["Delete"];
                break;
        }
        return lang;
    },
    // inbox 消息盒子 text dom
    inbox_list_text_item_dom: function(operate, update_list) {
        var dom = '';
        if(update_list.length > 0){
            var item_dom = '';
            update_list.forEach(function (val) {
                item_dom += Strack.inbox_list_item_dom(operate, val);
            });
            dom += '<div class="extra text">'+
                item_dom +
                '</div>';
        }
        return dom;
    },
    // inbox 消息盒子 item dom
    inbox_list_item_dom: function(operate, item) {
        var dom = '', icon='', color = '';
        switch (operate){
            case "add":
                icon = 'info';
                color = 'blue';
                break;
            case "update":
                icon = 'checkmark';
                color = 'green';
                break;
            case "delete":
                icon = 'minus';
                color = 'red';
                break;
        }
        dom += '<div class="item">'+
            '<i class="'+icon+' box icon '+color+'"></i>'+
            '<a style="margin: 0 5px">'+item["field"]+'</a>'+
            item["value"]+
            '</div>';
        return dom;
    },
    // inbox 消息盒子 img item dom
    inbox_list_img_item_dom: function(media_data){
        var dom = '';
        if(media_data["has_media"] === "yes"){
            var main_random_id = 'main_'+Math.floor(Math.random() * 10000 + 1);
            dom += '<div class="extra images">'+
                '<div class="note-att" >'+
                Strack.show_note_img_att(main_random_id, media_data) +
                '</div>'+
                '</div>';
        }
        return dom;
    },
    // 加载时间日志边侧栏数据
    load_side_timelog: function (tab) {

        // 激活面板tab标签
        $("#slider_timelog_wrap")
            .find(".sd-tg-tab")
            .removeClass("active");
        $("#slider_tg_tab_"+tab).addClass("active");
        $(".slider-menu-main").removeClass('active');
        $("#slider_tg_main_"+tab).addClass('active');
        $("#slider_tg_refresh").attr("data-tab", tab);

        Strack.G.sideTimelogParam = Strack.generate_hidden_param("#side_timelog_hidden_param");

        switch (tab){
            case 'active':
                $.ajax({
                    type: 'POST',
                    url: StrackPHP['getSideTimelogMyTimer'],
                    dataType: 'json',
                    contentType: "application/json",
                    beforeSend: function () {
                        $('#slider_timelog_wrap').prepend(Strack.loading_dom('white', '', 'timelog'));
                        $('#slider_timer_list').empty();
                    },
                    success: function (data) {
                        data.forEach(function (val) {
                            Strack.init_active_timer(val);
                        });
                        Strack.check_timer_exit();
                        $("#st-load_timelog").remove();
                    }
                });
                break;
            case 'history':
                Strack.load_timelog_slider_history('#slider_tg_history_list',{
                    page_number : 1,
                    page_size : 100,
                    status: 'new'
                });
                break;
        }
    },
    // 获取我的timelog记录数据
    load_timelog_slider_history: function(page_id, param){

        $.ajax({
            type: 'POST',
            url: StrackPHP['getSideTimelogMyData'],
            dataType: 'json',
            data: {
                page_number: param.page_number,
                page_size: param.page_size
            },
            beforeSend: function () {
                $('#slider_timelog_wrap').prepend(Strack.loading_dom('white', '', 'timelog'));
            },
            success: function (data) {

                if(param.status === 'new'){
                    $(page_id).empty();
                    param.status = 'more';
                    param.total = data.total;
                    Strack.fall_load_data(page_id, param,
                        function (res_data) {
                            Strack.load_timelog_slider_history(page_id, param);
                        }
                    );
                }

                Strack.fill_timelog_history_list(page_id, data.rows);

                $("#st-load_timelog").remove();
            }
        });
    },
    // 填充timelog history 列表数据
    fill_timelog_history_list: function(page_id, data){
        var $item_g;
        data.forEach(function (val) {
            $item_g = $("#timelog_g_" + val["group"]);
            if ($item_g.length > 0) {
                $item_g.prepend(Strack.timelog_history_item_dom(val));
            } else {
                $(page_id).append(Strack.timelog_history_group_dom(val));
            }
        });
    },
    // timelog 组 item dom
    timelog_history_group_dom: function(data)
    {
        var dom = '';
        dom += '<div class="time-item-title">' +
            '<div class="time-title-show">' +
            data["created"] +
            '</div>' +
            '</div>'+
            '<div id="timelog_g_' + data["group"] + '" class="timelog-group">' +
            Strack.timelog_history_item_dom(data) +
            "</div>";
        return dom;
    },
    // timelog 基础 item dom
    timelog_history_item_dom: function (cdata) {
        var dom = '';
        dom += '<li id="timelog_i_'+cdata["id"]+'" class="time-base-item">' +
            '<div class="acrive-task-show">' +
            '<div class="time-task-info aign-left">' +
            '<div href="javascript:;" class="task-step text-ellipsis">' +
            cdata["title"] +
            '</div>' +
            '<div href="javascript:;" class="task-belog-to text-ellipsis">' +
            cdata["belong"] +
            '</div>' +
            '</div>' +
            '<div class="time-date-show aign-left">' +
            '<div class="itime-total">' +
            Strack.format_timer_time(cdata["duration"]) +
            '</div>' +
            '<div class="itime-range">' +
            cdata["start_time"] + " - " + cdata["end_time"] +
            '</div>' +
            '</div>' +
            '<div class="time-task-close aign-left">';

        if(Strack.G.sideTimelogParam.rule_delete === "yes") {
            dom += '<a href="javascript:;" onclick="Strack.delete_timelog_history_item(this);" data-timeid="' + cdata["id"] + '">' +
                '<i class="icon-uniEA36"></i>' +
                '</a>';
        }

        dom +='</div>' +
            '</div>' +
            '</li>';
        return dom;
    },
    // 刷新时间日志边侧栏面板
    refresh_timelog_slider: function(i)
    {
        var tab = $(i).attr("data-tab");
        Strack.load_side_timelog(tab);
    },
    // 初始化记录时间日志按钮
    init_timelog_bnt: function(id, data){
        var $top_timelog_bnt = $(id);
        switch (data["color"]) {
            case "red":
                $top_timelog_bnt.attr("data-timelogid", data["id"]);
                $top_timelog_bnt.removeClass("green").addClass("red");
                $top_timelog_bnt.html('<i class="icon-uniE974 icon-left"></i>' + StrackLang["Stop"]);
                break;
            case "green":
                $top_timelog_bnt.attr("data-timelogid", 0);
                $top_timelog_bnt.removeClass("red").addClass("green");
                $top_timelog_bnt.html('<i class="icon-uniE974 icon-left"></i>' + StrackLang["Start"]);
                break;
        }
    },
    // 初始化已经存在的时间日志计时器
    init_active_timer: function(data)
    {
        var id = 'timer_'+Math.floor(Math.random() * 10000 + 1);
        Strack.add_side_timer_item(id, {
            status : 'stop',
            time : '00:00',
            value : data['link_id'],
            disabled: true
        });
        Strack.run_timer(id, data['timer_start']);
        // 切换按钮为stop
        var $item_ac = $('#item_'+id);
        $item_ac.addClass("active");
        $item_ac.attr("data-timerid", data["id"]);
    },
    // 添加时间日志计时器
    add_side_timer: function(i)
    {
        var id = 'timer_'+Math.floor(Math.random() * 10000 + 1);
        Strack.add_side_timer_item(id, {
            status : 'start',
            time : '00:00',
            value : '',
            disabled: false
        });
    },
    // 时间日志边侧栏添加计时器项
    add_side_timer_item: function(id, data)
    {
        // 隐藏无数据提示信息
        $("#slider_timer_list .datagrid-empty-no").remove();

        $("#slider_timer_list").prepend(Strack.side_timer_dom(id, data));

        var project_id = $("input[name=project_id]").val();
        project_id = project_id?project_id:0;

        // 初始化combobox
        Strack.combobox_widget('#'+id, {
            url: StrackPHP["getTimeLogIssuesCombobox"],
            prompt: StrackLang["Please_Select_Timer_Issue"],
            valueField: 'id',
            textField: 'name',
            groupField: 'group_lang',
            value: data['value'],
            disabled: data['disabled'],
            width: 220,
            queryParams: {
                project_id: project_id
            },
            onSelect: function (record) {

            }
        });
    },
    //开启时间日志计时器
    start_timer: function(i)
    {
        var id = $(i).data("id");
        var row_data = $('#'+id).combobox('getRowValue', 'id');
        if(!$.isEmptyObject(row_data)){
            $.ajax({
                type: 'POST',
                url: StrackPHP['addTimelogTimer'],
                dataType: 'json',
                data: row_data,
                beforeSend: function () {
                    $('#slider_timer_list').prepend(Strack.loading_dom('white', '', 'timer'));
                },
                success: function (data) {
                    if(parseInt(data['status']) === 200){
                        Strack.top_message({bg:'g',msg: data['message']});
                        // 禁用combox
                        $('#'+id).combobox('disable');
                        // 开启计数器
                        Strack.run_timer(id, 0);
                        // 切换按钮为stop
                        var $item_ac = $(i).closest(".tg-ac-item");
                        $item_ac.addClass("active");
                        $item_ac.attr("data-timerid", data["data"]["id"]);
                        $item_ac.find('.control-bnt')
                            .empty()
                            .append( Strack.timer_control_bnt('stop', id));

                        Strack.check_timer_exit();
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                    $("#st-load_timer").remove();
                }
            });
        }else {
            layer.msg(StrackLang['Please_Select_Timelog_Issue'], {icon: 2, time: 1200, anim: 6});
        }
    },
    // 停止时间日志计时器
    stop_timer: function(i)
    {
        var id = $(i).data("id");
        var $item_ac = $(i).closest(".tg-ac-item");
        var timer_id = $item_ac.attr("data-timerid");
        $.ajax({
            type: 'POST',
            url: StrackPHP['stopTimelogTimer'],
            dataType: 'json',
            data: {
                timer_id : timer_id
            },
            beforeSend: function () {
                $('#slider_timer_list').prepend(Strack.loading_dom('white', '', 'timer'));
            },
            success: function (data) {
                if(parseInt(data['status']) === 200){
                    Strack.top_message({bg:'g',msg: data['message']});
                    $('#'+id).combobox('destroy');
                    $("#item_"+id).remove();
                    clearInterval(Strack.G.TllogTerval[id]);
                    Strack.check_timer_exit();
                }else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
                $("#st-load_timer").remove();
            }
        });
    },
    // 删除时间日志计时器
    delete_timer: function(i)
    {
        var id = $(i).data("id");
        // 判断是普通删除还是需要清除数据库
        var $item_ac = $(i).closest(".tg-ac-item");
        if($item_ac.hasClass("active")){
            var timer_id = $item_ac.attr("data-timerid");
            $.ajax({
                type: 'POST',
                url: StrackPHP['deleteTimelog'],
                dataType: 'json',
                data: {
                    primary_ids : timer_id
                },
                beforeSend: function () {
                    $('#slider_timer_list').prepend(Strack.loading_dom('white', '', 'timer'));
                },
                success: function (data) {
                    if(parseInt(data['status']) === 200){
                        Strack.top_message({bg:'g',msg: data['message']});
                        $('#'+id).combobox('destroy');
                        $("#item_"+id).remove();
                        clearInterval(Strack.G.TllogTerval[id]);
                        Strack.check_timer_exit();
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                    $("#st-load_timer").remove();
                }
            });
        }else {
            $('#'+id).combobox('destroy');
            $("#item_"+id).remove();
            Strack.check_timer_exit();
        }
    },
    // 删除指定的时间日志
    delete_timelog_history_item: function(i)
    {
        var id = $(i).data("timeid");
        if(id>0){
            $.ajax({
                type: 'POST',
                url: StrackPHP['deleteTimelog'],
                dataType: 'json',
                data: {
                    primary_ids : id
                },
                beforeSend: function () {
                    $('#slider_timelog_wrap').prepend(Strack.loading_dom('white', '', 'timelog'));
                },
                success: function (data) {
                    if(parseInt(data['status']) === 200){
                        Strack.top_message({bg:'g',msg: data['message']});
                        $("#timelog_i_"+id).remove();
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                    $("#st-load_timelog").remove();
                }
            });
        }
    },
    // 开启计数器
    run_timer: function (id, start) {
        var $item_time = $("#item_"+id).find(".time");
        var start_time = start>0?start:0;
        Strack.G.TllogTerval[id] = setInterval(function () {
            $item_time.html(Strack.format_timer_time(start_time));
            start_time++;
        }, 1000);
    },
    //格式化timelog
    format_timer_time: function (time) {
        var a = time,
            d = parseInt(a / 86400),
            h = parseInt((a % 86400) / 3600),
            m = parseInt((a % 86400 % 3600) / 60),
            s = a % 86400 % 360 % 60;
        var ctiem = '';
        if (d !== 0) {
            ctiem += d + StrackLang["Days"] + " ";
        }
        if (h !== 0 || d !== 0) {
            ctiem += Strack.fix_timer_number(h, 2) + ':';
        }
        if (m !== 0 || h !== 0 || d !== 0) {
            ctiem += Strack.fix_timer_number(m, 2) + ':';
        }
        ctiem += Strack.fix_timer_number(s, 2);
        if (d === 0 && h === 0 && m === 0) {
            ctiem += ' ' + StrackLang["Unit_Sec"]
        }
        if (d === 0 && h === 0 && m !== 0) {
            ctiem += ' ' + StrackLang["Unit_Min"]
        }
        return ctiem;
    },
    //修整timelog
    fix_timer_number: function (num, length) {
        return ('' + num).length < length ? ((new Array(length + 1)).join('0') + num).slice(-length) : '' + num;
    },
    // 判断当前面板是否还存在timer
    check_timer_exit: function()
    {
        var $timer_list = $("#slider_timer_list");
        var number = $timer_list.find(".tg-ac-item").length;
        if( number=== 0){
            $timer_list.empty().append('<div class="datagrid-empty-no text-center">'+StrackLang["Datagird_No_Data"]+'</div>');
        }
        Strack.top_tool_number('#top_timer_number', number);
    },
    // 时间日志边侧栏计时器项 DOM
    side_timer_dom: function(id, data)
    {
        var dom = '';
        dom += '<div id="item_'+id+'" class="ui grid tg-ac-item">'+
            '<div class="center aligned four column row">'+
            '<div class="seven wide column">'+
            '<div style="padding-left: 20px">' +
            '<input id="'+id+'" autocomplete="off">'+
            '</div>'+
            '</div>'+
            '<div class="five wide column button-wrap time">'+
            data['time']+
            '</div>'+
            '<div class="two wide column button-wrap control-bnt">'+
            Strack.timer_control_bnt(data.status, id) +
            '</div>'+
            '<div class="two wide column button-wrap">';

        if(Strack.G.sideTimelogParam.rule_delete === "yes") {
            dom += '<a href="javascript:;" class="button" onclick="Strack.delete_timer(this)" data-id="' + id + '">' +
                '<button class="ui basic gray button">' + StrackLang["Delete"] + '</button>' +
                '</a>';
        }

        dom += '</div>'+
            '</div>'+
            '</div>';
        return dom;
    },
    // 时间日志计数器控制按钮
    timer_control_bnt: function(type, id)
    {
        var dom = '';
        if(Strack.G.sideTimelogParam.rule_start_stop === "yes"){
            if(type === 'start'){
                dom += '<a href="javascript:;" class="button" onclick="Strack.start_timer(this)" data-id="'+id+'">'+
                    '<button class="ui basic green button">'+StrackLang["Start"]+'</button>'+
                    '</a>';
            }else {
                dom += '<a href="javascript:;" class="button" onclick="Strack.stop_timer(this)" data-id="'+id+'">'+
                    '<button class="ui basic red button">'+StrackLang["Stop"]+'</button>'+
                    '</a>';
            }
        }
        return dom;
    },
    // 开始获取暂停详情页面时间日志
    item_start_timelog: function(i)
    {
        var id = $(i).attr("data-id");
        var link_id = $(i).attr("data-linkid"),
            timelog_id = $(i).attr("data-timelogid"),
            module_id = $(i).attr("data-moduleid");
        $.ajax({
            type : 'POST',
            url : StrackPHP['startOrStopTimelog'],
            data : {
                id: link_id,
                timelog_id: timelog_id,
                module_id: module_id
            },
            dataType : 'json',
            beforeSend : function () {
                $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
            },
            success : function (data) {
                $.messager.progress('close');
                if(parseInt(data['status']) === 200){
                    Strack.top_message({bg:'g',msg: data['message']});
                    //填充时间日志数据
                    Strack.top_tool_number('#top_timer_number', data["data"]["timer_number"]);
                    if(timelog_id > 0){
                        Strack.init_timelog_bnt('#'+id, {
                            color : 'green',
                            id : 0
                        });
                    }else {
                        Strack.init_timelog_bnt('#'+id, {
                            color : 'red',
                            id : data["data"]["id"]
                        });
                    }
                }else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
            }
        });
    },
    //加载顶部信息
    top_header: function () {
        var $project_id = $('input[name = project_id]');
        var project_id = $project_id.length > 0 ? $project_id.val() : 0;

        $.ajax({
            type: "POST",
            url: StrackPHP['getTopRightData'],
            dataType: "json",
            data : {
                project_id : project_id
            },
            success: function (data) {
                var user_data = data["user_data"];

                Strack.G.userId = user_data["user_id"];

                Strack.notice.license(data["license_data"]);

                Strack.notice.demo_project(data["project_data"]);

                //填充时间日志数据
                Strack.top_tool_number('#top_timer_number', data["timer_number"]);

                //填充消息盒子数据
                Strack.G.UnReadMessageData = {massage_number: data["message_data"]["massage_number"], created:  data["message_data"]["last_message_data"]["created"]};
                Strack.top_tool_number('#top_msg_number', data["message_data"]["massage_number"]);

                $('#top_avatar').append(Strack.build_avatar(user_data['user_id'], user_data['avatar'], Strack.upper_first_str(user_data['pinyin'])));

                //判断是否是admin界面 填充用户头像
                var $amdin = $('#padmin_avatar');
                if ($amdin.length > 0) {
                    $amdin.empty()
                        .append(Strack.build_avatar(user_data['user_id'], user_data['avatar'], Strack.upper_first_str(user_data['pinyin'])));
                    $('#padmin_name').html(user_data["name"]);
                }

                //判断是否是前台Account页面 填充用户头像
                if ($('#acinfo_menu').length > 0) {
                    $('#acinfo_avatar').empty()
                        .append(Strack.build_avatar(user_data['user_id'], user_data['avatar'], Strack.upper_first_str(user_data['pinyin'])));
                    $('#acinfo_name').html(user_data["name"]);
                }
            }
        });
    },
    //顶部Msg数据
    top_tool_number: function (id, num) {
        if (parseInt(num) > 0) {
            $(id).html(num).addClass("st-sup-ac");
        } else {
            $(id).removeClass("st-sup-ac").empty();
        }
    },
    //加载 Note
    load_notes: function (ids, param) {
        var $note_wrap = $(ids.content_id).find('[data-tab="note"]');
        $.ajax({
            type: 'POST',
            url: StrackPHP['getNoteListData'],
            data: param,
            dataType: "json",
            beforeSend: function () {
                if (param.status === 'new') {
                    $note_wrap.addClass("loading");
                }
            },
            success: function (data) {

                var $list_id_no_stick = $("#" + ids.list_id+" .note-no-stick");
                var $list_id_stick = $("#" + ids.list_id+" .note-stick");

                //第一次加载时触发
                if (param.status === 'new') {

                    // 给列表dom添加class标识
                    var list_class = 'comments_list_'+param.module_id+'_'+param.item_id;
                    var $list_dom = $('#'+ids.list_id);

                    // 删除冗余 className
                    var class_names = $list_dom.attr('class');
                    class_names.split(" ")
                        .forEach(function (val) {
                            if($.inArray(val, ["ui","threaded","comments","note-comments"]) < 0 ){
                                $list_dom.removeClass(val);
                            }
                        });

                    $list_dom.addClass(list_class);

                    param.total = data['note_list']['total'];

                    //生成评论头像
                    if(ids.avatar_id){
                        $(ids.avatar_id).empty().append(Strack.build_avatar(data["user_data"]['user_id'], data["user_data"]['avatar'], Strack.upper_first_str(data["user_data"]['pinyin'])));
                    }

                    var editor_param = {
                        item_id: param.item_id,
                        project_id: param.project_id,
                        module_id: param.module_id,
                        module_type: param.module_type,
                        structure_id: param.structure_id,
                        list_id: ids.list_id,
                        list_class: 'comments_list_'+param.module_id,
                        parent_id: 0
                    };

                    $(".simditor-body").attr("contenteditable", false);

                    Strack.init_note_editor(ids.editor_id, 0, editor_param, 'panel', 'add', true);

                    Strack.fall_load_data(ids.page_id, param,
                        function (data) {
                            data.status = 'more';
                            Strack.load_notes(ids, data);
                        }, function () {
                            //顶部滚动隐藏后 显示窄条
                            if (ids.details_top_bar) {
                                var $tab_hide_bar = $('#' + ids.tab_bar_id);
                                if($(".globel-top-notice").length > 0){
                                    $tab_hide_bar.css("top", 85);
                                }else {
                                    $tab_hide_bar.css("top", 49);
                                }
                                if ($(ids.tab_id).offset().top < 80) {
                                    $tab_hide_bar.show(200);
                                } else {
                                    $tab_hide_bar.hide(200);
                                }
                            }
                        }
                    );

                    $list_id_stick.empty().append(Strack.show_note_list(data['stick_note_list']));

                    if(data['stick_note_list']["total"] > 0){
                        $list_id_stick.addClass("note-stick-bottom");
                    }

                    $list_id_no_stick.empty();
                    $note_wrap.removeClass("loading");
                }

                $list_id_no_stick.append(Strack.show_note_list(data['note_list']));

                data['note_list']["rows"].forEach(function (item) {
                    Strack.init_note_att_event(item["id"]);
                });

            }
        });
    },
    //激活note att event
    init_note_att_event: function (id) {

        if(id){
            $(".comment_note_"+id).find('.note-att')
                .each(function () {
                    Strack.init_thumb_media($(this).data("id"));
                });
        }else {
            $('.note-att').each(function () {
                Strack.init_thumb_media($(this).data("id"));
            });
        }

        //初始化音频
        // var $weixin_audio = $('.weixinAudio');
        //
        // if($weixin_audio && $weixin_audio.length > 0){
        //     $weixin_audio.weixinAudio({});
        // }
    },
    //初始化回复框控件
    init_note_editor: function (area_id, note_id, editor_param, from, edit_mode, focus) {

        //保存当前参数
        Strack.G.GeditorParam['e_' + note_id] = editor_param;

        //编辑器初始化
        var toolbar = ['color', 'bold', 'emoji', '|', 'strikethrough', 'ol', 'ul', 'blockquote', 'table', 'hr'];

        Strack.G.Geditor['e_' + note_id] = new Simditor({
            textarea: $('#' + area_id),
            placeholder: StrackLang["Add_Note_Notice"],
            toolbarHidden: focus,
            toolbartype: note_id,
            panel_type: "main",
            toolbar: toolbar,
            footer_control: true,
            from: from,
            edit_mode: edit_mode,
            module_type: editor_param.module_type,
            list_class: editor_param.list_class,
            emoji: {imagePath: 'images/emoji/'},
            mention: {
                url: StrackPHP['getAtUserList'],
                nameKey: "name",
                pinyinKey: "pinyin",
                abbrKey: "abbr",
                param: editor_param
            }
        });

        if (note_id === 0) {
            //显示编辑区域
            Strack.G.Geditor['e_' + note_id].on('focus', function (e, src) {
                Strack.hide_note_reply();
                $('.toolbar_' + note_id).show();


                Strack.reset_slider_note_hight(this.wrapper, "focus");


                // 判断当前是否有处于截屏状态
                if(Strack.G.mediaScreenshotStatus){
                    // 退出截屏
                    obj.exit_media_painter();
                }
            });
        }
    },
    // 重置边侧栏note列表高度
    reset_slider_note_hight: function(i, mode){
        var $note_editor_slider = $(i).closest(".note-editor-slider");
        if($note_editor_slider.length > 0){
            var base_h = parseInt($note_editor_slider.attr("data-baseh"));
            var $list_wrap = $note_editor_slider.find(".pyn-fd-wrap");
            if(mode === "focus"){
                $list_wrap.css("height", "calc(100% - "+(base_h+58)+"px)");
            }else {
                $list_wrap.css("height", "calc(100% - "+base_h+"px)");
            }
        }
    },
    //显示note回复框
    show_note_reply: function (i) {
        var note_id = $(i).attr("data-noteid");
        Strack.hide_note_reply();
        $(i).parent().hide().after(Strack.note_reply_editor(note_id));

        var editor_param = Strack.G.GeditorParam['e_0'];
        editor_param["parent_id"] = note_id;
        Strack.init_note_editor('editor-reply_' + note_id, note_id, editor_param, 'panel', 'add', false);
    },
    //隐藏note回复框
    hide_note_reply: function () {
        $('.reply-editor').each(function () {
            Strack.close_note(this);
        });
    },
    //task reply面板
    note_reply_editor: function (id) {
        return '<div id="reply-wrap_' + id + '" class="reply-editor" toolbar_type="' + id + '">' +
            '<textarea id="editor-reply_' + id + '" autocomplete="off"></textarea>' +
            '</div>';
    },
    //遍历输出notes
    show_note_list: function (note_data) {
        var dom = "";
        note_data["rows"].forEach(function (val) {
            dom += Strack.notes_single_item_dom(val, 'add');
        });
        return dom;
    },
    // note单项dom
    notes_single_item_dom: function(val, mode)
    {
        var dom = "";
        var item_dom = Strack.notes_item_dom(val);

        if(mode === "add"){
            dom += '<div class="comment comment_note_' + val['id'] + '" stick="'+val["stick"]+'">';
            dom += item_dom;
            dom += '</div>';
            return dom;
        }else {
            return item_dom;
        }
    },
    //note item dom
    notes_item_dom: function (param) {
        var note_dom = '', avatar;


        //用户个人详细信息页面
        note_dom += '<a href="javascript:;" class="avatar avatar-show" title="' + param["user_data"]['name'] + '">';

        //生成评论头像
        note_dom += Strack.build_avatar(param["user_data"]['user_id'], param["user_data"]['avatar'], Strack.upper_first_str(param["user_data"]['pinyin']));

        //note 文本生成
        var note_text = '';
        switch (param["type"]) {
            case "text":
                note_text = param["text"];
                break;
            case "audio":
                note_text += '<p class="weixinAudio"> ' +
                    '<audio src="' + param["audio_data"]["path"] + '" id="media" width="1" height="1" preload></audio> ' +
                    '<span id="audio_area" class="db audio_area"> ' +
                    '<span class="audio_wrp db"> ' +
                    '<span class="audio_play_area"> ' +
                    '<i class="icon_audio_default"></i> ' +
                    '<i class="icon_audio_playing"></i> ' +
                    '</span> ' +
                    '<span id="audio_length" class="audio_length tips_global">' + param["audio_data"]['duration'] + '</span> ' +
                    '<span class="db audio_info_area"> ' +
                    '<span class="audio_source tips_global">' + param["audio_data"]['description'] + '</span> ' +
                    '</span> ' +
                    '<span id="audio_progress" class="progress_bar" style="width: 0%;"></span> ' +
                    '</span> ' +
                    '</span> ' +
                    '</p>';
                note_text += param["text"];
                break;
        }


        var note_edom = '';
        note_edom += '<a href="javascript:;" onclick="Strack.edit_note(this)" class="note-editicon" data-noteid="' + param['id'] + '"><i class="icon-uniF040 icon-left"></i></a>';
        note_edom += '<a href="javascript:;" onclick="Strack.delete_note(this)" class="note-editicon" data-noteid="' + param['id'] + '"><i class="icon-uniE765"></i></a>';

        var reply = '';
        if (param['reply_data'].length >0) {
            reply = StrackLang["Reply"] + ' ' + '#' + param['parent_id'] + ' ' + param['reply_data']["reply_user_name"];
        }

        var main_random_id = 'main_'+Math.floor(Math.random() * 10000 + 1);

        note_dom += '</a>' +
            '<div class="content">' +
            Strack.init_note_tag(param["tag_data"]) +
            '<div class="note-toolbar">' +
            '<a href="javascript:;" class="author" target="_blank">' + '#' + param['id'] + ' ' + param["user_data"]['name'] + '</a>' +
            '<span class="reply_auth_name">' + reply + '</span>' +
            '<div class="metadata">' +
            '<span class="date">' + param['last_updated'] + '</span>' +
            '</div>' +
            '<div class="aign-right note-tedit">' +
            note_edom +
            '</div>' +
            '</div>' +
            '<div class="text  editor-style ntext_' + param["id"] + '"><div class="simditor-body">' + note_text + '</div></div>' +
            '<div class="note-att" data-id="'+main_random_id+'">' +
            Strack.show_note_img_att(main_random_id, param["media_data"]) +
            '</div>';


        note_dom += '<div class="actions">' +
            '<a class="reply" onclick="Strack.show_note_reply(this)" data-noteid="' + param["id"] + '">' + StrackLang["Reply"] + '</a>' +
            '</div>';


        note_dom += '</div>';

        note_dom += Strack.init_link_note(param["link_note_data"]);

        return note_dom;
    },
    //初始化关联Note
    init_link_note: function (link_note_data) {
        var dom = '';
        if (link_note_data.length) {
            var n_dom = '';
            link_note_data.forEach(function (val) {
                n_dom += '<a href="javascript:;" onclick="Strack.edit_note(this)" data-noteid="' + val["id"] + '"> # ' + val["id"] + '</a>';
            });
            dom += '<div class="link-note">' +
                '<ul class="link-note-wrap">' +
                '<li class="link-note-item"><span class="link-icon"><i class="icon-uniE612"></i></span><span class="link-title">' + StrackLang['Link_Note'] + '</span><div class="link-note-bnt">' + n_dom + '</div></li>' +
                '</ul>' +
                '</div>';
        }
        return dom;
    },
    //初始化Note tag 标签
    init_note_tag: function (tag_data) {
        if (tag_data.length) {
            var dom = '';
            tag_data.forEach(function (val) {
                dom += Strack.note_tag_dom(val);
            });
            var note_tag_show = Strack.read_storage("note-tag-show");
            var note_tag_show_css = '';
            if (note_tag_show === 'yes') {
                note_tag_show_css = 'note-tags-show';
            }
            return '<a href="javascript:;" class="note-tags ' + note_tag_show_css + '" onclick="Strack.toggle_note_tag_show(this)">' + dom + '</a>';
        } else {
            return '';
        }
    },
    //Note tag dom
    note_tag_dom: function (val) {
        if (val) {
            return '<span class="card-label mod-card-front" title="' + val["name"] + '" style="background-color: #' + val["color"] + '">' + val["name"] + '</span>';
        } else {
            return '';
        }
    },
    //切换Note tag 显示
    toggle_note_tag_show: function (i) {
        if ($(i).hasClass("note-tags-show")) {
            $('.note-tags').removeClass("note-tags-show");
            Strack.save_storage("note-tag-show", "no");
        } else {
            $('.note-tags').addClass("note-tags-show");
            Strack.save_storage("note-tag-show", "yes");
        }
    },
    //删除note
    delete_note: function (i) {
        var note_id = $(i).attr("data-noteid");
        $.messager.confirm(StrackLang['Confirmation_Box'], StrackLang['Note_Delete_Confirm'], function (flag) {
            if (flag) {
                $.ajax({
                    type: 'POST',
                    url: StrackPHP['deleteNote'],
                    dataType: "json",
                    data: {
                        primary_ids: note_id
                    },
                    beforeSend: function () {
                        $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                    },
                    success: function (data) {
                        Strack.top_message({bg: 'g', msg: data['message']});
                        $.messager.progress('close');
                        // 更新数据
                        if(!Strack.Websocket.List.hasOwnProperty("update")){
                            Strack.update.note(data['data']);
                        }
                    }
                });
            }
        });
    },
    //关闭 editor
    close_note: function (i) {
        var t = $(i).attr("toolbar_type");

        Strack.reset_slider_note_hight(i, "blur");

        //删除note 图片附件
        Strack.destroy_note_img_uploadifive(t);

        $('.ed_rethumb_' + t).empty().removeClass("simditor-fields-ac");

        $(i).closest(".simditor-footer")
            .find(".toolbar-foot-item")
            .removeClass("ntool-active");

        if (t > 0) {
            var $reply = $('#reply-wrap_' + t);
            $reply.prev().show();
            $reply.remove();
        } else {
            $('.toolbar_' + t).hide();
            Strack.G.Geditor['e_' + t].setValue('');
            $('.fieldsbar_' + t).removeClass("simditor-fields-ac")
                .find("li").each(function () {
                    $(this).find("input.ed_fiedlds").combobox("destroy");
                    $(this).remove();
                }
            );
        }

        Strack.G.closeNoteObj = null;
    },
    //重置note
    reset_note: function (t) {
        $('.ed_rethumb_' + t).empty().removeClass("simditor-fields-ac");
        Strack.G.Geditor['e_' + t].setValue('');
        $('.fieldsbar_' + t).removeClass("simditor-fields-ac")
            .find("li").each(function () {
                $(this).find("input.ed_fiedlds").combobox("destroy");
                $(this).remove();
            }
        );
    },
    //将图片Base64 转成文件
    data_url_to_file :function (dataurl) {
        var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], "img.png", {type:mime});
    },
    //提交保存 editor note
    add_note: function (i) {
        var t = $(i).attr("toolbar_type");
        var queueLength = $('#nodeimg_'+t+' .uploadifive-queue-item').length;
        var text = Strack.G.Geditor['e_' + t].getValue();

        Strack.G.closeNoteObj = i;

        // 有图片队列先上传图片
        var $review_imgs = $("#screenshot_list .pyn-st-img img");
        if($review_imgs.length > 0){
            Strack.add_review_img_to_uploadfive(i, t, $review_imgs);
        }else {
            if (text.length > 0 || queueLength >0) {
                if(queueLength >0){
                    $('#nodeimg_bnt_' + t).uploadifive('upload');
                }else {
                    Strack.update_note(t, StrackPHP['addNote'], 'add');
                }
            }else {
                layer.msg(StrackLang["Note_Text_Empty_Or_Media_Empty"], {icon: 2, time: 1200, anim: 6});
            }
        }
    },
    // 把审核图片加入到uploadfive上传队列
    add_review_img_to_uploadfive: function(i, t, $imgs)
    {
        if(!$(".simditor-rethumb").hasClass("simditor-fields-ac")){
            // 激活图片上传队列
            Strack.note_add_image(i, t, 'add', function () {
                $imgs.each(function () {
                    $('#nodeimg_bnt_' + t).uploadifive('addQueueItem', Strack.data_url_to_file($(this).attr("src")));
                });
                $('#nodeimg_bnt_' + t).uploadifive('upload');
            });
        }else {
            $imgs.each(function () {
                $('#nodeimg_bnt_' + t).uploadifive('addQueueItem', Strack.data_url_to_file($(this).attr("src")));
            });
            $('#nodeimg_bnt_' + t).uploadifive('upload');
        }

    },
    //更新note操作
    update_note: function (t, url, mode, imgs, media_server) {
        var note_body = Strack.G.Geditor['e_' + t].body,
            $fieldbar = $('.fieldsbar_' + t);

        var param = Strack.G.GeditorParam['e_' + t];

        param["file_commit_id"] = Strack.G.mediaViewPlayIndex;

        if(media_server){
            param['media_server'] = media_server;
        }

        param['type'] = 'text';

        param['id'] = t;

        param['text'] = Strack.G.Geditor['e_' + t].getValue();

        //判断是否有@人需要抄送 循环a标签
        var at_uids = [];
        note_body.find('a').each(function () {
            if ($(this).hasClass("simditor-mention")) {
                at_uids.push($(this).data('uid'));
            }
        });

        param["at_user_ids"] = at_uids.join(",");

        //field setting
        param["status_id"] = 0;
        param["stick"] = 'no';
        param["version_id"] = 0;
        param["tags"] = '';

        $fieldbar.find(".ed_fiedlds").each(function () {
            var $f_id = $('#' + $(this).attr("id"));
            switch ($(this).attr("data-input")) {
                case "status":
                    param["status_id"] = $f_id.combobox("getValue");
                    break;
                case "stick":
                    param["stick"] = $f_id.combobox("getValue");
                    break;
                case "tag":
                    var tags = $f_id.combobox("getValues");
                    param["tags"] = tags.join(",");
                    break;
            }
        });


        param["images"] = imgs? imgs: [];

        // 要删除的note 图片 id 列表
        if(mode === "modify"){
            param["delete_media_ids"] = Strack.G.Note_Delete_Img_Ids;
        }

        //post 提交后台
        $.ajax({
            type: 'POST',
            url: url,
            data: JSON.stringify(param),
            dataType: 'json',
            contentType: "application/json",
            beforeSend: function () {
                if(!media_server) {
                    $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                }
            },
            success: function (data) {
                $.messager.progress("close");
                if (parseInt(data['status']) === 200) {

                    // 判断是否有截屏数据
                    if($("#screenshot_list .pyn-st-img").length){
                        $("#screenshot_list").html('<div class="pyn-st-null">'+StrackLang["Screenshot_Null"]+'</div>');
                    }

                    Strack.top_message({bg: 'g', msg: data['message']});

                    // 清空Note上传媒体
                    Strack.G.Note_Uploadifive_Imgs = [];

                    switch (mode){
                        case "modify":
                        case "batch_add":
                            Strack.dialog_cancel();
                            break;
                        case "add":
                            Strack.close_note(Strack.G.closeNoteObj);
                            break;
                    }

                    // 更新数据
                    if(!Strack.Websocket.List.hasOwnProperty("update")){
                        Strack.update.note(data['data']);
                    }
                } else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
            }
        });
    },
    // 批量添加Note
    batch_add_note: function(i)
    {
        var $grid_toolbar = $(i).closest(".datagrid-toolbar");
        var grid = $grid_toolbar.attr("data-grid"),
            module_id = $grid_toolbar.attr("data-moduleid"),
            project_id = $grid_toolbar.attr("data-projectid");

        var rows = $("#" + grid).datagrid("getSelections");
        var ids = [];

        rows.forEach(function (val) {
            ids.push(parseInt(val["id"]));
        });

        if (ids.length > 0) {
            Strack.open_dialog('dialog', {
                title: StrackLang['Batch_Add_Note'],
                width: 700,
                height: 470,
                content: Strack.dialog_dom({
                    type: 'normal',
                    hidden: [
                        {case: 101, id: 'Mlink_ids', type: 'hidden', name: 'link_ids', valid: 1, value: ids.join(",")},
                        {case: 101, id: 'Mmodule_id', type: 'hidden', name: 'module_id', valid: 1, value: module_id},
                        {case: 101, id: 'Mproject_id', type: 'hidden', name: 'project_id', valid: 1, value: project_id}
                    ],
                    items: [
                        {case: 7, id: 'Mnote_text', type: 'text', lang: '', name: 'note_text', valid: 1, value: ''},
                        {case: 14, id: 'Mnote_meida', type: 'text', lang: '', name: 'note_meida', valid: 1, value: ''}
                    ],
                    footer: [
                        {obj: 'submit_batch_add_note', type: 11, title: StrackLang['Update']},
                        {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                    ]
                }),
                inits: function () {

                    var editor_param = {
                        item_id: ids.join(","),
                        project_id: project_id,
                        module_id: module_id,
                        list_id: ids.list_id,
                        list_class: 'comments_list_'+module_id,
                        parent_id: 0
                    };

                    Strack.init_note_editor('Mnote_text', module_id+'_0', editor_param, 'dialog', 'batch_add', false);
                    $("#st_dialog_form").find(".simditor-body").css({"height": "140px"});
                }
            });
        }else {
            layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
        }
    },
    // 批量新增note
    submit_batch_add_note: function()
    {
        var module_id = $("#Mmodule_id").val();
        var t = module_id+'_0';
        var text = Strack.G.Geditor['e_' + t].getValue();
        var queueLength = $('#nodeimg_'+t+' .uploadifive-queue-item').length;

        // 有图片队列先上传图片
        if (text.length > 0 || queueLength >0) {
            if(queueLength >0){
                $('#nodeimg_bnt_' + t).uploadifive('upload');
            }else {
                Strack.update_note(t, StrackPHP['batchAddNote'], 'batch_add');
            }
        }else {
            layer.msg(StrackLang["Note_Text_Empty_Or_Media_Empty"], {icon: 2, time: 1200, anim: 6});
        }
    },
    //编辑note
    edit_note: function (i) {
        var note_id = $(i).attr("data-noteid");
        if (note_id > 0) {
            Strack.hide_note_reply();
            $.ajax({
                type: 'POST',
                url: StrackPHP['getOneNoteData'],
                data: {
                    note_id: note_id
                },
                dataType: "json",
                beforeSend: function () {
                    $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                },
                success: function (data) {
                    // 清空Note上传媒体
                    Strack.G.Note_Uploadifive_Imgs = [];
                    $.messager.progress('close');
                    Strack.open_dialog('dialog', {
                        title: StrackLang['Modify_Note'],
                        width: 700,
                        height: 470,
                        content: Strack.dialog_dom({
                            type: 'normal',
                            hidden: [
                                {case: 101, id: 'Mnote_id', type: 'hidden', name: 'note_id', valid: 1, value: note_id}
                            ],
                            items: [
                                {case: 7, id: 'Mnote_text', type: 'text', lang: '', name: 'note_text', valid: 1, value: data["text"]},
                                {case: 14, id: 'Mnote_meida', type: 'text', lang: '', name: 'note_meida', valid: 1, value: ''}
                            ],
                            footer: [
                                {obj: 'modify_note', type: 11, title: StrackLang['Update']},
                                {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                            ]
                        }),
                        inits: function () {
                            var editor_param = Strack.G.GeditorParam['e_0'];
                            editor_param["parent_id"] = note_id;

                            Strack.init_note_editor('Mnote_text', note_id, editor_param, 'dialog', 'modify', false);
                            $("#st_dialog_form").find(".simditor-body").css({"height": "140px"});

                            //激活置顶属性
                            Strack.editor_footer_item(note_id, 'stick', StrackLang["Stick"], data.stick);

                            //激活状态属性
                            if (data.status_id) {
                                Strack.editor_footer_item(note_id, 'status', StrackLang["Status"], data.status_id);
                            }

                            //激活标签属性
                            if (data.tag_data.length > 0) {
                                var tag_ids = [];
                                data.tag_data.forEach(function (val) {
                                    if (val["tag_id"] > 0) {
                                        tag_ids.push(val["tag_id"]);
                                    }
                                });
                                if(tag_ids.length>0){
                                    Strack.editor_footer_item(note_id, 'tag', StrackLang["Tag"], tag_ids);
                                }
                            }

                            // 缩略图列表
                            if(data["media_data"]["has_media"] === "yes"){
                                Strack.init_modify_note_img_list('#dialog_img_list', data["media_data"]["param"]);
                            }
                        },
                        close: function () {
                            Strack.G.Note_Delete_Img_Ids = [];
                            Strack.G.Note_Has_Img_Length = 0;
                        }
                    });
                }
            });
        }
    },
    //note已经存在缩略图
    init_modify_note_img_list: function(id, data){
        var dom = '';
        data.forEach(function (val) {
            dom += Strack.modify_note_img_item_dom(val);
        });
        Strack.G.Note_Has_Img_Length = data.length;
        $(id).empty().append('<div class="note-del-img-title">'+StrackLang["Select_The_Media_To_Delete"]+'</div><div class="note-del-img-wrap">'+dom+'</div>');
    },
    modify_note_img_item_dom: function(data){
        var dom = '';
        var img_url = '';
        switch (data["type"]){
            case "image":
                img_url = data['base_url']+data['md5_name']+'_origin.'+data['ext'];
                break;
            case "video":
                img_url = data['base_url']+data['md5_name']+'.jpg';
                break;
        }
        dom +=  '<a href="javascript:;" class="note-del-img aign-left" onclick="Strack.sign_delete_note_images(this)" data-id="'+data['media_id']+'">' +
            '<img src="' + img_url + '">' +
            '</a>';
        return dom;
    },
    // 标记可删除的note 媒体
    sign_delete_note_images: function(i)
    {
        var media_id = parseInt($(i).attr("data-id"));
        if($(i).hasClass("active")){
            var new_ids = [];
            Strack.G.Note_Delete_Img_Ids.forEach(function (id) {
                if(id !== media_id){
                    new_ids.push(id);
                }
            });
            Strack.G.Note_Delete_Img_Ids = new_ids;
            Strack.G.Note_Has_Img_Length++;
        }else {
            Strack.G.Note_Delete_Img_Ids.push(media_id);
            Strack.G.Note_Has_Img_Length--;
        }
        $(i).toggleClass("active");
    },
    //修改note内容
    modify_note: function () {
        var t = $("#Mnote_id").val();
        var text = Strack.G.Geditor['e_' + t].getValue();
        var queueLength = $('#nodeimg_'+t+' .uploadifive-queue-item').length;

        // 有图片队列先上传图片
        if (text.length > 0 || queueLength >0 || Strack.G.Note_Has_Img_Length >0) {
            if(queueLength >0){
                $('#nodeimg_bnt_' + t).uploadifive('upload');
            }else {
                Strack.update_note(t, StrackPHP['modifyNote'], 'modify');
            }
        }else {
            layer.msg(StrackLang["Note_Text_Empty_Or_Media_Empty"], {icon: 2, time: 1200, anim: 6});
        }
    },
    //添加note图像附件
    click_editor_footer: function (i) {
        var t = $(i).attr("toolbar_type"),
            area = $(i).attr("toolbar_area");
        switch (area) {
            case "image":
                var edit_mode = $(i).attr("edit_mode");
                Strack.note_add_image(i, t, edit_mode);
                break;
            default:
                var lang = $(i).attr("lang");
                Strack.editor_footer_item(t, area, lang, '');
                break;
        }
    },
    //note 编辑器fields
    editor_footer_item: function (t, area, lang, val) {
        var $item_bar = $(".fieldsbar_" + t);
        var field_id = "ed_field_" + area + "_" + t,
            $item = $('#' + field_id);

        $(".toolbar_"+t).find(".toolbar-foot-item")
            .each(function () {
                    if($(this).attr("toolbar_area") === area){
                        $(this).toggleClass('ntool-active');
                    }
                }
            );

        if ($item.length === 0) {
            $item_bar.addClass("simditor-fields-ac");
            Strack.init_editor_footer_item($item_bar.find("ul"), t, field_id, area, lang, val);
        } else {
            //先销毁控件
            $item.find("input.ed_fiedlds").combobox("destroy");
            $item.remove();
            if ($item_bar.find("li").length === 0) {
                $item_bar.removeClass("simditor-fields-ac");
            }
        }
    },
    //初始化 note 编辑器fields
    init_editor_footer_item: function ($dom, t, field_id, area, lang, val) {
        var dom = '',
            eid = 'ed_input_' + area + '_' + t;
        dom += '<li id="' + field_id + '" class="e-fields-item" >' +
            '<div class="e-fiedlds-name aign-left">' +
            lang +
            '</div>' +
            '<div class="e-fiedlds-input">' +
            '<input id="' + eid + '" class="ed_fiedlds" data-input="' + area + '">' +
            '</div>' +
            '</li>';

        $dom.append(dom);

        //初始化控件
        var param = Strack.G.GeditorParam['e_' + t];
        param["area"] = area;

        var multiple = false;

        if (area === "tag") {
            //tag 允许多选
            multiple = true;
        }

        $('#' + eid).combobox({
            url: StrackPHP["getNoteWidgetData"],
            valueField: 'id',
            textField: 'name',
            queryParams: param,
            multiple: multiple,
            value: val,
            width: 320,
            onLoadSuccess: function () { //加载完成后,设置选中第一项
                var data = $(this).combobox('getData');
                if (data.length && val.length === 0) {
                    $(this).combobox('select', data[0]['id']);
                }
            }
        });

    },
    //给Note添加图片附件
    note_add_image: function (i, t, edit_mode, callback) {
        var $thumb = $('.ed_rethumb_' + t);

        if ($thumb.hasClass("simditor-fields-ac")) {
            $(i).removeClass('ntool-active');
            Strack.destroy_note_img_uploadifive(t);
            $thumb.removeClass("simditor-fields-ac").empty();
        } else {
            Strack.get_media_server(
                function (media_server) {
                    $(i).addClass('ntool-active');
                    var dom = '';
                    dom += '<div id="nodeimg_' + t + '" class="rethumb-images aign-left"></div>' +
                        '<div class="rethumb-add aign-right">' +
                        '<input id="nodeimg_bnt_' + t + '" class="aign-left" name="nodeimg_bnt_' + t + '" type="file" multiple="true">'+
                        '</div>';
                    $thumb.addClass("simditor-fields-ac").empty().append(dom);
                    // 初始化 uploadifive 上传文件控件
                    Strack.init_note_img_uploadifive(t, media_server, {
                        edit_mode: edit_mode
                    }, callback);
                }
            );
        }
    },
    // 初始化note图片上传控件
    init_note_img_uploadifive: function(t, media_server, param, callback)
    {
        $('#nodeimg_bnt_' + t).uploadifive({
            'auto': false,
            'removeCompleted': true,
            'formData': {
                timestamp: Strack.current_time(),
                token: media_server['token'],
                size : '250x140'
            },
            'queueID': 'nodeimg_' + t,
            'uploadScript': media_server["upload_url"],
            'onUpload': function (file) {
                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
            },
            'onInit':function () {
                if(callback){
                    callback();
                }
            },
            'onUploadComplete': function (file, data) {
                var resData = JSON.parse(data);
                if(parseInt(resData['status']) === 200){
                    Strack.G.Note_Uploadifive_Imgs.push(resData['data']);
                }
            },
            'onQueueComplete': function (file, data) {
                var up_url = '';
                switch (param.edit_mode){
                    case "batch_add":
                        up_url = StrackPHP['batchAddNote'];
                        break;
                    case "modify":
                        up_url = StrackPHP['modifyNote'];
                        break;
                    default:
                        up_url = StrackPHP['addNote'];
                        break;
                }
                Strack.update_note(t, up_url, param.edit_mode, Strack.G.Note_Uploadifive_Imgs, media_server);
            }
        });
    },
    // 销毁note图片上传控件
    destroy_note_img_uploadifive: function (t) {
        $('#nodeimg_bnt_'+t).uploadifive('destroy');
    },
    //关注当前task
    follow_item: function (i) {
        var $this = $(i);
        var param = {
            module_id: $this.attr("data-moduleid"),
            module_type: $this.attr("data-moduletype"),
            follow_status: $this.attr("data-followstatus"),
            link_id: $this.attr("data-linkid")
        };

        if (param.follow_status === 'yes') {
            //取消关注当任务
            $.messager.confirm(StrackLang['Confirmation_Box'], StrackLang['Confirm_UnFollow'], function (flag) {
                if (flag) {
                    Strack.do_follow_item($this, param);
                }
            });
        } else {
            //关注当任务
            Strack.do_follow_item($this, param);
        }
    },
    //Check follow
    do_follow_item: function ($this, param) {
        $.ajax({
            type: 'POST',
            url: StrackPHP['followItem'],
            data: param,
            dataType: 'json',
            beforeSend: function () {
                $this.addClass("disabled");
            },
            success: function (data) {
                $this.removeClass("disabled");
                if (parseInt(data['status']) === 200) {
                    Strack.dialog_cancel();
                    Strack.top_message({bg: 'g', msg: data['message']});
                    $this.attr("data-followstatus", data['data']["follow_status"])
                    $this.html(data['data']["follow_status_name"]);
                } else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
            }
        });
    },
    // 打开action管理列表
    open_action_slider: function (i) {
        var from = $(i).data('from'),
            module_id = $(i).data('moduleid'),
            project_id = $(i).data('projectid');

        var $action_search_bnt = $("#action_search_bnt");
        $("#action_list_slider").sidebar("toggle");
        $action_search_bnt.attr("data-from", from)
            .attr("data-moduleid", module_id)
            .attr("data-projectid", project_id);

        switch (from){
            case 'grid':
                // 从数据表格触发
                var grid = $(i).data('grid');
                var rows = $('#' + grid).datagrid('getSelections');
                var ids = [];
                rows.forEach(function (val) {
                    ids.push(val['id']);
                });
                $action_search_bnt.attr("data-grid", grid)
                    .attr("data-ids", ids.join(","));
                Strack.load_sidebar_action_list({
                    from: from,
                    grid: grid,
                    module_id : module_id,
                    project_id : project_id,
                    filter: ''
                });
                break;
            case 'details':
                var link_id = $(i).data('linkid');
                $action_search_bnt.attr("data-ids", link_id);
                Strack.load_sidebar_action_list({
                    from: from,
                    grid: '',
                    module_id : module_id,
                    project_id : project_id,
                    filter: ''
                });
                break;
        }
    },
    // 查询动作
    search_action: function(i)
    {
        var $this =  $(i);
        var search_val = $("#action_search_box").val();
        var filter = '';
        if(search_val.length>0){
            filter = {'name':['-lk', "%"+search_val+"%"]};
        }
        var param = {
            from: $this.data("from"),
            grid: $this.data("grid"),
            module_id : $this.data("moduleid"),
            project_id : $this.data("projectid"),
            filter: filter
        };
        Strack.load_sidebar_action_list(param);
    },
    // 加载action管理面板数据
    load_sidebar_action_list: function(param){
        $.ajax({
            type: 'POST',
            url: StrackPHP['getSidebarActionData'],
            dataType: "json",
            data: param,
            beforeSend: function () {
                $('#action_list_slider').append(Strack.loading_dom('white', '', 'action'));
            },
            success: function (data) {
                var common_dom = '',
                    other_dom = '';
                data['common'].forEach(function (val) {
                    common_dom += Strack.action_list_item_dom(val, param, 'common');
                });

                data['other'].forEach(function (val) {
                    other_dom += Strack.action_list_item_dom(val, param, 'other');
                });

                $("#common_action_list").empty().append(common_dom);
                $("#other_action_list").empty().append(other_dom);

                $("#st-load_action").remove();
            }
        });
    },
    // 动作项DOM
    action_list_item_dom: function(data, param, type){
        var dom = '';
        var type_name = type === 'other'? StrackLang["Set_Action_Common"] : StrackLang["Cancel_Action_Common"];
        dom += '<div class="column dgat-item">'+
            '<a href="javascript:;" class="dgat-img" onclick="Strack.click_run_action(this)" data-from="'+param["from"]+'" data-grid="'+param["grid"]+'" data-actionid="'+data["id"]+'" data-moduleid="'+data["module_id"]+'">'+
            '<div class="action-icon">'+
            '<div class="soft-avatar">' +
            '<img src="'+data["thumb"]+'">'+
            '</div>'+
            '</div>'+
            '</a>'+
            '<div class="dgat-dcname"><strong>'+data["name"]+'</strong></div>'+
            '<div class="dgat-dcname">'+data["version"]+'</div>'+
            '<div class="dgat-bnt" >' +
            '<a href="javascript:;" onclick="Strack.toggle_action_common(this)" data-type="'+type+'" data-actionid="'+data["id"]+'" data-moduleid="'+data["module_id"]+'">'+type_name+'</a>' +
            '</div>'+
            '</div>';
        return dom;
    },
    // 设置或取消常用动作
    toggle_action_common: function(i){
        var type = $(i).data("type"),
            action_id = $(i).data("actionid"),
            module_id = $(i).data("moduleid");
        var mode = type === 'common'? 'cancel' : 'set';
        $.ajax({
            type: 'POST',
            url: StrackPHP['setActionCommonStatus'],
            data: {
                mode: mode,
                action_id: action_id,
                module_id: module_id
            },
            dataType: 'json',
            beforeSend: function () {
                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
            },
            success: function (data) {
                $.messager.progress('close');
                if (parseInt(data['status']) === 200) {
                    Strack.top_message({bg: 'g', msg: data['message']});
                    Strack.search_action(Strack.get_obj_by_id('action_search_bnt'));
                } else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
            }
        });
    },
    // 关闭action管理列表
    close_action_slider: function (i) {
        $("#action_list_slider").sidebar("toggle");
    },
    //批量触发动作
    click_run_action: function (i) {
        Strack.Websocket.init('action',{
            url: "ws://localhost:9888",
            afterInit : function (data) {
                if(data["status"] === "error"){
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }else {
                    var from = $(i).data('from'),
                        action_id = $(i).data('actionid'),
                        module_id = $(i).data('moduleid');
                    switch (from) {
                        case 'grid_edit':
                        case 'grid':
                            // 从表格触发action
                            var grid = $(i).data('grid');
                            var rows = $('#' + grid).datagrid('getSelections');
                            if (rows.length > 0) {
                                var ids = [];
                                rows.forEach(function (val) {
                                    ids.push(val['id']);
                                });
                                // 传递给客户端继续执行
                                Strack.run_action({
                                    action_id : action_id,
                                    module_id : module_id,
                                    link_ids : ids
                                });
                            } else {
                                layer.msg(StrackLang['Please_Select_Grid_One'], {icon: 2, time: 1200, anim: 6});
                            }
                            break;
                        default:
                            // 默认触发action
                            var link_ids = $('#action_search_bnt').data('ids');
                            Strack.run_action({
                                action_id : action_id,
                                module_id : module_id,
                                link_ids : link_ids
                            });
                            break;
                    }
                }
            }
        });
    },
    //执行action
    run_action: function (param) {
        $.ajax({
            type: 'POST',
            url: StrackPHP['getActionModuleData'],
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify(param),
            beforeSend: function () {
                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
            },
            success: function (data) {
                $.messager.progress('close');
                Strack.Websocket.List['action'].send(JSON.stringify({
                    action_id : param.action_id,
                    link_ids : param.link_ids,
                    module_data : data
                }));
            }
        });
    },
    // 文本段落自动分行
    word_limit: function (cname, length) {
        var nowLength = cname.length,
            newName = '';
        if (nowLength > length) {
            newName = cname.substr(0, length) + '...';
        } else {
            newName = cname;
        }
        return newName;
    },
    // step task 类型空间数据格式化
    format_step_task: function (data) {
        var dom = '';
        var field_val = {};
        var param_key,param_val;
        if (data.field_data) {
            data.field_data.forEach(function (val, index) {
                if(data.config.fields === "thumb" && data.config.module_code === "media"){
                    param_key = data.config['field'].replace("thumb", "param");
                    param_val = data.row_data[param_key][index]['fields']['value'];
                    if(val.fields.value && param_val){
                        field_val[data.config["fields"]] = {
                            'total' : 1,
                            'rows' : [
                                {
                                    'id' : 0,
                                    'param' : JSON.parse(param_val),
                                    'thumb' : val.fields.value
                                }
                            ]
                        };
                    }else {
                        field_val[data.config["fields"]] = {
                            'total' : 0,
                            'rows' : []
                        };
                    }
                }else {
                    field_val[data.config["fields"]] = val.fields.value;
                }
                dom += Strack.widget_input_dom(data.config, val.primary.value, Strack.widget_input_value(data.config, field_val, data.project_id, false, {primary: val.primary.value, module_id: data.module_id, from: 'grid'}), 'grid', false, {module_id : val.module_id, url : val.url});
            });
        }
        return dom;
    },
    // 生成grid columns config
    generate_grid_columns_config: function(col_config, param, columns_field_config, step_first_col_status)
    {
        var cols = [];
        col_config.forEach(function (val) {

            if (val.step) {

                if(val["hidden"]){
                    if(step_first_col_status[val["belong"]]){
                        return false;
                    }
                }

                val["formatter"] = function (value, row, index) {
                    return Strack.format_step_task({
                        project_id: param.project_id,
                        module_id: param.task_module_id,
                        config: columns_field_config[val['field']],
                        field_data: value,
                        row_data: row
                    });
                }
            }else {
                if (val["outreach_formatter"]) {
                    val["formatter"] = function (value, row, index) {
                        return eval(val["outreach_formatter"]);
                    }
                }

                // has_many的字段单独处理格式化
                if (val["is_has_many"] === "yes") {
                    val["formatter"] = function (value, row, index) {
                        if (value && value["total"] > 0) {
                            var show_list = [];
                            value["rows"].forEach(function (val) {
                                show_list.push(val["name"]);
                            });
                            return show_list.join(" , ");
                        } else {
                            return '';
                        }
                    };
                }

                if (val["field_type"] === "custom") {
                    switch (val["custom_type"]) {
                        case "belong_to":
                            // 自定义字段水平管理belong_to类型
                            switch (val["custom_config"]["relation_module_code"]) {
                                case "media":
                                    val["formatter"] = function (value, row, index) {
                                        if (value && value["total"] > 0) {
                                            return Strack.build_grid_preview_thumb_dom({
                                                'id': row["id"],
                                                'thumb': value["rows"][0]['thumb'],
                                                'param': value["rows"][0]['param'],
                                                'module_id': param.module_id,
                                                'field_type': 'horizontal',
                                                'field_config': columns_field_config[val['field']]
                                            });
                                        } else {
                                            return Strack.build_grid_preview_thumb_dom({
                                                'id': row["id"],
                                                'thumb': null,
                                                'param': null,
                                                'module_id': param.module_id,
                                                'field_type': 'horizontal',
                                                'field_config': columns_field_config[val['field']]
                                            });
                                        }
                                    };
                                    break;
                                case "status":
                                    val["formatter"] = function (value, row, index) {
                                        if (value && value["total"] > 0) {
                                            return Strack.widget_status_dom(value["rows"][0]['icon'], value["rows"][0]['name'], value["rows"][0]['color']);
                                        } else {
                                            return '';
                                        }
                                    };
                                    break;
                            }
                            break;
                        case "checkbox":
                            // 自定义字段checkbox类型格式化
                            val["formatter"] = function (value, row, index) {
                                return value === 'on' ? StrackLang["Checked"] : StrackLang["UnChecked"];
                            };
                            break;
                    }
                } else {
                    if (!val.step && val['module_code'] === "media" && val["field"].indexOf('thumb') >= 0) {
                        val["formatter"] = function (value, row, index) {
                            var link_param_key = val["field"].replace('thumb', 'param');
                            if (value && row[link_param_key]) {
                                return Strack.build_grid_preview_thumb_dom({
                                    'id': row["id"],
                                    'thumb': value,
                                    'param': row[link_param_key],
                                    'module_id': param.module_id,
                                    'field_type': 'direct',
                                    'field_config': columns_field_config[val['field']]
                                });
                            } else {
                                return Strack.build_grid_preview_thumb_dom({
                                    'id': row["id"],
                                    'thumb': null,
                                    'param': null,
                                    'module_id': param.module_id,
                                    'field_type': 'direct',
                                    'field_config': columns_field_config[val['field']]
                                });
                            }
                        };
                    }
                }
            }

            if (val['editor']) {
                switch (val['editor']['type']){
                    case 'tagbox':
                        // tagbox 更多配置
                        var query_params ={
                            primary: 0,
                            add_default: 'no',
                            project_id: param['project_id'],
                            module: val['module'],
                            field_type: val['field_type'],
                            fields: val['field'],
                            variable_id: val['variable_id'],
                            frozen_module: val['frozen_module'],
                            flg_module: val['flg_module'],
                            data_source: val['data_source'],
                            module_id: param['module_id']
                        };
                        val['editor']["options"] = {
                            height: 'auto',
                            valueField: 'id',
                            textField: 'name',
                            method: 'post',
                            url: StrackPHP["getWidgetData"],
                            hasDownArrow: true,
                            limitToList: true,
                            queryParams: query_params
                        };
                        if(val['module'] === 'tag'){
                            val['editor']["options"]['limitToList'] = false;
                            val['editor']["options"]['allowInput'] = true;
                            val['editor']["options"]['appendToDB'] = {
                                allow : true,
                                param : query_params
                            };
                        }
                        if (val['group']) {
                            val['editor']["options"]["groupField"] = 'group';
                        }
                        break;
                    case 'combobox':
                        val['editor']["options"] = {
                            height: 31,
                            valueField: 'id',
                            textField: 'name',
                            method: 'post',
                            url: StrackPHP["getWidgetData"],
                            queryParams: {
                                primary: 0,
                                project_id: param['project_id'],
                                module: val['module'],
                                field_type: val['field_type'],
                                fields: val['field'],
                                variable_id: val['variable_id'],
                                frozen_module: val['frozen_module'],
                                flg_module: val['flg_module'],
                                data_source: val['data_source'],
                                module_id: param['module_id']
                            }
                        };
                        if (val['group']) {
                            val['editor']["options"]["groupField"] = 'group';
                        }
                        break;
                }
            }
            cols.push(val);
        });

        return cols;
    },
    //加载 datagrid columns
    load_grid_columns: function (id, param, callback) {
        var loading_type = param.loading_type? param.loading_type : 'white';
        $.ajax({
            type: 'POST',
            url: StrackPHP['getGridColumns'],
            data: param,
            dataType: 'json',
            beforeSend: function () {
                $(param["loading_id"]).append(Strack.loading_dom(loading_type, '', 'grid_columns'));
            },
            success: function (data) {

                if(parseInt(data["status"]) === 200){
                    data = Strack.generate_grid_columns_data(param, data);
                }

                callback(data);

                $("#st-load_grid_columns").remove();
            }
        });
    },
    // 生成schema_page参数
    generate_schema_page: function(module_code)
    {
        var schema_page = '';
        switch (module_code){
            case "correlation_base":
                schema_page = "project_base";
                break;
            case "user":
                schema_page = "admin_account";
                break;
            case "action":
                schema_page = "admin_action";
                break;
            case "eventlog":
                schema_page = "admin_eventlog";
                break;
            default:
                schema_page = 'project_' + module_code;
                break;
        }
        return schema_page;
    },
    // 处理 datagrid columns
    generate_grid_columns_data: function(param, data)
    {
        var col_main, index = 0,
            frozecol_main, froze_index = 0;

        // 初始化隐藏step数据
        Strack.G.dataGridStepColunmsConfig[param.grid_id] = {
            step_list : [],
            step_columns : {}
        };

        if(data['grid']['step_columns_config']['step_list']){
            data['grid']['step_columns_config']['step_list'].forEach(function (val) {

                Strack.G.dataGridStepColunmsConfig[param.grid_id]["step_columns"][val['code']] = {};
                Strack.G.dataGridStepColunmsConfig[param.grid_id]["step_list"].push(val["code"]);

                var first_field= '',
                    field_list = [],
                    field_columns=[],
                    field_name = '',
                    base_field = '',
                    field_item={},
                    field_count=0,
                    field_width=0;

                field_count = data['grid']['step_columns_config']['step_fields'].length;

                if(field_count >0){
                    data['grid']['step_columns_config']['step_fields'].forEach(function (field, index) {

                        field_width = field["width"] ?  field["width"] : 160;
                        base_field = field['module_code']+ '_' + field["fields"];
                        field_name = val["code"] +'_'+base_field;

                        field_item = {
                            field : field_name,
                            title : field["lang"],
                            align : 'center',
                            width : field_width,
                            findex: index+1,
                            hidden : true,
                            drag : false,
                            step : true,
                            step_index : '',
                            belong : val["code"]
                        };
                        //第一个元素
                        if (index === 0) {
                            field_item['bdc'] = val["color"];
                            field_item['cbd'] = "colboth";
                            field_item['cellClass'] = "datagrid-cell-c1-" + field_name;
                            field_item['deltaWidth'] = 1;
                            field_item['hidden'] = false;
                            field_item['step_index'] = 'first';

                            first_field = base_field;
                        } else {
                            //第一个元素不隐藏
                            field_list.push(base_field);
                        }

                        //最后一个元素
                        if (index === (field_count - 1)) {
                            field_item['bdc'] = val["color"];
                            field_item['cbd'] = "colright";
                            field_item['cellClass'] = "datagrid-cell-c1-" + field_name;
                            field_item['deltaWidth'] = 1;
                            field_item['step_index'] = 'last';
                        }

                        field_columns.push(field_item);

                    });

                    Strack.G.dataGridStepColunmsConfig[param.grid_id]["step_columns"][val['code']] = {
                        first : {
                            bgc: val['color'],
                            but: val['code'],
                            class: val['code']+'_h',
                            colspan: 1,
                            fhcol: true,
                            fname: val['code'],
                            step: 'yes',
                            title: val['name'],
                            first_field: first_field,
                            field_list: field_list.join(",")
                        },
                        second : field_columns
                    };
                }
            });
        }

        var columns_field_config = data['grid']['columnsFieldConfig'];

        //非冻结字段
        if (data['grid']['columns'].length === 1) {
            index = 0;
            col_main = data['grid']['columns'][0];
        } else {
            index = 1;
            col_main = data['grid']['columns'][1];

            // 两层表头判断step隐藏状态
            var first_col = [];
            // 标记每个工序第一个字段隐藏状态
            var step_first_col_status = {};
            data['grid']['columns'][0].forEach(function (val) {
                if(val["step"] === "yes"){
                    if(val["hidden_status"] !== "yes"){
                        first_col.push(val);
                        step_first_col_status[val["fname"]] = false;
                    }else {
                        step_first_col_status[val["fname"]] = true;
                    }
                }else {
                    first_col.push(val);
                }
            });
            data['grid']['columns'][0] = first_col;
        }

        // 生成非冻结列配置
        data['grid']['columns'][index] = Strack.generate_grid_columns_config(col_main, param, columns_field_config, step_first_col_status);

        //冻结字段
        if (data['grid']['frozenColumns'].length === 1) {
            froze_index = 0;
            frozecol_main = data['grid']['frozenColumns'][0];
        } else {
            froze_index = 1;
            frozecol_main = data['grid']['frozenColumns'][1];
        }

        // 生成冻结列配置
        data['grid']['frozenColumns'][froze_index] = Strack.generate_grid_columns_config(frozecol_main, param, columns_field_config, step_first_col_status);

        return data;
    },
    // 生成 datagrid 右键菜单
    generate_grid_right_menu: function(opts)
    {
        var grid_right_menu_data = [];
        var random_id, lang='', className= [], icon = '', click, attr_lang = '';
        $(opts.contextMenuData.edit_id).children(".item").each(function () {
            random_id = 'right_menu_'+Math.floor(Math.random() * 1000000 + 1);
            if($(this).prop("tagName") === "DIV"){
                // div item 下面还有子集
                lang = $(this).attr("data-lang");
                var temp = {
                    id: random_id,
                    lang: lang,
                    iconCls: '',
                    type: "button",
                    click: '',
                    children: []
                };
                var children_item = [];
                $(this).find(".group-field").each(function () {
                    random_id = 'right_menu_item'+Math.floor(Math.random() * 1000000 + 1);
                    lang = Strack.trim_spaces($(this).text(), 'g');
                    click = $(this).attr('onclick');
                    children_item.push({
                        id: random_id,
                        lang: lang,
                        iconCls: '',
                        type: "function",
                        click: click,
                        attr_data: {
                            grid: opts.id,
                            moduleid: opts.moduleId
                        }
                    });
                });

                if(children_item.length > 0){
                    temp['children'] = children_item;
                    grid_right_menu_data.push(temp);
                }
            }else {
                lang = Strack.trim_spaces($(this).text(), 'g');
                attr_lang = $(this).attr("data-lang");
                className = $(this).find('i').attr("class");
                if(!className){
                    icon = '';
                }else {
                    icon = className.split(" ")[0];
                }
                click = $(this).attr('onclick');
                grid_right_menu_data.push({
                    id: random_id,
                    lang: lang,
                    iconCls: icon,
                    type: "function",
                    click: click,
                    attr_data: {
                        lang: attr_lang,
                        grid: opts.id,
                        moduleid: opts.moduleId
                    }
                });
            }
        });

        grid_right_menu_data.push({id: "ac_copy_cell", lang: StrackLang["Copy_Grip_Cell"], iconCls: "icon-uniE943", type: "function", click: "Strack.copy_to_clipboard(this)", attr_data: {"clipboard-action": "copy", "clipboard-target": "#grid_clipboard"}});
        return grid_right_menu_data;
    },
    //加载 view 配置文件
    load_view_config: function (id, param, callback) {
        $.ajax({
            type: 'POST',
            url: StrackPHP['getListViewConfig'],
            data: param,
            dataType: 'json',
            success: function (data) {
                var $tool = $('#' + param.tool_id);
                //可以排序字段
                var $grid_sort = $tool.find(".grid_sort");
                $grid_sort.append(Strack.toolbar_down_init('sort', param.module_code, data["sort_list"], param.opts, 'list'));
                //初始化排序高亮按钮
                Strack.init_show_sort_down_icon($grid_sort, data["sort_config"]["sort_data"], data["sort_config"]["sort_type"]);
                //可以分组字段
                $tool.find(".grid_group").append(Strack.toolbar_down_init('group', param.module_code, data["group_list"], param.opts, 'list'));
                //当前模块视图
                $tool.find(".grid_view").append(Strack.toolbar_view_init('view', data["view_list"], 'list'));
                callback(data);
            }
        });
    },
    //初始化下拉菜单
    toolbar_down_init: function (from, data, opts, panel) {
        var temp_dom, dom = '';
        if (from === "show") {
            Strack.G.gridFieldCache[opts.toolbarConfig.page] = {};
        }
        for (var key in data) {
            for (var item in data[key]) {
                temp_dom = '';
                if (!$.isEmptyObject(data[key][item]["fields"])) {
                    data[key][item]["fields"].forEach(function (val) {
                        temp_dom += Strack.toolbar_down_item(from, val, panel);
                        if (from === "show") {
                            Strack.G.gridFieldCache[opts.toolbarConfig.page][val.value_show] = val;
                        }
                    });
                    dom += '<div class="divider custom-menu-item"></div>';
                    dom += Strack.toolbar_down_other(data[key][item]["title"], temp_dom);
                }
            }
        }
        return dom;
    },
    //工具栏下拉菜单
    toolbar_down_other: function (title, ldom) {
        var dom = '';
        dom += '<div class="item custom-menu-item">' +
            '<i class="dropdown icon"></i>' +
            title +
            '<div class="menu st-down-menu">' +
            ldom +
            '</div>' +
            '</div>';
        return dom;
    },
    //工具栏下拉菜单项
    toolbar_down_item: function (from, param, panel) {
        var dom = '';
        var id = from + '_' + param["module"] + '_' + param["fields"];
        var ckcss = param["is_checked"] ? 'icon-checked' : 'icon-unchecked';
        var item_css = from + "-field";

        dom += '<a href="javascript:;" id="' + id + '" class="item ' + item_css + '" onclick="Strack.click_down_item(this);" panel="' + panel + '" from="' + from + '" field="' + param.fields + '" field_type="' + param.field_type + '" field_width="' + param.width + '" field_sort="' + param.sort + '" field_edit="' + param.edit + '" module="' + param.module + '" table="' + param.table + '" module_code="'+param.module_code+'" module_type="' + param.module_type + '" belong="' + param.belong + '" editor="' + param.editor + '" lang="' + param.lang + '" value_show="' + param.value_show + '">' +
            '<i class="icon-left ' + ckcss + '"></i>' +
            param["lang"] +
            '</a>';
        return dom;
    },
    //初始化工序列表
    toolbar_step_init: function(from, data, opts, panel)
    {
        var dom = '';
        data.forEach(function (val) {
            dom += Strack.toolbar_step_dom(val, opts);
        });
        return dom;
    },
    // 工序列表DOM
    toolbar_step_dom: function(data, opts)
    {
        var is_check = '',hide_class ='';
        if(data['is_checked']){
            is_check =  '<i class="icon-uniEA39"></i>';
        }else {
            hide_class = "hide";
        }
        var dom = '';
        dom += '<a href="javascript:;" id="stid_'+data["code"]+'" class="item steps_box custom-menu-item '+hide_class+'" onclick="Strack.toggle_steps(this);" data-step="'+data["code"]+'" data-stepid="'+data["id"]+'" data-grid="'+opts["id"]+'" data-maindom="'+opts["searchConfig"]["filterBar"]["main_dom"]+'">'+
            '<div class="steps_box_icon">'+
            is_check+
            '</div>'+
            '<div class="steps_box_color" style="background-color:#'+data["color"]+'"></div>'+
            '<div class="steps_box_name">'+data["name"]+'</div>'+
            '</a>';
        return dom;
    },
    // 工具栏常用动作
    toolbar_common_action: function(grid, opts, data)
    {
        var dom = '';
        data.forEach(function (val) {
            val["grid"] = grid;
            val["module_id"] = opts.moduleId;
            dom += Strack.common_action_dom('grid_edit', val);
        });
        return dom;
    },
    // 工具栏常用动作DOM
    common_action_dom: function(from, data){
        var dom = '';
        var link_id = data["link_id"] ? data["link_id"]: 0;
        dom += '<a href="javascript:;" class="item group-field" onclick="Strack.click_run_action(this);" data-from="'+from+'" data-grid="'+data["grid"]+'" data-actionid="'+ data["id"]+'" data-linkid="'+ link_id+'" data-moduleid="'+ data["module_id"]+'">' +
            data["name"]+
            '</a>';
        return dom;
    },
    // 显示全部工序
    show_all_steps: function(i)
    {
        var param = {
            mode : "show_all",
            grid : $(i).data("grid"),
            maindom : $(i).data("maindom")
        };
        Strack.show_or_hide_steps(param);
    },
    // 隐藏全部工序
    hide_all_steps: function(i)
    {
        var param = {
            mode : "hide_all",
            grid : $(i).data("grid"),
            maindom : $(i).data("maindom")
        };
        Strack.show_or_hide_steps(param);
    },
    // 显示或隐藏单个工序列
    toggle_steps: function(i){
        var param = {
            mode : "",
            step : $(i).data("step"),
            step_id : $(i).data("stepid"),
            grid : $(i).data("grid"),
            maindom : $(i).data("maindom")
        };

        if($(i).hasClass("hide")){
            param["mode"] = "show";
            $(i).removeClass("hide");
        }else {
            param["mode"] = "hide";
            $(i).addClass("hide");
        }
        Strack.show_or_hide_steps(param);
    },
    // 执行显示或隐藏工序
    show_or_hide_steps: function(param){
        var $grid = $("#"+param.grid);
        var opts = $grid.datagrid("options");
        var columns = opts.columns[1];
        var step_cols = [];
        var $step_header;
        columns.forEach(function (val) {
            if(val.step){
                if(($.inArray(param["mode"], ["show", "hide"]) >= 0 && val.belong === param["step"]) || $.inArray(param["mode"], ["hide_all", "show_all"]) >= 0){
                    step_cols.push({field: val.field, belong: val.belong});
                }
            }
        });
        switch (param["mode"]){
            case "show":
                // 显示指定
                var field_list,field_arr;

                $step_header = $("."+param["step"]+"_h");
                if($step_header.length>0){
                    // 当前隐藏字段还存在于字段中
                    step_cols.forEach(function (val) {
                        // 判断当前内部字段是否显示
                        if($step_header.is(":hidden") && val.belong === param["step"]){
                            $step_header.show();
                            $grid.datagrid("showColumn", val.field);
                            if($step_header.attr("colspan") > 1){
                                field_list = $step_header.find(".colswitch").data("fieldlist");
                                field_arr = field_list.split(",");
                                field_arr.forEach(function (item) {
                                    $grid.datagrid("showColumn", param["step"]+'_'+item);
                                })
                            }
                        }
                    });
                }else {
                    // 重新组装step字段加入到数据表格中
                    var step_config = Strack.G.dataGridStepColunmsConfig[param.grid]["step_columns"][param["step"]];
                    if(!$.isEmptyObject(step_config)){
                        $grid.datagrid("appendStepColumn", step_config)
                            .datagrid("reload");
                    }
                }
                break;
            case "hide":
                // 隐藏指定
                step_cols.forEach(function (val) {
                    if(val.belong === param["step"]){
                        $grid.datagrid("hideColumn", val.field);
                        $("."+val.belong+"_h").hide();
                    }
                });
                break;
            case "show_all":
                // 全部显示
                var all_step_list = Strack.G.dataGridStepColunmsConfig[param.grid]["step_list"];
                var has_no_check_step = false;
                var exist_step_map = {};
                step_cols.forEach(function (val) {
                    if(!exist_step_map.hasOwnProperty(val.belong)){
                        exist_step_map[val.belong] = val;
                    }
                });

                all_step_list.forEach(function (step) {
                    $step_header = $("."+step+"_h");

                    if($step_header.length>0){
                        if($step_header.is(":hidden")){
                            $step_header.show();
                            $grid.datagrid("showColumn", exist_step_map[step]["field"]);
                            if($step_header.attr("colspan") > 1){
                                field_list = $step_header.find(".colswitch").data("fieldlist");
                                field_arr = field_list.split(",");
                                field_arr.forEach(function (item) {
                                    $grid.datagrid("showColumn", step+'_'+item);
                                })
                            }
                        }
                    }else {
                        has_no_check_step = true;
                        // 重新组装step字段加入到数据表格中
                        var step_config = Strack.G.dataGridStepColunmsConfig[param.grid]["step_columns"][step];
                        if(!$.isEmptyObject(step_config)){
                            $grid.datagrid("appendStepColumn", step_config);
                        }
                    }
                });

                if(has_no_check_step){
                    $grid.datagrid("reload");
                }
                break;
            case "hide_all":
                // 全部隐藏
                step_cols.forEach(function (val) {
                    $grid.datagrid("hideColumn", val.field);
                    $("."+val.belong+"_h").hide();
                });

                break;
        }

        Strack.show_or_hide_steps_icon(param);
    },
    // 处理工序显示隐藏图标
    show_or_hide_steps_icon: function(param)
    {
        var step;
        $("#"+param.maindom).find(".steps_box")
            .each(function () {
                step = $(this).data("step");
                switch (param["mode"]){
                    case "show":
                        if(param["step"] === step){
                            $(this).find(".steps_box_icon").html('<i class="icon-uniEA39"></i>');
                        }
                        break;
                    case "hide":
                        if(param["step"] === step){
                            $(this).find(".steps_box_icon").empty();
                        }
                        break;
                    case "show_all":
                        $(this).find(".steps_box_icon").html('<i class="icon-uniEA39"></i>');
                        break;
                    case "hide_all":
                        $(this).find(".steps_box_icon").empty();
                        break;
                }
            });
    },
    // 隐藏获取显示工序区域
    show_or_hide_grid_step: function(i){
        var $this = $(i);
        $this.html('<div class="ui active centered mini inline loader"></div>');
        var grid = $this.data("grid");
        var $grid = $("#"+grid),
            step = $this.attr('data-col'),
            color = $this.attr('data-color'),
            first_field = $this.attr('data-firstfield'),
            field_list = ($this.attr('data-fieldlist')).split(","),
            hstr = [];

        if(field_list.length > 0){

            field_list.forEach(function (val) {
                hstr.push(step + '_' + val);
            });

            var colspan = 0;

            if ($this.hasClass('showcol')) {
                colspan = 1;

                $this.removeClass('showcol')
                    .parent().parent().attr('colspan', colspan);

                $('td[field=' + step + '_' + first_field + ']').removeClass("colleft").addClass("colboth");

                setTimeout(function () {
                    $this.html('<i class="icon-uniF101"></i>');
                }, 200);
            } else {
                colspan = hstr.length + 1;

                $this.addClass('showcol')
                    .parent().parent().attr('colspan', colspan);

                $('td[field=' + step + '_' + first_field + ']').removeClass("colboth").addClass("colleft");

                setTimeout(function () {
                    $this.html('<i class="icon-uniF100"></i>');
                }, 200);
            }

            $grid.datagrid('ResetStepColumnColspan', {'step' : step, "colspan": colspan, "field_list" : hstr});
        }
    },
    //初始化视图列表
    toolbar_view_init: function (from, data, panel) {
        var self_dom = '', public_dom = '', dom = '', checked = false;

        if (!$.isEmptyObject(data)) {
            //当前选中的
            dom += '<div class="divider custom-menu-item"></div>';
            dom += Strack.toolbar_view_item(from, data["checked"], 'view-g-active', panel);
            $(".current_view").text("（" + data["checked"]["name"] + "）");

            data["self"].forEach(function (val) {
                self_dom += Strack.toolbar_view_item(from, val, '', panel);
            });

            dom += '<div class="divider custom-menu-item"></div>';
            dom += Strack.toolbar_down_other(StrackLang["Self_View"], self_dom);

            data["public"].forEach(function (val) {
                public_dom += Strack.toolbar_view_item(from, val, '', panel);
            });

            dom += '<div class="divider custom-menu-item"></div>';
            dom += Strack.toolbar_down_other(StrackLang["Public_View"], public_dom);
        }

        return dom;
    },
    //工具栏视图item
    toolbar_view_item: function (from, param, extra_css, panel) {
        var dom = '';
        var ckcss = param.checked ? 'icon-checked' : 'icon-unchecked';
        var user_name = param.show_artist ? '<span style="color: #777"> ( ' + param.user_name + ' ) </span>' : '';

        dom += '<a href="javascript:;" class="item view-g-item custom-menu-item ' + extra_css + '" onclick="Strack.click_down_item(this);" panel="' + panel + '" from="' + from + '" view_id="' + param["id"] + '" view_name="' + param["name"] + '" view_public="' + param["public"] + '" allow_edit="' + param["allow_edit"] + '">' +
            '<i class="icon-left ' + ckcss + '"></i>' +
            param["name"] + user_name +
            '</a>';
        return dom;
    },
    //生成当前视图工具栏
    build_view_toolbar: function (param, callback) {
        $.ajax({
            type: 'POST',
            url: StrackPHP['getViewData'],
            dataType: 'json',
            data: {
                module_id: param["module_id"],
                structure_id: param["structure_id"],
                tab_name: param["tab_name"]
            },
            success: function (data) {
                Strack.build_toolbar_sort(param, data["sort_fields"]);
                Strack.build_toolbar_group(param, data["group_fields"]);
                callback(data);
            }
        });
    },
    //生成工具栏排序列表
    build_toolbar_sort: function (param, fields) {
        var $sort = $("#" + param["tab_name"] + "_sort_" + param["structure_id"]);
        var dom = '';
        if ($sort.length > 0) {
            switch (param["tab_name"]) {
                case "list":
                    fields.forEach(function (val) {
                        dom += Strack.sort_field_dow(param, val);
                    });
                    break;
                default:
                    break;
            }
            $sort.empty().append(dom);
        }
    },
    //允许排序字段
    sort_field_dow: function (param, data) {
        var dom = '';
        dom += '<a href="javascript:;" id="sort_field_' + param["tab_name"] + '_' + param["structure_id"] + '_' + data["field"] + '" class="item sort_fields" onclick="Strack.sort_change(this);" data-field="' + data["field"] + '" data-pid="' + data["p_id"] + '" data-structureid="' + data["structure_id"] + '" data-grid="' + data["grid"] + '">' +
            '<i class="icon-left sort_list icon-unchecked"></i>' +
            data["lang"] +
            '</a>';
        return dom;
    },
    //生成工具栏分组列表
    build_toolbar_group: function (param, fields) {
        var $goup = $("#" + param["tab_name"] + "_group_" + param["structure_id"]);
        var dom = '';
        if ($goup.length > 0) {
            switch (param["tab_name"]) {
                case "list":
                    fields.forEach(function (val) {
                        dom += Strack.group_field_dow(param, val);
                    });
                    break;
                default:
                    break;
            }
            $goup.empty().append(dom);
        }
    },
    // 下拉group dwon item
    group_field_dow: function (param, data) {
        var dom = '';
        dom += '<a href="javascript:;" id="group_field_' + param["tab_name"] + '_' + param["structure_id"] + '_' + data["field"] + '" onclick="Strack.group_sort_change(this);" data-field="' + data["field"] + '" data-pid="' + data["p_id"] + '" data-structureid="' + data["structure_id"] + '" data-grid="' + data["grid"] + '">' +
            '<i class="icon-left filter_list icon-unchecked"></i>' +
            data["lang"] +
            '</a>';
        return dom;
    },
    //项目错误警告
    project_warn: function (lang) {
        return '<div class="page-warning"><i class="icon-uniF071"></i>' + lang + '</div>';
    },
    //初始化面包屑导航
    init_breadcrumb: function (id, param, callback) {
        $.ajax({
            type: 'POST',
            url: StrackPHP['getModuleBreadcrumb'],
            dataType: "json",
            data: param,
            beforeSend: function () {
                $('#' + id).append(Strack.loading_dom('white', "", "breadcrumb"));
            },
            success: function (data) {
                var dom = Strack.breadcrumb_dom(data, param);
                $('#' + id).empty().append(dom);
                if(callback){
                    callback(dom);
                }
            }
        });
    },
    // 生成详情页面url
    details_url: function (param, val) {
        var base_url = Strack.remove_html_ext(StrackPHP["details"]);
        return base_url + '/' + param["module_id"] + '-' + param["project_id"] + '-' + val + '.html';
    },
    // 面包屑
    breadcrumb_dom: function (data, param) {
        var dom = [];
        var base_url = Strack.remove_html_ext(StrackPHP["details"]);
        data.forEach(function (val) {
            if (val["is_self"] === "no") {
                dom.push('<a class="section" href="' + base_url + '/' + val["module_id"] + '-' + param["project_id"] + '-' + val["item_id"] + '.html" title="(' + val["module_lang"] + ') ' + val["name"] + '">(' + val["module_lang"] + ') ' + val["name"] + '</a>');
            } else {
                dom.push('<div class="section" title="' + val["name"] + '">' + val["name"] + '</div>');
            }
        });
        return '<div class="ui small breadcrumb" >' + dom.join('<div class="divider"> / </div>') + '</div>';
    },
    //初始化 Tabs
    init_tab_list: function (id, param, call) {
        $.ajax({
            type: 'POST',
            url: StrackPHP['getTabConfig'],
            dataType: "json",
            data: param,
            beforeSend: function () {
                $('#' + id).append(Strack.loading_dom('white', "", "tab"));
            },
            success: function (data) {
                Strack.generate_tab_list(id, param, data);
                call(data);
                $("#st-load_tab").remove();
            }
        });
    },
    // 生成详情页面 tab
    generate_tab_list: function(id, param, data)
    {
        var $tab = $("#" + id);
        var $tab_wrap = $tab.find(".tabs-tab-list");
        var tab_dom = '';

        if(data.length > 0){
            data.forEach(function (val) {
                tab_dom += Strack.tab_item_dom(id, val);
            });
        }

        // 增加详情页面tab快速配置按钮
        // param["position"] !== "grid_slider"
        if(param["rule_template_fixed_tab"] === "yes"){
            tab_dom += Strack.tab_item_config_dom(param);
        }

        $tab_wrap.empty().append(tab_dom);
        //监听dom变化事件
        Strack.tab_auto_hide($tab);

        var pos = $tab.attr("data-pos");
        var wrap_w = 0;
        if(pos === "details"){
            wrap_w = document.body.clientWidth;
        }else {
            wrap_w = $tab.width();
        }

        if ($tab_wrap[0].scrollWidth > wrap_w) {
            $tab.addClass("tabs-nav-container-scrolling");
        }
    },
    //tab dom 动态变化
    tab_auto_hide: function ($tab) {
        var $prev = $tab.find(".tabs-tab-prev"),
            $next = $tab.find(".tabs-tab-next");
        $tab.on("mresize", function () {
            Strack.init_tab_scrolling($tab, $prev, $next);
        });
    },
    //tab标签dom
    tab_item_dom: function (id, data) {
        var dom = '';
        var tab_name = data["type"] === "be_horizontal_relationship" ? '<i class="icon-uniE692 icon-left"></i>'+ data["name"] : data["name"];
        dom += '<a href="javascript:;" id="' + data["tab_id"] + '" class="item tab_item" onclick="Strack.select_tab_item(this);"  data-parentid="' + id + '" data-horizontaltype="' + data["horizontal_type"] + '" data-table="' + data["table"] + '" data-tabid="' + data["tab_id"] + '" data-group="' + data["group"] + '" data-type="' + data["type"] + '" data-moduleid="' + data["module_id"] + '"  data-dstmoduleid="' + data["dst_module_id"] + '"  data-dstmodulecode="' + data["dst_module_code"] + '" data-variableid="'+data["variable_id"]+'" data-modulecode="' + data["module_code"] + '" data-moduletype="' + data["module_type"] + '">' + tab_name + '</a>';
        return dom;
    },
    //tab标签配置按钮dom
    tab_item_config_dom: function (param) {
        var dom = '';
        dom += '<a href="javascript:;" class="item tab_item" onclick="Strack.tab_item_config(this);" data-itemid="'+param["item_id"]+'" data-moduleid="'+param["module_id"]+'" data-modulecode="'+param["module_code"]+'" data-templateid="'+param["template_id"]+'" data-projectid="'+param["project_id"]+'"><i class="icon-uniF013 icon-left"></i>' + StrackLang["Template_Fixed_Tab"] + '</a>';
        return dom;
    },
    // 点击配置tab 配置按钮
    tab_item_config: function(i)
    {
        var category = 'tab',
            title = StrackLang["Template_Fixed_Tab"];
        var module_id = $(i).attr("data-moduleid");
        var item_id = $(i).attr("data-itemid");
        var module_code = $(i).attr("data-modulecode");
        var temp_id = $(i).attr("data-templateid");
        var project_id = $(i).attr("data-projectid");
        var pos = $(i).closest(".projitem-footer").attr("data-pos");

        Strack.template_set_dialog({'datalist_url': StrackPHP["getModuleTabList"], 'config_url': StrackPHP["getTemplateConfig"], 'title':title, 'item_id':item_id, 'temp_id': temp_id, 'module_code':module_code, 'module_id':module_id, 'project_id':project_id, 'category': category, 'id_field' : 'tab_id' , 'text_field' : 'name', 'text_field_lang' : StrackLang["Tab"], 'group' : 'group', 'limit': 0, 'submit_bnt'  :'update_details_tab_set', 'pos': pos});
    },
    //点击选择tab item
    select_tab_item: function (i) {
        var tab_name = $(i).html();
        var parent_id = $(i).attr("data-parentid"),
            tab_id = $(i).attr("data-tabid"),
            module_id = $(i).attr("data-moduleid"),
            module_type= $(i).attr("data-moduletype"),
            dst_module_id = $(i).attr("data-dstmoduleid"),
            dst_module_code = $(i).attr("data-dstmodulecode"),
            module_code = $(i).attr("data-modulecode"),
            variable_id= $(i).attr("data-variableid"),
            type = $(i).attr("data-type"),
            group = $(i).attr("data-group"),
            horizontal_type = $(i).attr("data-horizontaltype"),
            table = $(i).attr("data-table");
        // 初始化面板操作
        switch (parent_id) {
            case "details_tab":
                // 详情页面
                obj.show_details_tab_page({
                    tab_id: tab_id,
                    name: tab_name,
                    type: type,
                    group: group,
                    module_id: module_id,
                    module_type: module_type,
                    dst_module_id: dst_module_id,
                    dst_module_code: dst_module_code,
                    variable_id: variable_id,
                    module_code: module_code,
                    horizontal_type: horizontal_type,
                    table: table
                });
                break;
            case "grid_slider_tab":
                // 数据表格边侧栏
                Strack.show_datagrid_slider_tab({
                    tab_id: tab_id,
                    name: tab_name,
                    type: type,
                    group: group,
                    module_id: module_id,
                    dst_module_id: dst_module_id,
                    module_code: module_code,
                    variable_id: variable_id,
                    horizontal_type: horizontal_type,
                    table: table
                });
                break;
            default:

                break;
        }
    },
    // active tab
    active_select_tab: function (parent_id, tab) {
        $("#" + parent_id).find(".tabs-tab-list .tab_item")
            .each(function () {
                if ($(this).attr("data-tabid") === tab) {
                    $(this).addClass("active");
                } else {
                    $(this).removeClass("active");
                }
            });
    },
    //绑定tab隐藏处理事件
    init_tab_scrolling: function ($tab, $prev, $next) {
        var allow_w = 0;
        var $tab_wrap = $tab.find(".tabs-tab-list");
        var scroll_w = $tab_wrap[0].scrollWidth;

        //滚动条清零
        Strack.G.leftScrolling = 0;
        $tab_wrap.scrollLeft(0);
        $prev.addClass("tabs-tab-btn-disabled");
        $next.removeClass("tabs-tab-btn-disabled");

        var pos = $tab.attr("data-pos");
        var wrap_w = 0;
        if(pos === "details"){
            wrap_w = document.body.clientWidth;
        }else {
            wrap_w = $tab.width();
        }

        if (scroll_w > wrap_w) {
            if (!$tab.hasClass("scrolling_active")) {
                $tab.addClass("scrolling_active");
                $tab.addClass("tabs-nav-container-scrolling");
                $prev.addClass("tabs-tab-arrow-show")
                    .addClass("tabs-tab-btn-disabled")
                    .on("click", function () {
                            if (!$(this).hasClass("tabs-tab-btn-disabled")) {
                                //向左滚动
                                allow_w = $tab_wrap.width();
                                if (Strack.G.leftScrolling > 0) {
                                    Strack.G.leftScrolling = $tab_wrap.scrollLeft() - allow_w;
                                    $tab_wrap.scrollLeft(Strack.G.leftScrolling);
                                    $next.removeClass("tabs-tab-btn-disabled");
                                    if (Strack.G.leftScrolling <= 0) {
                                        $prev.addClass("tabs-tab-btn-disabled");
                                    }
                                }
                            }
                        }
                    );

                $next.addClass("tabs-tab-arrow-show")
                    .on("click", function () {
                            if (!$(this).hasClass("tabs-tab-btn-disabled")) {
                                //向右滚动
                                allow_w = $tab_wrap.width();
                                if (Strack.G.leftScrolling <= scroll_w) {
                                    Strack.G.leftScrolling = allow_w + $tab_wrap.scrollLeft();
                                    $tab_wrap.scrollLeft(Strack.G.leftScrolling);
                                    $prev.removeClass("tabs-tab-btn-disabled");

                                    if (Strack.G.leftScrolling >= scroll_w) {
                                        $next.addClass("tabs-tab-btn-disabled");
                                    }
                                }
                            }
                        }
                    );
            }
        } else {
            $tab.removeClass("tabs-nav-container-scrolling");
            $tab.removeClass("scrolling_active");
            $tab.find(".tabs-tab-prev").removeClass("tabs-tab-arrow-show").off("click");
            $tab.find(".tabs-tab-next").removeClass("tabs-tab-arrow-show").off("click");
        }
    },
    //关闭dialog
    dialog_cancel: function (i) {
        if(i){
            var $window_body = $(i).closest(".window-body");
            var id = $window_body.attr("id");
            $('#'+id).dialog('close');
        }else {
            $('#dialog').dialog('close');
        }
    },
    //Scheduler 显示 tips
    scheduler_tips: function (target, id) {
        $.ajax({
            url: StrackPHP["getSchedulerTips"],
            type: "post",
            data: {
                resourceId: id
            },
            dataType: "json",
            success: function (data) {
                var tipDom = '';
                data.forEach(function (val) {
                    tipDom += '<p>' + val + '</p>';
                });
                layer.tips(tipDom, target, {
                    tips: [3, '#464646'],
                    time: 20000
                });
            }
        });
    },
    //净化字段
    widget_field_validate: function (w_field) {
        var is_field = '';
        ["status_id"].every(function (field) {
            if (w_field.indexOf(field) >= 0) {
                is_field = field;
                return false;
            } else {
                is_field = w_field;
            }
            return true;
        });
        return is_field;
    },
    //初始化控件值
    widget_input_value: function (config, val, project_id, is_group, param) {
        var group = is_group? is_group : false;
        var value_show_key = config["value_show"];
        var build_val = {"value": val[value_show_key], "project_id": project_id};
        if(config.field_type==='custom' &&
            (
                (config.type === "belong_to" && $.inArray(config.relation_module_code, [ "status", "media"]) >=0) ||
                (config.hasOwnProperty("custom_config") && $.inArray(config.custom_config.relation_module_code, [ "status", "media"]) >=0)
            )
        ){
            var relation_module_code = config.hasOwnProperty("custom_config") ? config.custom_config.relation_module_code : config.relation_module_code;
            switch (relation_module_code){
                case "status":
                    if(val[value_show_key] && val[value_show_key]["total"] > 0){
                        build_val["value"] = val[value_show_key]["rows"][0]["id"];
                        build_val["show_val"] = Strack.widget_status_dom(val[value_show_key]["rows"][0]["icon"], val[value_show_key]["rows"][0]["name"], val[value_show_key]["rows"][0]["color"]);
                        build_val["bg_clolor"] = val[value_show_key]["rows"][0]["color"];
                        build_val["font_set"] = true;
                    }else {
                        build_val["value"] = '';
                        build_val["show_val"] = '';
                    }
                    break;
                case "media":
                    build_val["value"] = "";
                    build_val["show_val"] = Strack.thumb_media_common_dom(val[value_show_key], {param: param, from: param.from, config: config});
                    break;
            }
        }else {
            if(config["field_type"] === "custom" && config["editor_type"] === "has_many"){
                if(val[value_show_key] && val[value_show_key]["total"] > 0){
                    var ids = [], name_list = [];
                    val[value_show_key]["rows"].forEach(function (val) {
                        ids.push(val["id"]);
                        name_list.push(val["name"]);
                    });
                    build_val["value"] = ids.join(",");
                    build_val["show_val"] = name_list.join(",");
                }else {
                    build_val["value"] = "";
                    build_val["show_val"] = "";
                }
            }else {

                if(config.fields === "thumb" && config.module_code === "media"){
                    build_val["value"] = "";
                    build_val["show_val"] = Strack.thumb_media_common_dom(val[value_show_key], {param: param, from: param.from, config: config});
                } else  if(val[value_show_key] && val[value_show_key]["total"] >= 0) {
                    var ids = [], name_list = [];
                    if (val[value_show_key]["total"] > 0) {
                        val[value_show_key]["rows"].forEach(function (val) {
                            ids.push(val["id"]);
                            name_list.push(val["name"]);
                        });
                        build_val["value"] = ids.join(",");
                        build_val["show_val"] = name_list.join(",");
                    } else {
                        build_val["value"] = "";
                        build_val["show_val"] = "";
                    }
                }else {
                    build_val["show_val"] = val[value_show_key];
                }
            }

            build_val["bg_clolor"] = "";
            build_val["font_set"] = "";
        }
        return build_val;
    },
    //生成控件
    generate_widget: function (config, val, primary, project_id, wpos, c_module_id) {
        var pos = wpos ? wpos : '';
        var module_id = c_module_id? c_module_id: 0;
        var dom = '';
        if(config["group"] === "no"){
            config["data"].forEach(function (cval) {
                if (cval["show"] === "yes") {
                    dom += Strack.widget_input_dom(cval, primary, Strack.widget_input_value(cval, val, project_id, false, {primary: primary, module_id: module_id, from: pos}), pos, true, {module_id: module_id});
                }
            });
        }else {
            for(var key in config["data"]){
                dom += '<div class="task-info-names"><i class="icon-uniF05A icon-left"></i>'+StrackLang[key]+'</div>';
                config["data"][key].forEach(function (cval) {
                    if (cval["show"] === "yes") {
                        dom += Strack.widget_input_dom(cval, primary, Strack.widget_input_value(cval, val, project_id, true, {primary: primary, module_id: module_id, from: pos}), pos, true, {module_id: module_id});
                    }
                });
            }
        }

        return dom;
    },
    //控件基础dom
    widget_input_dom: function (config, primary, val, pos, has_title, param) {
        var bg_clolor = val["bg_clolor"] ? Strack.hex_to_rgb(val["bg_clolor"], 0.3) : 'transparent',
            font_set = val["font_set"] ? 'font-size-10' : '';

        var module_id = param.hasOwnProperty("module_id") ? param["module_id"]:0;

        var fields  = '',
            frozen_module = '';
        if(config["is_foreign_key"] === "yes"){
            fields = config["foreign_key"];
            frozen_module = config["frozen_module"];
        }else {
            fields = config["fields"];
            frozen_module = config["module_code"];
        }

        var widget_id = fields + '_' + primary + '_' + Math.floor(Math.random() * 10000 + 1);

        var regx = /^[0-9]+.?[0-9]*$/;
        var value, css_obj, dom = '';

        var variable_id = 0;
        if(config["field_type"] === "custom"){
            variable_id = config["variable_id"];
        }

        if (val["value"] && !regx.test(val["value"])) {
            value = val["value"].toString().replace(/\"/g, "&quot;");
        } else {
            value = val["value"]? val["value"] : '';
        }

        switch (pos) {
            case "grid":
            case "min":
                css_obj = {
                    wrap: "item-list-pt",
                    lang: "item-list-ptn",
                    content: "item-list-input",
                    hide: "icon-hide-min"
                };
                break;
            case "max":
            default:
                css_obj = {
                    wrap: "task-info-items",
                    lang: "task-info-title",
                    content: "task-info-content",
                    hide: "icon-hide"
                };
                break;
        }

        var edit_css = {};
        var show_val = '';

        switch (config["editor"]) {
            case "textarea":
                edit_css["ellipsis"] = "info-textarea";
                show_val = val["show_val"] ? Strack.revert_textarea(val["show_val"]) : "";
                break;
            default:
                edit_css["ellipsis"] = "text-ellipsis";
                show_val = val["show_val"] ? val["show_val"] : "";
                break;
        }

        dom += '<div class="' + css_obj["wrap"] + ' overflow-hide">';
        if (has_title) {
            dom += '<div class="' + css_obj["lang"] + ' aign-left">' + config["lang"] + '</div>';
        }

        // 通用控件唯一class
        var field_class_uuid = config["value_show"]+'_'+primary;

        dom += '<div class="widget_input ' + css_obj["content"] + ' aign-left item-hover ' + field_class_uuid + ' ' + font_set + ' " style="background-color:' + bg_clolor + '">';

        var data_source = '';
        if(config["data_source"]){
            data_source = config["data_source"];
        }

        var mask = config["mask"]? config["mask"] :'';

        if( config["edit"] !== "deny" &&
            (
                (config["from_module_code"] === config["belong_module"] && config["editor"] !== "none") ||
                (config["from_module_code"] !== config["belong_module"] && config["outreach_editor"] !== "none")
            )
        ){
            //允许编辑 绑定每个页面自己的js obj对象
            dom += '<a href="javascript:;" class="aign-right ' + css_obj["hide"] + ' widget-edit" onclick="Strack.widget_input_edit(this)"  data-widgetid="'+widget_id+'" data-module="' + config["module"] + '" data-flgmodule="' + config["flg_module"] + '" data-table="' + config["table"] + '" data-ofields='+config["fields"]+' data-fields="' + fields + '" data-fieldtype="' + config["field_type"] + '" data-value="' + value + '" data-primary="' + primary + '"  data-editor="' + config["editor"] + '" data-mask="'+mask+'" data-multiple="'+config["multiple"]+'" data-projectid="' + val['project_id'] + '" data-frozenmodule="'+ frozen_module +'" data-datasource="'+data_source+'" data-variableid="'+variable_id+'" data-moduleid="'+module_id+'" data-modulecode="'+config["module_code"]+'" data-fielduuid="'+field_class_uuid+'">';
            dom += '<i class="icon-uniE684"></i>';
        } else {
            //不允许编辑
            dom += '<a href="javascript:;" class="aign-right ' + css_obj["hide"] + ' widget-edit">';
            dom += '<i class="icon-uniE63D2"></i>';
        }
        dom += '</a>';
        if(pos === "grid"){
            if(config["fields"] === "thumb" || (config["field_type"] === "custom" && config["custom_config"]["relation_module_code"] === "media")){
                dom += '<div class=item-list-ptc">';
                dom += show_val; //显示内容
                dom += '</div>';
            }else {
                var href = param.hasOwnProperty("url") ? param.url : "javascript:;";
                dom += '<a href="'+href+'" class="info-content-show  info-grid-content ' + edit_css["ellipsis"] + ' widget-show-' + widget_id + '" target="_blank">';
                dom += show_val; //显示内容
                dom += '</a>';
            }
        }else {
            dom += '<div class="info-content-show  ' + edit_css["ellipsis"] + ' widget-show-' + widget_id + '">';
            dom += show_val; //显示内容
            dom += '</div>';
        }
        dom += '</div>';
        dom += '</div>';
        return dom;
    },
    //初始化可编辑field
    widget_input_edit: function (i) {
        var w = $(i).parent().width(),
            h = $(i).parent().height();
        h = h > 35 ? 35 : h;

        var module = $(i).attr("data-module"),
            frozen_module = $(i).attr("data-frozenmodule"),
            fields = $(i).attr("data-fields"),
            flg_module = $(i).attr("data-flgmodule"),
            field_type = $(i).attr("data-fieldtype"),
            widgetid = $(i).attr("data-widgetid"),
            value = $(i).attr("data-value"),
            primary = $(i).attr("data-primary"),
            editor = $(i).attr("data-editor"),
            validate = $(i).attr("data-validate"),
            mask = $(i).attr("data-mask"),
            multiple = $(i).attr("data-multiple"),
            data_source = $(i).attr("data-datasource"),
            project_id = $(i).attr("data-projectid"),
            module_id = $(i).attr("data-moduleid"),
            module_code= $(i).attr("data-modulecode"),
            variable_id = $(i).attr("data-variableid");


        var valid = "";
        if (validate) {
            var valid_val = validate.split(",");
            valid = "length[" + valid_val[0] + "," + valid_val[1] + "]";
        }

        switch (editor){
            case "upload":
                // 缩略图上传控件
                Strack.open_change_item_media({title: StrackLang['Modify_Thumb'], link_id:primary, module_id: module_id, mode: "single", from: 'common', field_type: field_type, variable_id: variable_id}, function () {});
                break;
            default:
                Strack.widget_edit_active(i, w, h, {
                    module: module,
                    fields: fields,
                    flg_module: flg_module,
                    frozen_module: frozen_module,
                    field_type: field_type,
                    widgetid: widgetid,
                    value: value,
                    primary: primary,
                    editor: editor,
                    validate: valid,
                    mask: mask,
                    multiple: multiple,
                    project_id: project_id,
                    variable_id: variable_id,
                    module_id: module_id,
                    module_code: module_code,
                    data_source: data_source
                });
                break;
        }
    },
    //编辑控件
    widget_edit_active: function (i, w, h, data) {
        //保存当前面板已经打开的控件
        Strack.widget_update();
        var $this = $(i),
            $parent = $this.parent();

        var Ewidget_id;

        $this.hide().next().hide();
        if ($parent.hasClass('widget-active')) {
            $parent.addClass('widget-show')
                .find('.info-content-edit')
                .show();

            //不创建了但要重新赋值 说多了都是泪……
            Ewidget_id = $parent.find('.info-content-edit').find('input').eq(0).attr('id');
            var $Ewidget = $('#' + Ewidget_id);
            switch (data["editor"]) {
                case 'tagbox':
                    if(data["value"]) {
                        $Ewidget.tagbox('setValues', data["value"]);
                    }
                    break;
                case 'combobox':
                    $Ewidget.combobox('setValue', data["value"]);
                    break;
                case 'datebox':
                    $Ewidget.datebox('setValue', data["value"]);
                    break;
                case 'checkbox':
                    if (parseInt(data["value"]) === 1) {
                        $Ewidget.prop("checked", 'checked');
                    } else {
                        $Ewidget.removeAttr("checked");
                    }
                    break;
                default:
                    $Ewidget.val(data["value"]);
                    break;
            }
        } else {
            //创建dom
            var ext_css = "";
            Ewidget_id = data["widgetid"]; //加入随机数让同一编辑框可以在一个页面共存

            switch (data["editor"]) {
                case "textarea":
                    $parent.append('<div class="info-content-edit"><textarea id="' + Ewidget_id + '" class="widget-edit" data-module="' + data["module"] + '" data-field="' + data["fields"] + '" data-oldval="' + data["value"] + '" data-fieldtype="' + data["field_type"] + '" data-widgetid="' + data["widgetid"] + '"  data-primary="' + data["primary"] + '"  data-editor="' + data["editor"] + '" data-variableid="' + data["variable_id"] + '" data-moduleid="'+data["module_id"]+'" data-modulecode="'+data["module_code"]+'" ></textarea></div>')
                        .addClass('widget-active widget-show');
                    break;
                default:
                    if ($.inArray(data["editor"], ["input", "combobox", "datebox"]) >= 0) {
                        ext_css = "info-content-comb";
                    }
                    $parent.append('<div class="info-content-edit ' + ext_css + '"><input id="' + Ewidget_id + '" class="widget-edit" data-module="' + data["module"] + '" data-field="' + data["fields"] + '" data-oldval="' + data["value"] + '" data-fieldtype="' + data["field_type"] + '" data-widgetid="' + data["widgetid"] + '"  data-primary="' + data["primary"] + '"  data-editor="' + data["editor"] + '" data-variableid="' + data["variable_id"] + '" data-moduleid="'+data["module_id"]+'" data-modulecode="'+data["module_code"]+'" /></div>')
                        .addClass('widget-active widget-show');
                    break;
            }
            Strack.widget_init_dom(Ewidget_id, w, h, data);
        }
    },
    // 激活掩码
    active_inputmask: function (dom, mask) {
        if (mask) {
            $('#' + dom).inputmask(mask);
        }
    },
    // 初始化控件 保存触发两个事件 1、本身的blur 2、点击空白
    widget_init_dom: function (dom, w, h, data) {
        var $dom = $('#' + dom);
        var set_val = data["value"]? data["value"] : data['default_val'] ? data['default_val'] : "";
        switch (data["editor"]) {
            case "input":
            case "text":
                var validate = '';
                //就是input输入框 带验证
                if (data["validate"].indexOf(',') >= 0) {
                    validate = 'length[' + data["validate"] + ']';
                } else {
                    validate = data["validate"];
                }
                $dom.css({'width': w - 32, 'height': h - 2, 'padding': '0px 15px'})
                    .addClass('widget-edit')
                    .val(set_val)
                    .select(); //默认选中

                Strack.active_inputmask(dom, data["mask"]);
                break;
            case 'tagbox'://tagbox
                var query_params = {
                    primary: 0,
                    add_default: 'no',
                    project_id: data['project_id'],
                    module: data['module'],
                    field_type: data['field_type'],
                    fields: data['fields'],
                    variable_id: data['variable_id'],
                    frozen_module: data['frozen_module'],
                    flg_module: data['flg_module'],
                    data_source: data['data_source'],
                    module_id: data['module_id']
                };
                var tag_params ={
                    width: w,
                    height: 'auto',
                    minHeight: h-2,
                    valueField: 'id',
                    textField: 'name',
                    method: 'post',
                    url: StrackPHP["getWidgetData"],
                    hasDownArrow: true,
                    limitToList: true,
                    value: set_val,
                    queryParams: query_params
                };
                if($.inArray(data['module'], ["tag", "tag_link"]) >= 0){
                    tag_params['limitToList'] = false;
                    tag_params['allowInput'] = true;
                    tag_params['appendToDB'] = {
                        allow : true,
                        param : query_params
                    };
                }
                if (data['group']) {
                    tag_params["groupField"] = 'group';
                }
                $dom.tagbox(tag_params).next().find('input').eq(0)
                    .addClass('widget-edit');
                break;
            case "combobox"://combobox
                var isEditable = true, multiple = false;
                if (data["multiple"] === "yes") {
                    multiple = true;
                }
                switch (data["field"]) {
                    case 'assignee':
                    case 'cc':
                        $dom.combobox({
                            url: StrackPHP['getWidgetData'],
                            queryParams: data,
                            valueField: 'id',
                            textField: 'name',
                            groupField: data["group"],
                            multiple: multiple,
                            width: w,
                            height: h,
                            editable: isEditable,
                            value: set_val,
                            formatter: function (row) {
                                return Strack.build_comb_avatar(row);
                            }
                        }).next().find('input').eq(0)
                            .addClass('widget-edit');
                        break;
                    default:
                        $dom.combobox({
                            url: StrackPHP['getWidgetData'],
                            queryParams: data,
                            valueField: 'id',
                            textField: 'name',
                            groupField: data["group"],
                            multiple: multiple,
                            width: w,
                            height: h,
                            editable: isEditable,
                            value: set_val
                        }).next().find('input').eq(0)
                            .addClass('widget-edit');
                        break;
                }
                break;
            case "checkbox":
                var checked;
                if (parseInt(data["value"]) === 0 || !data["value"]) {
                    checked = false;
                } else {
                    checked = true;
                }
                $dom.attr('type', 'checkbox')
                    .attr('checked', checked)
                    .parent()
                    .css('padding', '0px 10px');
                break;
            case "datebox"://datebox
                $dom.datebox({width: w, height: h, editable: false, value: set_val})
                    .next().find('input').eq(0)
                    .addClass('widget-edit');
                break;
            case "datetimebox"://datebox
                $dom.datetimebox({width: w, height: h, editable: false, value: set_val})
                    .next().find('input').eq(0)
                    .addClass('widget-edit');
                break;
            case "textarea":
                $dom.html(set_val);
                break;
            case "upload":
                // 上传组件
                Strack.widget_init_upload_dom(dom, w, h, data);
                break;
        }
    },
    // 初始化上传通用控件
    widget_init_upload_dom : function(dom, w, h, data){
        var check_data;
        Strack.get_media_server(
            function (media_server) {
                $('#'+dom).uploadifive({
                    'auto': false,
                    'width' : 258,
                    'formData': {
                        timestamp: Strack.current_time(),
                        token: media_server['token'],
                        size : '250x140'
                    },
                    'multi': false,
                    'queueSizeLimit': 1,
                    'queueID': 'widget_queue',
                    'uploadScript': media_server["upload_url"],
                    'onUpload': function (file) {
                        var $window_body = $(this).closest(".window-body");
                        var comb_id = $window_body.find("#Nup_fields")[0];
                        var form_id = $window_body.find("#st_dialog_form")[0];
                        check_data = Strack.check_item_operate_fields(comb_id, form_id);
                        if (check_data.allow_up && file !== 0) {
                            $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                        }else {
                            return false;
                        }
                    },
                    'onUploadComplete': function (file, data) {
                        var resJson = JSON.parse(data);
                        if (parseInt(resJson['status']) === 200) {
                            // 上传成功写入数据库
                            var param = Strack.get_update_item_hide_param(this);
                            check_data.up_data["media"] = Strack.generate_widget_media_fields(media_server, param, resJson['data']);
                            Strack.submit_update_item(this, true, param, check_data.up_data);
                        } else {
                            layer.msg(resJson['message'], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            },
            function (data) {
                layer.msg(data['message'], {icon: 7, time: 1200, anim: 6});
                $("#Nup_fields").combobox("unselect", "media-thumb");
            }
        );
    },
    // 组装media写入字段
    generate_widget_media_fields: function(media_server, param, data)
    {
        var thumb_data = Strack.assembly_media_thumb_data(media_server, data);
        data["base_url"] = media_server["request_url"]+data["path"];
        var media_fields = {
            type : Strack.G.batchUploadMediaType,
            data : [
                {field : "media-module_id", field_type : "built_in", value : param.module_id, variable_id : 0},
                {field : "media-md5_name", field_type : "built_in", value : data.md5_name, variable_id : 0},
                {field : "media-thumb", field_type : "built_in", value : thumb_data.thumb, variable_id : 0},
                {field : "media-size", field_type : "built_in", value : thumb_data.size, variable_id : 0},
                {field : "media-param", field_type : "built_in", value : data, variable_id : 0},
                {field : "media-media_server_id", field_type : "built_in", value : media_server.id, variable_id : 0}
            ]
        };
        return media_fields;
    },
    // 执行提交更新
    item_operate_update: function (i) {
        var $window_body = $(i).closest(".window-body");
        var $media_upload_bnt = $window_body.find(".media-upload-bnt");
        var comb_id = $window_body.find("#Nup_fields")[0];
        var form_id = $window_body.find("#st_dialog_form")[0];
        if($media_upload_bnt.length > 0){
            // 存在媒体上传
            $media_upload_bnt.uploadifive("upload");
        }else {
            // 不存在媒体直接提交后台
            var check_data = Strack.check_item_operate_fields(comb_id, form_id);
            if (check_data.allow_up) {
                Strack.submit_update_item(i, false, Strack.get_update_item_hide_param(i), check_data.up_data);
            }
        }
    },
    // 执行提交combobox新增更多数据
    item_combobox_new_update: function (i) {
        var $window_body = $(i).closest(".window-body");
        var $media_upload_bnt = $window_body.find(".media-upload-bnt");
        var comb_id = $window_body.find("#Ncomb_up_fields")[0];
        var form_id = $window_body.find("#st_dialog_form")[0];
        if($media_upload_bnt.length > 0){
            // 存在媒体上传
            $media_upload_bnt.uploadifive("upload");
        }else {
            // 不存在媒体直接提交后台
            var check_data = Strack.check_item_operate_fields(comb_id, form_id);
            if (check_data.allow_up) {
                Strack.submit_update_item(i, false, Strack.get_update_item_hide_param(i), check_data.up_data);
            }
        }
    },
    // 获取隐藏数据值
    get_update_item_hide_param : function(i)
    {
        var $window_body = $(i).closest(".window-body");
        var param = {};
        //获取隐藏字段
        $window_body.find("#st_dialog_form_hide input").each(function () {
            param[$(this).attr("data-name")] = $(this).val();
        });

        var primary_id = $("#Nprimary_id").val();

        param['primary_id'] = primary_id.length>0 ?primary_id : 0;

        return param;
    },
    // 提交通用更新操作
    submit_update_item: function(i, has_media, param, up_data)
    {
        $.ajax({
            type: 'POST',
            url: StrackPHP['updateItemDialog'],
            data: JSON.stringify({
                param: param,
                data: up_data
            }),
            contentType: "application/json",
            dataType: "json",
            beforeSend: function () {
                if(!has_media){
                    $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                }
            },
            success: function (data) {
                if (parseInt(data['status']) === 200) {
                    Strack.top_message({bg: 'g', msg: data['message']});
                    Strack.dialog_cancel(i);
                    Strack.G.batchUploadMediaType = '';
                } else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
                $.messager.progress('close');
            }
        });
    },
    //点击空白触发 控件自动保存事件
    widget_update: function () {
        var $up = $('.widget-show');
        if ($up.length > 0) {
            var $adom = $up.find('a').eq(0),
                did = $up.find('.info-content-edit').find('input').eq(0).attr('id'),//当前事件的id
                table = $adom.attr('data-table'),
                module = $adom.attr('data-module'),
                original_field = $adom.attr('data-ofields'),
                field = $adom.attr('data-fields'),
                field_type = $adom.attr('data-fieldtype'),
                editor = $adom.attr('data-editor'),
                widget_id = $adom.attr('data-widgetid'),
                variable_id = $adom.attr('data-variableid'),
                primary = $adom.attr('data-primary'),
                multiple = $adom.attr('data-multiple'),
                module_id = $adom.attr('data-moduleid'),
                module_code = $adom.attr('data-modulecode'),
                project_id = $adom.attr('data-projectid'),
                data_source = $adom.attr('data-datasource'),
                field_class_uuid = $adom.attr('data-fielduuid'),
                $did = $('#' + did),
                inval = '';//dom 对象

            var old_val = $did.attr("data-oldval");
            var can_update = false;

            if(!old_val){
                old_val = '';
            }

            //隐藏显示
            $up.removeClass('widget-show')
                .find('a').eq(0).show()
                .next().show()
                .next().hide();

            //后台更新数据
            switch (editor) {
                case 'text':
                    inval = $did.val();
                    break;
                case 'tagbox':
                    inval = Strack.get_combos_val('#' + did, 'tagbox', 'getValues');
                    if (inval) {
                        inval = inval.join(',');
                    }else {
                        can_update = true;
                    }
                    break;
                case 'combobox':
                    if(multiple === "yes"){
                        inval = Strack.get_combos_val('#' + did, 'combobox', 'getValues');
                        if (inval) {
                            inval = inval.join(',');
                        }
                    }else {
                        inval = Strack.get_combos_val('#' + did, 'combobox', 'getValue');
                    }
                    break;
                case 'datebox':
                    inval = $did.datebox('getValue');
                    break;
                case 'datetimebox':
                    inval = $did.datetimebox('getValue');
                    break;
                case 'checkbox':
                    inval = $did.is(':checked') ? 1 : 0;
                    break;
                case 'tags':
                    var tag_arr = [];
                    $did.parent().find('span').each(function () {
                        tag_arr.push($(this).attr('data-id'));
                    });
                    inval = tag_arr.length > 0 ? tag_arr.join(',') : '';
                    break;
                case 'textarea':
                    var textarea_id = $up.find('.info-content-edit').find('textarea').eq(0).attr('id');
                    inval = $('#' + textarea_id).val();
                    break;
            }

            if(inval !== old_val || can_update){
                // 值没有变化不提交到后台
                var widget_param = {
                    dom : field_class_uuid,
                    editor: 'common',
                    original_field: original_field
                };

                $.ajax({
                    type: 'POST',
                    url: StrackPHP['updateWidget'],
                    dataType: 'json',
                    contentType: "application/json",
                    data: JSON.stringify({
                        editor: editor,
                        table: table,
                        module: module,
                        project_id: project_id,
                        field: field,
                        original_field: original_field,
                        field_type: field_type,
                        primary_value: primary,
                        data_source: data_source,
                        widget_id: widget_id,
                        variable_id: variable_id,
                        module_id: module_id,
                        module_code: module_code,
                        old_val: old_val,
                        val: inval,
                        widget_param: widget_param
                    }),
                    success: function (data) {
                        if (parseInt(data['status']) === 200) {
                            Strack.top_message({bg: 'g', msg: data['message']});
                            if(!Strack.Websocket.List.hasOwnProperty("update")){
                                data.data.status = 200;
                                Strack.update.widget(data.data, widget_param);
                            }
                        } else {
                            Strack.top_message({bg: 'r', msg: data['message']});
                        }
                    }
                });
            }
        }
    },
    // 监听键盘事件
    listen_keyboard_event: function(callback)
    {
        var data = {};
        $(document).on("keydown", function (e) {
            switch (e.keyCode){
                case 13:
                    // 回车键
                    data["code"] = "enter";
                    break;
                case 32:
                    // 空格键
                    data["code"] = "space";
                    break;
                case 37:
                    // 左方向键
                    data["code"] = "left";
                    break;
                case 39:
                    // 右方向键
                    data["code"] = "right";
                    break;
                case 70:
                    // f 键
                    data["code"] = "f_key";
                    break;
                case 73:
                    // i 键
                    data["code"] = "i_key";
                    break;
                case 86:
                    // v 键
                    data["code"] = "v_key";
                    break;
                default:
                    data["code"] = "";
                    break;
            }
            if(callback){
                callback(e, data);
            }
        });
    },
    //加载页面主fields
    load_info_panel: function (param, callback) {
        $.ajax({
            type: 'POST',
            url: param.url,
            data: param.data,
            beforeSend: function () {
                $(param.id).prepend(Strack.loading_dom(param.loading_type), param["mask"]);
            },
            success: function (data) {
                var item_id,module_id;
                switch (param.data.category){
                    case "detail_onset_field":
                        item_id = param["data"]["onset_id"];
                        module_id = param["data"]["onset_module_id"];
                        break;
                    default:
                        item_id = param["data"]["item_id"];
                        module_id = param["data"]["module_id"];
                        break;
                }
                var hdom = Strack.generate_widget(data["config"], data["data"], item_id, param["data"]["project_id"], param["pos"], module_id );
                $(param.id).empty().append(hdom);
                Strack.init_other_thumb_media("common");
                $('#st-load_'+param["mask"]).remove();
                if(callback){
                    callback(data);
                }
            }
        });
    },
    get_item_fields: function (param, callback) {
        $.ajax({
            type: 'POST',
            url: StrackPHP['getFields'],
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify(param),
            success: function (data) {
                callback(data);
            }
        });
    },
    // 获取实体或者任务Onset关联关系数据
    get_item_onset_data: function(param, callback)
    {
        $.ajax({
            type: 'POST',
            url: StrackPHP['getItemOnsetLinkData'],
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify(param),
            success: function (data) {
                callback(data);
            }
        });
    },
    //新增弹窗面板
    item_operate_dialog: function (title, param, callback) {
        var bnt_name = '';
        switch (param["mode"]) {
            case "create":
                bnt_name = StrackLang['Submit'];
                break;
            case "modify":
                bnt_name = StrackLang['Update'];
                break;
        }
        var from_module_id = param.hasOwnProperty("from_module_id")? param.from_module_id : 0;
        var from_item_id = param.hasOwnProperty("from_item_id")? param.from_item_id : 0;
        Strack.open_dialog('dialog', {
            title: title,
            width: 620,
            height: 380,
            content: Strack.dialog_dom({
                type: 'item_operation',
                hidden: [
                    {case: 101, id: 'Nmodule_id', type: 'hidden', name: 'module_id', valid: 1, value: param["module_id"]},
                    {case: 101, id: 'Nfrom_module_id', type: 'hidden', name: 'from_module_id', valid: 1, value: from_module_id},
                    {case: 101, id: 'Nfrom_item_id', type: 'hidden', name: 'from_item_id', valid: 1, value: from_item_id},
                    {case: 101, id: 'Npage', type: 'hidden', name: 'page', valid: 1, value: param["page"]},
                    {case: 101, id: 'Nproject_id', type: 'hidden', name: 'project_id', valid: 1, value: param["project_id"]},
                    {case: 101, id: 'Nmode', type: 'hidden', name: 'mode', valid: 1, value: param["mode"]},
                    {case: 101, id: 'Ntype', type: 'hidden', name: 'type', valid: 1, value: param["type"]},
                    {case: 101, id: 'Nprimary_id', type: 'hidden', name: 'primary_id', valid: 1, value: param["primary_id"]}
                ],
                items: [
                    {case: 2, id: 'Nup_fields', type: 'text', lang: StrackLang['Fields'], name: 'fields', valid: 1, value: ""}
                ],
                footer: [
                    {obj: 'item_operate_update', type: 5, title: bnt_name},
                    {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']},
                    {obj: 'save_dialog_setting', type: 8, title: StrackLang['Save_Setting']}
                ]
            }),
            inits: function () {
                var that = this;
                Strack.get_item_fields(param, function (data) {
                    var field_list = [];
                    for (var key in data['field_list']) {
                        for (var item in data['field_list'][key]) {
                            if(item !== "type") {
                                data['field_list'][key][item]["fields"].forEach(function (val) {
                                    val["field_group_name"] = data['field_list'][key][item]["title"];
                                    val["project_id"] = param['project_id'];
                                    val["module_id"] = param["module_id"];
                                    val["frozen_module"] = val["frozen_module"];
                                    val['flg_module'] = val['flg_module'];
                                    val["fields"] = val["module"] + '-' + val["id"];
                                    field_list.push(val);
                                });
                            }
                        }
                    }

                    $('#Nup_fields').combobox({
                        data: field_list,
                        width: 350,
                        valueField: 'fields',
                        textField: 'lang',
                        groupField: 'field_group_name',
                        multiple: true,
                        value: "",
                        onSelect: function (record) {
                            if ($("#dgup_i_" + record["fields"]).length === 0 && Strack.check_upload_editor_unique(that, record)) {
                                var upitem = Strack.field_item_dom(record, param, 1);
                                $("#st_dialog_item").append(upitem["item_dom"]);
                                Strack.field_item_init(upitem['dom_id'], param["primary_id"], record);
                            }else {
                                $(this).combobox("unselect", record["fields"]);
                            }
                        },
                        onUnselect: function (record) {
                            Strack.destroy_field_item(record["fields"]);
                        },
                        onLoadSuccess: function () {
                            var $this = $(this);
                            data["user_setting"].forEach(function (val) {
                                $this.combobox('select', val);
                            });
                        }
                    });
                });
            },
            close: function () {
                callback();
            }
        });
    },
    // 判断上传组件在单个编辑框的唯一性
    check_upload_editor_unique: function(i, param)
    {
        if(param.editor === "upload" && $(i).find(".single-queue-item").length > 0){
            layer.msg(StrackLang['Only_One_Media_Upload'], {icon: 2, time: 1200, anim: 6});
            return false;
        }
        return true;
    },
    // 销毁当前控件
    destroy_field_item : function(field)
    {
        var $field_item = $("#dgup_i_" + field);
        var widget_id = $field_item.attr("data-widgetid");
        var editor = $field_item.attr("data-editor");
        var $input = $("#"+widget_id);

        // 销毁上传控件
        switch (editor){
            case "upload":
                try {
                    $input.uploadifive("destroy");
                }
                catch(err) {}
                break;
            case "combobox":
                $input.combobox("destroy");
                break;
            case "datebox":
                $input.datebox("destroy");
                break;
            case "datetimebox":
                $input.datetimebox("destroy");
                break;
        }

        $field_item.remove();
    },
    //更新项
    field_item_dom: function (data, param, layer) {
        var item_dom = '';
        var Ewidget_id = 'dgup_' + data["fields"] + '' + Math.floor(Math.random() * 1000 + 1);
        var show_name = '';
        if (data.field_group_name) {
            show_name = data["lang"] + ' (' + data["field_group_name"] + ')';
        } else {
            show_name = data["lang"];
        }

        item_dom += '<li id="dgup_i_' + data["fields"] + '" class="dg-report-item" data-field="' + data["fields"] + '" data-widgetid="'+Ewidget_id+'" data-editor="'+data["editor"]+'">' +
            '<a href="javascript:;" onclick="Strack.field_item_delete(this)" class="dg-report-de aign-left"  data-field="' + data["fields"] + '" data-mode="' + param['mode'] + '" data-type="' + param['type'] + '">' +
            '<i class="icon-uniE6DB"></i>' +
            '</a>' +
            '<div class="dg-report-step aign-left">' + show_name + '</div>' +
            '<div class="dg-report-user st-dialog-input aign-left">' +
            Strack.field_editor_dom(Ewidget_id, data) +
            '</div>' ;

        if(data["editor"] === "combobox" && data["create_in_time"]==="allow" && layer === 1){
            // 只允许弹出一层
            item_dom +='<a href="javascript:;" class="dg-report-add" onclick="Strack.add_combobox_new_val(this)" data-page="'+param["page"]+'" data-schemapage="'+param["schema_page"]+'" data-moduleid="'+data["module_id"]+'" data-projectid="'+param["project_id"]+'" data-widgetid="'+Ewidget_id+'" data-flgmodule="'+data["flg_module"]+'" data-modulecode="'+data["module_code"]+'">' +
                '<i class="icon-uni3432"></i>' +
                '</a>' ;
        }

        item_dom +='</li>';
        return {item_dom: item_dom, dom_id: Ewidget_id};
    },
    // 在当前页面直接添加更新combobox数据
    add_combobox_new_val: function(i)
    {
        var $this = $(i);

        var module_id = $this.attr("data-moduleid");
        var module_code = $this.attr("data-flgmodule");
        var widget_id = $this.attr("data-widgetid");
        var project_id = $this.attr("data-projectid");
        var page = $this.attr("data-page");
        var schema_page = $this.attr("data-schemapage");

        // 判断哪些模块是需要更新项目目标配置
        var need_up_temp_list = ["status", "step"];
        var update_template = "no";
        if($.inArray(module_code, need_up_temp_list) !== -1){
            update_template = "yes";
        }

        // 判断哪些字段没有schema
        var no_schema_list = ["status", "step"];
        var has_schema = 'yes';
        if($.inArray(module_code, no_schema_list) !== -1){
            has_schema = "yes";
        }

        var title = 'Add_' + Strack.string_ucwords(module_code);

        var dialog_random_id = "dialog_combobox_add_"+Math.floor(Math.random() * 10000 + 1);

        Strack.open_dialog(dialog_random_id, {
            title: StrackLang[title],
            width: 620,
            height: 380,
            content: Strack.dialog_dom({
                type: 'item_operation',
                hidden: [
                    {case: 101, id: 'Ncomb_project_id', type: 'hidden', name: 'project_id', valid: 1, value: project_id},
                    {case: 101, id: 'Ncomb_module_id', type: 'hidden', name: 'module_id', valid: 1, value: module_id},
                    {case: 101, id: 'Ncomb_module_code', type: 'hidden', name: 'module_code', valid: 1, value: module_code},
                    {case: 101, id: 'Ncomb_update_template', type: 'hidden', name: 'update_template', valid: 1, value: update_template},
                    {case: 101, id: 'Ncomb_mode', type: 'hidden', name: 'mode', valid: 1, value: "create"},
                    {case: 101, id: 'Ncomb_type', type: 'hidden', name: 'type', valid: 1, value: "combobox_add_panel"},
                    {case: 101, id: 'Ncomb_page', type: 'hidden', name: 'page', valid: 1, value: page}
                ],
                items: [
                    {case: 2, id: 'Ncomb_up_fields', type: 'text', lang: StrackLang['Fields'], name: 'fields', valid: 1, value: ""}
                ],
                footer: [
                    {obj: 'item_combobox_new_update', type: 5, title: StrackLang['Submit']},
                    {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                ]
            }),
            inits: function () {
                var param = {
                    mode: "create",
                    field_list_type: ['edit'],
                    from_module_id: module_id,
                    module_code: module_code,
                    project_id: project_id,
                    has_schema: has_schema,
                    page: page,
                    from_schema_page: schema_page,
                    type:"combobox_add_panel"
                };
                Strack.get_item_fields(param, function (data) {

                    var field_list = [];
                    for (var key in data['field_list']) {
                        for (var item in data['field_list'][key]) {
                            if(item !== "type"){
                                data['field_list'][key][item]["fields"].forEach(function (val) {
                                    val["field_group_name"] = data['field_list'][key][item]["title"];
                                    val["project_id"] = param['project_id'];
                                    val["module_id"] = param["module_id"];
                                    val["frozen_module"] = val["frozen_module"];
                                    val['flg_module'] = val['flg_module'];
                                    val["fields"] = val["module"] + '-' + val["id"];
                                    field_list.push(val);
                                });
                            }
                        }
                    }

                    $('#Ncomb_up_fields').combobox({
                        data: field_list,
                        width: 350,
                        valueField: 'fields',
                        textField: 'lang',
                        groupField: 'field_group_name',
                        multiple: true,
                        value: "",
                        onSelect: function (record) {
                            if ($("#"+dialog_random_id+" #dgup_i_" + record["fields"]).length === 0) {
                                var upitem = Strack.field_item_dom(record, param, 2);
                                $("#"+dialog_random_id+" #st_dialog_item").append(upitem["item_dom"]);
                                Strack.field_item_init(upitem['dom_id'], param["project_id"], record);
                            }
                        },
                        onUnselect: function (record) {
                            Strack.destroy_field_item(record["fields"]);
                        },
                        onLoadSuccess: function () {
                            var $this = $(this);
                            data["user_setting"].forEach(function (val) {
                                $this.combobox('select', val);
                            });
                        }
                    });
                });
            },
            close: function () {
                $("#"+widget_id).combobox("reload");
            }
        });
    },
    //初始化控件
    field_item_init: function (Ewidget_id, primary, field_data) {
        field_data["primary"] = primary;
        Strack.widget_init_dom(Ewidget_id, 260, 25, field_data);
    },
    //删除更新项
    field_item_delete: function (i) {
        var field = $(i).data("field");
        var type = $(i).data("type");
        switch (type) {
            case "add_entity_task_panel":
                if($(i).closest("#st_dialog_form").length > 0){
                    $('#Nup_fields').combobox("unselect", field);
                }else {
                    $('#m_review_task_fields').combobox("unselect", field);
                }
                break;
            default:
                $('#Nup_fields').combobox("unselect", field);
                break;
        }
    },
    //编辑项输入框类型
    field_editor_dom: function (Ewidget_id, data) {
        var dom = '', show_name = '';
        if (data.field_group_name) {
            show_name = data["lang"] + ' (' + data["field_group_name"] + ')';
        } else {
            show_name = data["lang"];
        }
        var variable_id = data['field_type'] === "built_in" ? 0 : data['variable_id'];

        var table_name = data["module_type"] === "entity" ? "entity" : data["module_code"];

        switch (data["editor"]) {
            case "upload":
                // 上传缩略图
                Strack.G.batchUploadMediaType = data["field_type"] === "custom" ? 'horizontal' : 'direct';
                dom = '<div id="widget_queue" class="single-queue-item"></div>' +
                    '<div class="widget-upload">' +
                    '<input id="' + Ewidget_id + '" class="media-upload-bnt field_edit_item" type="file" multiple="true" data-field="' + data["fields"] + '" data-variableid="' + variable_id + '" data-fieldtype="' + data["field_type"] + '" data-lang="' + show_name + '" data-editor="' + data["editor"] + '" data-multiple="' + data["multiple"] + '" data-table="' + table_name + '">' +
                    '</div>';
                break;
            case "textarea":
                dom = '<textarea id="' + Ewidget_id + '" class="field_edit_item widget-edit" data-field="' + data["fields"] + '" data-variableid="' + variable_id + '" data-fieldtype="' + data["field_type"] + '" data-lang="' + show_name + '" data-editor="' + data["editor"] + '" data-multiple="' + data["multiple"] + '" data-table="' + table_name + '"></textarea>';
                break;
            default:
                var type = data["id"] === "password" ? "password" : "text";
                dom = '<input id="' + Ewidget_id + '" type="'+type+'" class="field_edit_item" data-field="' + data["fields"] + '" data-variableid="' + variable_id + '" data-fieldtype="' + data["field_type"] + '" data-lang="' + show_name + '" data-editor="' + data["editor"] + '" data-multiple="' + data["multiple"] + '" data-table="' + table_name + '">';
                break;
        }
        return dom;
    },
    // 判断字段数据填写
    check_item_operate_fields: function (comb_id, id) {
        var fields = Strack.get_combos_val(comb_id, 'combobox', 'getValues');
        var up_data = {},
            allow_up = true;
        if (!fields) {
            allow_up = false;
            layer.msg(StrackLang['Please_Select_Field'], {icon: 2, time: 1200, anim: 6});
        } else {
            $(".form-tip").remove();
            $(id).find(".field_edit_item").each(function () {
                var lang = $(this).attr("data-lang"),
                    editor = $(this).attr("data-editor"),
                    field = $(this).attr("data-field"),
                    field_type = $(this).attr("data-fieldtype"),
                    multiple = $(this).attr("data-multiple"),
                    variable_id = $(this).attr("data-variableid"),
                    table = $(this).attr("data-table");

                var temp_val = '';
                var temp_ids = [];

                switch (editor) {
                    case "combobox":
                        if (multiple === 'yes') {
                            temp_ids = Strack.get_combos_val(this, 'combobox', 'getValues');
                            if (temp_ids) {
                                temp_val = temp_ids.join(",");
                            } else {
                                temp_val = '';
                            }
                        } else {
                            temp_val = Strack.get_combos_val(this, 'combobox', 'getValue');
                        }
                        if(field.search("id") !== -1 && !temp_val){
                            temp_val = 0;
                        }
                        break;
                    case "tagbox":
                    case "horizontal_relationship":
                    case "relation":
                        temp_ids = Strack.get_combos_val(this, 'combobox', 'getValues');
                        if (temp_ids) {
                            temp_val = temp_ids.join(",");
                        } else {
                            temp_val = '';
                        }
                        break;
                    case "datebox":
                        temp_val = $(this).datebox("getValue");
                        break;
                    case "datetimebox":
                        temp_val = $(this).datetimebox("getValue");
                        break;
                    case "checkbox":
                        if ($(this).is(":checked")) {
                            temp_val = 'yes';
                        } else {
                            temp_val = 'no';
                        }
                        break;
                    case "upload":
                        if($("#widget_queue .uploadifive-queue-item").length > 0){
                            temp_val = "yes";
                        }
                        break;
                    default:
                        temp_val = $(this).val();
                        break;
                }
                if (!(temp_val || (editor === "combobox" && temp_val === 0))) {
                    $(this).closest("li").append(Strack.dialog_error_icon("e"));
                    layer.msg(lang + ' : ' + StrackLang['Required_Field'], {icon: 2, time: 1200, anim: 6});
                    allow_up = false;
                    return false;
                } else {
                    $(this).closest("li").append(Strack.dialog_error_icon("t"));
                    if (up_data.hasOwnProperty(table)) {
                        up_data[table].push({
                            field: field,
                            field_type: field_type,
                            value: temp_val,
                            variable_id: variable_id
                        });
                    } else {
                        up_data[table] = [{
                            field: field,
                            field_type: field_type,
                            value: temp_val,
                            variable_id: variable_id
                        }];
                    }
                }
            });
        }
        return {allow_up: allow_up, up_data: up_data};
    },
    // 添加实体任务
    entity_add_task: function (i) {
        var $grid_toolbar = $(i).closest(".datagrid-toolbar");

        var entity_title = $(i).attr("data-lang"),
            module_code = $(i).attr("data-modulecode"),
            task_module_id = $(i).attr("data-taskmoduleid"),
            schema_page = $(i).attr("data-schemapage");

        var module_name = $('#page_hidden_param input[name=module_name]').val();

        var grid = $grid_toolbar.attr("data-grid"),
            page = $grid_toolbar.attr("data-page"),
            main_dom = $grid_toolbar.attr("data-maindom"),
            bar_dom = $grid_toolbar.attr("data-bardom"),
            module_id = $grid_toolbar.attr("data-moduleid"),
            project_id = $grid_toolbar.attr("data-projectid");

        var rows = $("#" + grid).datagrid("getSelections");
        var ids = [];

        rows.forEach(function (val) {
            ids.push(parseInt(val["id"]));
        });

        if (ids.length > 0) {
            Strack.open_dialog('dialog', {
                title: StrackLang["Add_Task"],
                width: 920,
                height: 500,
                content: Strack.dialog_dom({
                    type: 'add_entity_task',
                    entity_title: entity_title,
                    hidden: [
                        {case: 101, id: 'Nmodule_id', type: 'hidden', name: 'module_id', valid: 1, value: module_id},
                        {case: 101, id: 'Ntask_module_id', type: 'hidden', name: 'task_module_id', valid: 1, value: task_module_id},
                        {case: 101, id: 'Nmodule_name', type: 'hidden', name: 'module_name', valid: 1, value: module_name},
                        {case: 101, id: 'Nproject_id', type: 'hidden', name: 'project_id', valid: 1, value: project_id},
                        {case: 101, id: 'Ngrid', type: 'hidden', name: 'grid', valid: 1, value: grid},
                        {case: 101, id: 'Npage', type: 'hidden', name: 'page', valid: 1, value: page},
                        {case: 101, id: 'Ntype', type: 'hidden', name: 'type', valid: 1, value: 'add_entity_task'},
                        {case: 101, id: 'Nmain_dom', type: 'hidden', name: 'main_dom', valid: 1, value: main_dom},
                        {case: 101, id: 'Nbar_dom', type: 'hidden', name: 'bar_dom', valid: 1, value: bar_dom}
                    ],
                    items: [],
                    footer: [
                        {obj: 'entity_add_task_submit', type: 5, title: StrackLang['Submit']},
                        {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']},
                        {obj: 'save_dialog_setting', type: 8, title: StrackLang['Save_Setting']}
                    ]
                }),
                inits: function () {

                    Strack.combobox_widget('#Mentity', {
                        url: StrackPHP["getWidgetData"],
                        valueField: 'id',
                        textField: 'name',
                        multiple: true,
                        queryParams: {
                            module: 'entity',
                            field_type: 'built_in',
                            fields: 'entity_id',
                            flg_module: 'entity',
                            project_id: project_id,
                            entity_module_id: module_id,
                            data_source: "entity"
                        },
                        onLoadSuccess: function () {
                            $(this).combobox('setValues', ids);
                        }
                    });

                    var step_ids = {
                        step_id : "Mstep",
                        list_id : "stdg_etask_list",
                        combox_id : "Nup_fields",
                        edit_id : "st_dialog_item"
                    };

                    Strack.combobox_widget('#Mstep', {
                        url: StrackPHP["getEntityStepList"],
                        valueField: 'id',
                        textField: 'name',
                        multiple: true,
                        queryParams: {
                            project_id: project_id,
                            module_code: module_code
                        },
                        onSelect: function (record) {
                            // 选中 step
                            Strack.add_entity_step_task_group(step_ids, record, 'new');
                        },
                        onUnselect: function (record) {
                            // 取消选中 step
                            Strack.remove_entity_step_task_group(step_ids, record);
                        }
                    });

                    var param = {
                        mode: "create",
                        field_list_type: ['edit'],
                        module_id: task_module_id,
                        project_id: project_id,
                        page: page,
                        schema_page: schema_page,
                        type: "add_entity_task_panel",
                        not_fields : ["entity_id", "step_id", "thumb"]
                    };

                    Strack.get_item_fields(param, function (data) {

                        var field_list = [];
                        for (var key in data['field_list']) {
                            for (var item in data['field_list'][key]) {
                                data['field_list'][key][item]["fields"].forEach(function (val) {
                                    val["field_group_name"] = data['field_list'][key][item]["title"];
                                    val["project_id"] = param['project_id'];
                                    val["module_id"] = param["module_id"];
                                    val["frozen_module"] = val["frozen_module"];
                                    val['flg_module'] = val['flg_module'];
                                    val["fields"] = val["module"] + '-' + val["id"];
                                    field_list.push(val);
                                });
                            }
                        }

                        $('#Nup_fields').combobox({
                            data: field_list,
                            width: 350,
                            valueField: 'fields',
                            textField: 'lang',
                            groupField: 'field_group_name',
                            multiple: true,
                            value: "",
                            onSelect: function (record) {
                                if ($("#dgup_i_" + record["fields"]).length === 0) {
                                    var upitem = Strack.field_item_dom(record, param, 1);
                                    $("#st_dialog_item").append(upitem["item_dom"]);
                                    Strack.field_item_init(upitem['dom_id'], param["project_id"], record);
                                    if (record.id === "name" || record.id === "code") {
                                        // 获取当前激活项名称
                                        var md5_name = $("#stdg_etask_list .etask-l-active").find(".etask-l-item-name").html();
                                        $("#" + upitem.dom_id).val(md5_name);
                                    }
                                }
                            },
                            onUnselect: function (record) {
                                Strack.destroy_field_item(record["fields"]);
                            },
                            onLoadSuccess: function () {
                                var $this = $(this);
                                data["user_setting"].forEach(function (val) {
                                    $this.combobox('select', val);
                                });
                            },
                            onChange: function (newValue, oldValue) {
                                // 删除当前选中任务ok状态
                                $(".stdg-etask-l-item").removeClass("form_ok");
                            }
                        });
                    });
                },
                close: function () {
                    Strack.G.entityStepTaskAddData = {status: false, data: {}};
                }
            });
        } else {
            layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
        }
    },
    // 提交添加entity任务
    entity_add_task_submit: function () {
        if (!$.isEmptyObject(Strack.G.entityStepTaskAddData.data)) {
            // 获取当前激活的item
            var $etask_list = $("#stdg_etask_list");
            var active_item = $etask_list.find(".etask-l-active");

            if (active_item.length > 0) {
                var ac_id = active_item.attr("id"),
                    ac_step_code = active_item.attr("data-stepcode");
                var check_data = Strack.check_item_operate_fields('#Nup_fields', '#st_dialog_form');
                Strack.G.entityStepTaskAddData.data[ac_step_code][ac_id] = check_data.up_data;
                if (check_data.allow_up) {
                    active_item.addClass("form_ok");
                }
            }

            // 遍历item判断 任务是否可以提交
            Strack.G.entityStepTaskAddData.status = true;
            $(".stdg-etask-l-item").each(function () {
                if (!$(this).hasClass("form_ok")) {
                    Strack.G.entityStepTaskAddData.status = false;
                }
            });
            if (Strack.G.entityStepTaskAddData.status) {
                // 提交后台
                var step_task_data = {
                    entity_param: {},
                    task_rows: Strack.G.entityStepTaskAddData.data
                };

                //获取隐藏字段
                $("#st_dialog_form_hide").find("input").each(function () {
                    step_task_data.entity_param[$(this).attr("data-name")] = $(this).val();
                });

                // 获取Entity信息
                step_task_data["entity_ids"] = $('#Mentity').combobox('getRowValues', 'id');
                step_task_data["step_ids"] = $('#Mstep').combobox('getRowValues', 'id');

                if (step_task_data["entity_ids"].length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: StrackPHP['batchSaveEntityBase'],
                        data: JSON.stringify(step_task_data),
                        contentType: "application/json",
                        dataType: "json",
                        beforeSend: function () {
                            $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                        },
                        success: function (data) {
                            $.messager.progress('close');
                            if (parseInt(data['status']) === 200) {
                                Strack.top_message({bg: 'g', msg: data['message']});
                                Strack.dialog_cancel();
                            } else {
                                layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                            }
                        }
                    });
                } else {
                    var module_name = $("#Nmodule_name").val();
                    layer.msg(module_name + ' : ' + StrackLang['Required_Field'], {icon: 2, time: 1200, anim: 6});
                }

            } else {
                layer.msg(StrackLang['Please_Fill_Step_Task_Data'], {icon: 2, time: 1200, anim: 6});
            }
        } else {
            layer.msg(StrackLang['Please_Select_Step'], {icon: 2, time: 1200, anim: 6});
        }
    },
    // 通过excel导入数据
    import_excel_data: function (i) {

        var $ex_slider = $("#import_excel_slider");

        if ($ex_slider.hasClass("load-active")) {
            // 重置导入面板数据
            Strack.reset_import_excel_step_data();
        } else {
            $ex_slider.addClass("load-active");
        }

        var $toolbar = $(i).closest(".datagrid-toolbar");

        var batch_number = Math.floor(Math.random() * 100000 + 1);

        var item_id = Strack.G.pageHiddenParam.hasOwnProperty("item_id") ? Strack.G.pageHiddenParam["item_id"] : 0;

        var param = {
            page: $toolbar.attr("data-page"),
            schema_page: $toolbar.attr("data-schemapage"),
            module_id: $toolbar.attr("data-moduleid"),
            grid: $toolbar.attr("data-grid"),
            project_id: $toolbar.attr("data-projectid"),
            main_dom: $toolbar.attr("data-maindom"),
            bar_dom: $toolbar.attr("data-bardom"),
            batch_number: batch_number,
            from_module_data: {
                item_id: item_id,
                module_id: Strack.G.pageHiddenParam["module_id"],
                module_code: Strack.G.pageHiddenParam["module_code"],
            }
        };

        // 验证处理step数据
        Strack.G.importExcelStep = $("#import_excel_step").step({
            mustStep: [],
            stepCallBack: function (step_id) {

                var check_list = ['method', 'import', 'mapping', 'result'];

                var error_list = {
                    'method': StrackLang["Please_Select_Import_Mode"],
                    'import_paste': StrackLang["Please_Paste_Excel_Data"],
                    'import_file': StrackLang["Please_Select_Excel_File"],
                    'mapping': StrackLang["Must_Field_Completely_Mapping"],
                    'result': ""
                };

                var check_status = true;
                var current_key = 0;
                var current_pos = '';

                check_list.forEach(function (val, index) {
                    if (index + 1 < step_id && check_status) {
                        current_pos = val;
                        switch (val) {
                            case 'method':
                                // 检查是否选择了导入数据方式
                                var $method_active = $(".import-method-active");
                                if ($method_active.length > 0) {
                                    Strack.G.importExcelData["method"] = $method_active.attr("data-method");
                                } else {
                                    check_status = false;
                                }
                                break;
                            case 'import':
                                // 判断使用导入方式
                                if (Strack.G.importExcelData["method"]) {
                                    switch (Strack.G.importExcelData["method"]) {
                                        case "paste":
                                            var paste_content = $("#import_method_paste").val();
                                            if (paste_content.length === 0) {
                                                check_status = false;
                                            }
                                            break;
                                        case "file":
                                            if ($('.uploadifive-queue-item').length === 0) {
                                                check_status = false;
                                            }
                                            break;
                                    }
                                } else {
                                    check_status = false;
                                }
                                break;
                            case 'mapping':
                                // 判断必须字段是否完全映射
                                $("#import_ex_must").find('.menu-icon').each(function () {
                                    if ($(this).hasClass('icon-unchecked')) {
                                        check_status = false;
                                        return false;
                                    }
                                });
                                break;
                            case 'result':
                                // 显示导入Excel结构
                                break;
                        }
                        current_key = index + 1;
                        if (!check_status) {
                            return false;
                        }
                    } else {
                        return false;
                    }
                });

                if (check_status) {
                    switch (parseInt(step_id)) {
                        case 1:
                            Strack.G.importExcelStep.goStep(step_id);
                            Strack.reset_import_excel_step_bnt(step_id);
                            break;
                        case 2:
                            // 初始化数据导入面板
                            Strack.G.importExcelStep.goStep(step_id);
                            $(".import-method-panel").hide();
                            Strack.init_excel_format_widget(param);
                            Strack.reset_import_excel_step_bnt(step_id);
                            break;
                        case 3:
                            // 格式化Excel数据
                            switch (Strack.G.importExcelData["method"]) {
                                case "paste":
                                    Strack.format_excel_paste_data(param);
                                    break;
                                case "file":
                                    Strack.format_excel_file_data();
                                    break;
                            }
                            break;
                        case 4:
                            // 提交
                            Strack.import_excel_step_submit(param);
                            break;
                        default:
                            Strack.format_excel_file_data(0);
                            break;
                    }
                } else {
                    var msg = '';
                    switch (current_pos) {
                        case "import":
                            msg = error_list[current_pos + '_' + Strack.G.importExcelData["method"]];
                            break;
                        default:
                            msg = error_list[current_pos];
                            break;
                    }
                    layer.msg(msg, {icon: 2, time: 1200, anim: 6});
                }
            }
        });

        $ex_slider.sidebar("toggle");
    },
    // 关闭excel 导入面板
    close_import_excel_panel: function () {
        $("#import_excel_slider").sidebar("toggle");
    },
    // 重置excel step数据
    reset_import_excel_step_data: function () {
        // 清除excel step全局数据
        Strack.G.importExcelData = {};

        // 隐藏所有页面
        $("#import_ex_list .step-list").hide();
        $(".excel-in-submit").hide();

        // 还原step按钮
        $("#import_excel_bnt_upload").hide();
        $("#import_excel_bnt_prev").hide();
        $("#import_excel_bnt_next").show();
        $("#import_excel_bnt_submit").hide();

        // 清除第一页导入方法选中状态
        $(".import-excel-card").removeClass("import-method-active");

        // 隐藏格式化excel method面板
        $(".import-method-panel").hide();

        // 清除paste数据
        var $paste_switch = $("#method_paste_header");
        if ($paste_switch.hasClass("switchbutton-f")) {
            $paste_switch.switchbutton("clear");
            $("#import_method_paste").empty();
        }

        // 清除upload数据和队列文件
        var $upload_switch = $("#method_file_header");
        if ($upload_switch.hasClass("switchbutton-f")) {
            $upload_switch.switchbutton("clear");
            $('#excel_upload_widget').uploadifive("clearQueue");
        }
    },
    // 调整 step 按钮显示隐藏
    reset_import_excel_step_bnt: function (step) {
        var $upload = $("#import_excel_bnt_upload"),
            $prev = $("#import_excel_bnt_prev"),
            $next = $("#import_excel_bnt_next"),
            $submit = $("#import_excel_bnt_submit");
        switch (step) {
            case 1:
                $upload.hide();
                $prev.hide();
                $next.show();
                $submit.hide();
                break;
            case 2:
                if (Strack.G.importExcelData["method"] === 'file') {
                    $upload.show();
                }
                $prev.show();
                $next.show();
                $submit.hide();
                break;
            case 4:
                $upload.hide();
                $prev.show();
                $next.hide();
                $submit.show();
                break;
            default:
                $upload.hide();
                $prev.show();
                $next.show();
                $submit.hide();
                break;
        }
    },
    // 导入excel step下一步
    import_excel_step_prev: function () {
        Strack.G.importExcelStep.preStep();
    },
    // 导入excel step上一步
    import_excel_step_next: function () {
        Strack.G.importExcelStep.nextStep();
    },
    // 初始化上传控件
    init_excel_format_widget: function (param) {
        var $excel_format_paste = $("#excel_format_paste"),
            $excel_format_file = $("#excel_format_file");

        $(".import-method-" + Strack.G.importExcelData["method"]).show();

        switch (Strack.G.importExcelData["method"]) {
            case "paste":
                if (!$excel_format_paste.hasClass("load_active")) {
                    $excel_format_paste.addClass("load_active");
                    Strack.init_open_switch({
                        dom: '#method_paste_header',
                        value: 0,
                        onText: StrackLang['Switch_ON'],
                        offText: StrackLang['Switch_OFF'],
                        width: 100
                    });
                }
                break;
            case "file":
                if (!$excel_format_file.hasClass("load_active")) {

                    $excel_format_file.addClass("load_active");

                    Strack.init_open_switch({
                        dom: '#method_file_header',
                        value: 0,
                        onText: StrackLang['Switch_ON'],
                        offText: StrackLang['Switch_OFF'],
                        width: 100
                    });
                    Strack.init_excel_file_upload(param);
                }
                break;
        }

    },
    // 提交 excel 粘贴数据到后台进行表格化处理
    format_excel_paste_data: function (param) {
        var csv = new CSV($("#import_method_paste").val(), {cellDelimiter: "\t"});
        var has_header = Strack.get_switch_val('#method_paste_header');
        var parsed = csv.parse();
        $.ajax({
            type: 'POST',
            url: StrackPHP['formatExcelPasteData'],
            data: JSON.stringify({
                has_header: has_header,
                parsed: parsed,
                module_id: param["module_id"],
                project_id: param["project_id"],
                page: param["page"],
                schema_page: param["schema_page"]
            }),
            contentType: "application/json",
            beforeSend: function () {
                $('#import_excel_step').append(Strack.loading_dom('white', '', 'excel_data'));
            },
            success: function (data) {
                if (parseInt(data['status']) === 200) {
                    Strack.G.importExcelStep.goStep(3);
                    Strack.reset_import_excel_step_bnt(3);
                    Strack.init_format_datagrid(data["data"]);
                } else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
                $("#st-load_excel_data").remove();
            }
        });
    },
    // 上传excel文件格式化数据
    format_excel_file_data: function () {
        var has_header = Strack.get_switch_val('#method_file_header');
        $('#excel_upload_widget').uploadifive('settings', 'formData', 'has_header', has_header);
        if ($('.uploadifive-queue-item').hasClass("complete")) {
            Strack.G.importExcelStep.goStep(3);
            Strack.reset_import_excel_step_bnt(3);
        } else {
            $('#excel_upload_widget').uploadifive('upload');
        }
    },
    // 初始化 excel upload 控件
    init_excel_file_upload: function (param) {
        $('#excel_upload_widget').uploadifive({
            'auto': false,
            'removeCompleted': false,
            'formData': {
                'timestamp': Strack.current_time(),
                'batch_number': param["batch_number"],
                'module_id': param["module_id"],
                'project_id': param["project_id"],
                'page': param["page"],
                'schema_page': param["schema_page"],
                'has_header': 0
            },
            'multi': false,
            'queueSizeLimit': 1,
            'fileSizeLimit': '100MB',
            'fileType': 'text/csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'queueID': 'import_method_queue',
            'uploadScript': StrackPHP["formatExcelFileData"],
            'onUploadComplete': function (file, data) {
                var resData = JSON.parse(data);
                if (parseInt(resData['status']) === 200) {
                    Strack.G.importExcelStep.goStep(3);
                    Strack.reset_import_excel_step_bnt(3);
                    Strack.init_format_datagrid(resData["data"]);
                } else {
                    layer.msg(resData["message"], {icon: 7, time: 1200, anim: 6});
                }
            },
            'onQueueComplete': function (file, data) {

            }
        });
    },
    // 选择处理 excel step 方式
    select_import_excel_method: function (i) {
        $(".import-excel-card").removeClass("import-method-active");
        $(i).addClass("import-method-active");
    },
    // 初始化excel导入字段映射菜单
    init_format_menu: function (fields) {
        var columns_field_config = {};
        var check_icon = "iconCls:'icon-unchecked'";
        var $ex_fields_menu = $("#excel_fields_menu");

        if ($ex_fields_menu.hasClass("st-menu")) {
            // 先销毁删除老item
            $("#import_ex_must").find(".menu-item")
                .each(function () {
                    $ex_fields_menu.menu("removeItem", this);
                });

            $("#import_ex_other").find(".menu-item")
                .each(function () {
                    $ex_fields_menu.menu("removeItem", this);
                });

            // 新增item
            var field_item_id = '';
            fields.forEach(function (val) {
                field_item_id = "fexn_" + val["fields"];
                if (val["require"] === 'yes') {
                    // 必须字段
                    $ex_fields_menu.menu('appendItem', {
                        parent: $("#import_ex_must_wrap")[0],
                        id: field_item_id,
                        text: val["lang"],
                        iconCls: 'icon-unchecked'
                    });

                } else {
                    // 非必须字段
                    $ex_fields_menu.menu('appendItem', {
                        parent: $("#import_ex_other_wrap")[0],
                        id: field_item_id,
                        text: val["lang"],
                        iconCls: 'icon-unchecked'
                    });
                }

                // 附加属性
                $("#" + field_item_id).attr("data-bnt", "mapping_field")
                    .attr("data-fields", val["fields"])
                    .attr("data-mapping", "")
                    .attr("data-fieldtype", val["field_type"]);

            });
        } else {

            var require_dom = '',
                other_dom = '';

            fields.forEach(function (val) {
                if (val["require"] === 'yes') {
                    // 必须字段
                    require_dom += '<div id="fexn_' + val["fields"] + '"  data-options="' + check_icon + '" data-bnt="mapping_field" data-fields="' + val["fields"] + '" data-mapping="" data-fieldtype="' + val["field_type"] + '">' + val["lang"] + '</div>';
                } else {
                    // 非必须字段
                    other_dom += '<div id="fexn_' + val["fields"] + '"  data-options="' + check_icon + '" data-bnt="mapping_field" data-fields="' + val["fields"] + '" data-mapping="" data-fieldtype="' + val["field_type"] + '">' + val["lang"] + '</div>';
                }
            });

            $("#import_ex_must").empty().append(require_dom);
            $("#import_ex_other").empty().append(other_dom);

            $ex_fields_menu.menu({
                onClick: function (item) {
                    var current_field = $("#excel_fields_val").val(),
                        $cfield = $('#cell_ckt_' + current_field),
                        $cfield_parent = $cfield.parent(),
                        ckfield = $cfield.attr("data-ckfield"),
                        $ckfield = $("#fexn_" + ckfield);

                    var $target = $(item.target);
                    switch ($target.data("bnt")) {
                        case "cancel_mapping":
                            // 取消字段映射
                            $ckfield.data("mapping", "");
                            $ckfield.find(".menu-icon").removeClass("icon-checked").addClass("icon-unchecked");
                            $(this).menu("enableItem", $ckfield[0]);
                            //取消mapped
                            $cfield.attr("data-ckfield", "").html(StrackLang["Non_Mapping_Field"]);
                            $cfield_parent.removeClass("excel-tac").removeClass("mapping-active");
                            break;
                        case "mapping_field":
                            if (!$cfield_parent.hasClass("mapping-active")) {
                                $cfield_parent.addClass("mapping-active");
                                var field = $(item.target).data("fields"),
                                    show_name = $(item.target).find(".menu-text").html();

                                $(item.target).attr("data-mapping", current_field);

                                $cfield_parent.addClass("excel-tac");
                                $cfield.attr("data-ckfield", field).html(show_name);
                                $target.find(".menu-icon").removeClass("icon-unchecked").addClass("icon-checked");
                                $(this).menu("disableItem", item.target);
                            }
                            break;
                    }
                }
            });
        }

        return columns_field_config;
    },
    // 构建excel导入表格
    build_import_ex_columns: function (field, images_column) {
        var columns = [], url = '';
        // 第一列添加删除按钮
        columns.push({
            field: 'ex_del_bnt', col_type:'bnt', title: StrackLang["Delete"], align: 'center', width: 85, formatter: function(value,row,index){
                return '<a href="javascript:;" class="button" onclick="Strack.import_excel_grid_bnt(this)" data-rowid="'+row.id+'"><button class="ui basic red button">'+StrackLang["Delete"]+'</button></a>';
            }
        });
        field.forEach(function (col) {
            url = '';
            if($.inArray(col, images_column) >= 0){
                columns.push({
                    field: col, col_type:'field', title: col, align: 'center', width: 130, formatter: function(value,row,index){
                        url = StrackPHP['ROOT']+value;
                        return Strack.build_grid_thumb_dom(url);
                    }
                });
            }else {
                columns.push({
                    field: col, col_type:'field', title: col, align: 'center', width: 130, editor: {type: 'text'}
                });
            }
        });
        return [columns];
    },
    // 删除excel指定行数据
    import_excel_grid_bnt: function(i)
    {
        var row_id = $(i).attr("data-rowid");
        $('#import_excel_datagrid').datagrid('selectRecord',row_id);
        var row = $('#import_excel_datagrid').datagrid('getSelected');
        var index = $('#import_excel_datagrid').datagrid('getRowIndex',row);
        $('#import_excel_datagrid').datagrid('unselectRow',index);
        setTimeout(function(){
            $('#import_excel_datagrid').datagrid('deleteRow',index);
        },0);
    },
    // 初始化字段映射数据表格
    init_format_datagrid: function (format_data) {

        Strack.init_format_menu(format_data['fields']);

        Strack.G.InputExCkfields = {};

        // 生成columnsFieldConfig
        var columns_field_config = {};
        format_data["header"].forEach(function (val) {
            columns_field_config[val] = {
                field_type: "excel",
                editor: "text",
                variable_id: 0,
                primary: "",
                field_map: val,
                table: "Excel",
                module: "excel",
                module_type: "excel",
                field_value_map: val
            };
        });

        var $datagrid = $("#import_excel_datagrid");

        if(!$datagrid.hasClass("datagrid-f")){
            $datagrid.datagrid({
                data: format_data['body'],
                fitColumns: false,
                height: Strack.panel_height(".mapping-fields-wrap", 0),
                rowheight: 49,
                differhigh: true,
                singleSelect: true,
                HeaderField: true,
                HeaderHeight: 50,
                HeaderFieldData: {},
                idField: 'id',
                cellUpdateMode: 'manual',
                columnsFieldConfig: columns_field_config,
                adaptive: {
                    dom: ".mapping-fields-wrap",
                    min_width: 1004,
                    exth: 115
                },
                frozenColumns:[[
                    {field: 'format_excel_id', checkbox:true}
                ]],
                columns: Strack.build_import_ex_columns(format_data['header'], format_data['images_column'])
            }).datagrid('enableCellEditing')
                .datagrid('disableCellSelecting')
                .datagrid('gotoCell',
                    {
                        index: 0,
                        field: 'id'
                    }
                ).datagrid('columnMoving');
        }else {
            // 重置 datagrid 数据
            $datagrid.datagrid("setOptions", {
                columnsFieldConfig: columns_field_config,
                columns: Strack.build_import_ex_columns(format_data['header'], format_data['images_column'])
            }).datagrid('loadData',format_data['body']);
        }
    },
    //check 字段
    show_excel_check_fields: function (i, e) {
        $('#excel_fields_val').val($(i).data("field"));
        $('#excel_fields_menu').menu('show', {
            left: e.clientX,
            top: e.clientY + 15
        });
    },
    // 导入 excel step提交
    import_excel_step_submit: function (param) {
        var mapping_field = {};
        $("#import_ex_must").find(".menu-item").each(function () {
            if ($(this).data("mapping")) {
                mapping_field[$(this).data("fields")] = $(this).data("mapping");
            }
        });
        $("#import_ex_other").find(".menu-item").each(function () {
            if ($(this).data("mapping")) {
                mapping_field[$(this).data("fields")] = $(this).data("mapping");
            }
        });

        // 获取当前datagrid数据
        var dg_data = $("#import_excel_datagrid").datagrid("getData");

        $.ajax({
            type: 'POST',
            url: StrackPHP['submitImportExcelData'],
            dataType: 'json',
            contentType: "application/json",
            data: JSON.stringify({
                param: param,
                field_mapping: mapping_field,
                grid_data: dg_data['rows']
            }),
            beforeSend: function () {
                $('#import_excel_step').append(Strack.loading_dom('white'));
            },
            success: function (data) {
                Strack.G.importExcelStep.goStep(4);
                Strack.reset_import_excel_step_bnt(4);
                // 显示处理完结果
                $(".excel-in-submit").hide();
                if (parseInt(data["status"]) === 200) {
                    // 导入数据成功
                    var $excel_in_success = $("#excel_in_success");
                    $excel_in_success.show();
                    $excel_in_success.find(".success-number").html(data["data"]["success_total"]);
                    // 刷新datagrid数据
                    $("#" + param.grid).datagrid("reload");
                } else {
                    var $excel_in_error = $("#excel_in_error");
                    $excel_in_error.show();
                    $excel_in_error.find(".error-code").html(data["status"]);
                    $excel_in_error.find(".error-line").html(data["data"]["line"]);
                    $excel_in_error.find(".error-msg").html(data["data"]["message"]);
                }
                $('#st-load').remove();
            }
        });
    },
    // 关闭excel导入数据面板
    close_import_excel: function () {
        $("#import_excel_slider").sidebar("toggle");
    },
    //改变datagrid表格值
    change_field_col: function (grid) {
        var $datagrid = $('#' + grid);
        $(".iex_text").on("blur", function () {
            var lastIndex = $(this).attr("data-index");
            var row = $datagrid.datagrid("selectRow", lastIndex).datagrid("getSelected");
            var field = $(this).closest("td").attr("field");
            row[field] = $(this).val();
            $datagrid.datagrid('updateRow', {
                index: lastIndex,
                row: row
            });
            $(this).off("blur");
            Strack.change_field_col(grid);
        });
    },
    //生成下载Excle文件
    export_excel_file: function (i) {
        var $grid_view = $(i).closest(".grid-toolbar");
        var grid = $grid_view.attr("data-grid");
        Strack.export_excel_dialog(grid);
    },
    //导出Excel对话框
    export_excel_dialog: function (grid) {
        Strack.open_dialog('dialog', {
            title: StrackLang['Export_Excel'],
            width: 480,
            height: 180,
            content: Strack.dialog_dom({
                type: 'normal',
                hidden: [
                    {case: 101, id: 'Egrid', type: 'hidden', name: 'grid', valid: 1, value: grid}
                ],
                items: [
                    {
                        case: 1,
                        id: 'Ename',
                        type: 'text',
                        lang: StrackLang['Name'],
                        name: 'excel_name',
                        valid: 1,
                        value: ""
                    }
                ],
                footer: [
                    {obj: 'export_excel', type: 5, title: StrackLang['Submit']},
                    {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                ]
            })
        });
    },
    // 提交生成Excel文件
    export_excel: function () {
        var gird = $("#Egrid").val();
        var excel_name = $("#Ename").val();
        var options = $("#" + gird).datagrid("options");

        //获取字段设置
        var field_list = [];
        var field_list_first = [];

        if (options.frozenColumns.length > 1) {
            options.frozenColumns[0].forEach(function (val) {
                field_list_first.push(val);
            });

            // 第二层 index = 1
            var field_list_second = [];
            // 冻结字段
            options.frozenColumns[1].forEach(function (val) {
                if (val && val.field !== "id") {
                    field_list_second.push(val);
                }
            });

            // 普通字段
            options.columns[0].forEach(function (val) {
                field_list_first.push(val);
            });

            // 普通字段
            options.columns[1].forEach(function (val) {
                if (val && val.field !== "id") {
                    field_list_second.push(val);
                }
            });

            field_list.push(field_list_first, field_list_second);
        } else {
            // 冻结字段
            options.frozenColumns[0].forEach(function (val) {
                if (val && val.field !== "id") {
                    field_list_first.push(val);
                }
            });

            //普通字段
            options.columns[0].forEach(function (val) {
                if (val && val.field !== "id") {
                    field_list_first.push(val);
                }
            });
            field_list.push(field_list_first);
        }

        $.ajax({
            type: 'POST',
            url: StrackPHP['exportExcel'],
            data: {
                filter_data: options.queryParams.filter_data,
                columns_data: JSON.stringify(field_list),
                excel_name: excel_name,
                page: options.pageNumber,
                rows: options.pageSize
            },
            success: function (data) {
                if (parseInt(data['status']) === 200) {
                    Strack.top_message({bg: 'g', msg: data['message']});
                    Strack.dialog_cancel();
                    var url = StrackPHP["downloadExcel"] + '?id=' + data['data']['id'];
                    window.open(url);
                } else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
            }
        });
    },
    //管理自定义字段
    manage_fields: function (i) {
        var $grid_view = $(i).closest(".grid-toolbar");
        var param = {
            lang: $(i).attr("data-lang"),
            page_name: $grid_view.attr("data-page"),
            grid: $grid_view.attr("data-grid"),
            module_id: $grid_view.attr("data-moduleid"),
            project_id: $grid_view.attr("data-projectid")
        };

        Strack.manage_fields_dialog(param);
    },
    //管理自定义字段Dialog
    manage_fields_dialog: function (param) {
        Strack.open_dialog('dialog', {
            title: param.lang,
            width: 680,
            height: 464,
            content: Strack.dialog_dom({
                type: 'datagrid',
                grid: {
                    wrap_dom: 'dialog_wrap',
                    table_dom: 'dialog_data',
                    toolbar_show: true,
                    toolbar_id: 'dialog_tb',
                    toolbar_dom: [
                        {
                            obj: 'Strack.add_custom_field',
                            type: 'button',
                            icon: 'icon-add',
                            title: StrackLang['Add_Custom_Field']
                        }
                    ],
                    top_notice: StrackLang["Manage_Custom_Fields_Notice"],
                    height: 328
                },
                hidden: [
                    {case: 101, id: 'Nlang', type: 'hidden', name: 'lang', valid: 1, value: param.lang},
                    {case: 101, id: 'Npage_name', type: 'hidden', name: 'page_name', valid: 1, value: param.page_name},
                    {case: 101, id: 'Nproject_id', type: 'hidden', name: 'project_id', valid: 1, value: param.project_id},
                    {case: 101, id: 'Ngrid', type: 'hidden', name: 'grid', valid: 1, value: param.grid},
                    {case: 101, id: 'Nmodule_id', type: 'hidden', name: 'module_id', valid: 1, value: param.module_id}
                ],
                footer: [
                    {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                ]
            }),

            inits: function () {
                $('#dialog_data').datagrid({
                    url: StrackPHP['getCustomFieldsList'],
                    fitColumns: false,
                    height: Strack.panel_height('#dialog_wrap', 0),
                    differhigh: false,
                    rowheight: 49,
                    DragSelect: true,
                    queryParams: param,
                    columnsFieldConfig: {
                        name: {
                            field_type: 'custom',
                            field_map: 'name',
                            field_value_map: 'name',
                            primary: 'id',
                            module: 'variable',
                            table: 'Variable'
                        },
                        code: {
                            field_type: 'custom',
                            field_map: 'code',
                            field_value_map: 'code',
                            primary: 'id',
                            module: 'variable',
                            table: 'Variable'
                        }
                    },
                    columns: [[
                        {
                            field: 'variable_delete',
                            title: StrackLang["Delete"],
                            align: 'center',
                            findex: 0,
                            width: 60,
                            formatter: function (value, row, index) {
                                return '<a href="javascript:;" onclick="Strack.del_custom_field(this)" data-id="'+row["id"]+'" data-projectid="'+param.project_id+'" data-moduleid="'+param.module_id+'">'+
                                    '<i class="icon-remove p-cursor"></i>'+
                                    '</a>';
                            }
                        },
                        {
                            field: 'variable_edit',
                            title: StrackLang["Edit"],
                            align: 'center',
                            findex: 0,
                            width: 60,
                            formatter: function (value, row, index) {
                                return '<a href="javascript:;" onclick="Strack.edit_custom_field(this)" data-id="'+row["id"]+'" data-projectid="'+param.project_id+'" data-moduleid="'+param.module_id+'">'+
                                    '<i class="icon-edit p-cursor"></i>'+
                                    '</a>';
                            }
                        },
                        {field: 'id', title: StrackLang["ID"], align: 'center', findex: 1, width: 60},
                        {
                            field: 'name',
                            title: StrackLang["Name"],
                            align: 'center',
                            findex: 2,
                            width: 160,
                            editor: {type: 'text'}
                        },
                        {
                            field: 'code',
                            title: StrackLang["Code"],
                            align: 'center',
                            findex: 3,
                            width: 160,
                            editor: {type: 'text'}
                        },
                        {field: 'type', title: StrackLang["Field_Type"], align: 'center', findex: 4, width: 120}
                    ]],
                    toolbar: '#dialog_tb',
                    pagination: true,
                    pageSize: 100,
                    pageList: [100, 200],
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
                    );
            },
            close: function () {
                if (Strack.G.IsNewfileds) {
                    Strack.G.IsNewfileds = false;
                    window.location.reload();
                }
            }
        });
    },
    //删除自定义字段
    del_custom_field: function (i) {
        var $this = $(i);
        var param = {
            variable_id: $this.data("id"),
            project_id: $this.data("projectid"),
            module_id: $this.data("moduleid")
        };
        Strack.G.IsNewfileds = true;
        Strack.do_ajax_grid_delete('dialog_data', StrackLang['Del_Custom_Field_Notice'], StrackPHP['deleteCustomField'],true, [param["variable_id"]], param);
    },
    // 编辑修改自定义字段配置
    edit_custom_field: function(i)
    {
        var $this = $(i);
        var param = {
            variable_id: $this.data("id"),
            project_id: $this.data("projectid"),
            module_id: $this.data("moduleid"),
            lang: $('#Nlang').val(),
            page_name: $('#Npage_name').val(),
            grid: $('#Ngrid').val(),
        };

        var IsNewfileds = false;

        if (Strack.G.IsNewfileds) {
            Strack.G.IsNewfileds = false;
            IsNewfileds = true;
        }
        Strack.dialog_cancel();
        Strack.open_dialog('dialog', {
            title: StrackLang["Modify_Custom_Field"],
            width: 820,
            height: 520,
            content: Strack.dialog_dom({
                type: 'add_custom_field',
                hidden: [
                    {case: 101, id: 'Nmode', type: 'hidden', name: 'mode', valid: 1, value: 'modify'},
                    {case: 101, id: 'Nlang', type: 'hidden', name: 'lang', valid: 1, value: param.lang},
                    {case: 101, id: 'Npage_name', type: 'hidden', name: 'page_name', valid: 1, value: param.page_name},
                    {case: 101, id: 'Nproject_id', type: 'hidden', name: 'project_id', valid: 1, value: param.project_id},
                    {case: 101, id: 'Nvariable_id', type: 'hidden', name: 'variable_id', valid: 1, value: param.variable_id},
                    {case: 101, id: 'Ngrid', type: 'hidden', name: 'grid', valid: 1, value: param.grid},
                    {case: 101, id: 'Nmodule_id', type: 'hidden', name: 'module_id', valid: 1, value: param.module_id}
                ],
                footer: [
                    {obj: 'save_custom_field', type: 5, title: StrackLang['Submit']},
                    {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                ]
            }),
            inits: function () {
                $.ajax({
                    type: 'POST',
                    url: StrackPHP['getCustomFieldsConfig'],
                    data: param,
                    dataType: "json",
                    beforeSend: function () {
                        $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                    },
                    success: function (data) {
                        $.messager.progress('close');
                        var field_config = {};
                        switch (data["type"]){
                            case "text":
                                field_config = {"field_type": 'text', "lang": StrackLang["Input"]};
                                break;
                            case "combobox":
                                field_config = {"field_type": 'combobox', "lang": StrackLang["Combobox"]};
                                break;
                            case "datebox":
                                field_config =  {"field_type": 'datebox', "lang": StrackLang["Datebox"]};
                                break;
                            case "datetimebox":
                                field_config = {"field_type": 'datetimebox', "lang": StrackLang["Datetimebox"]};
                                break;
                            case "textarea":
                                field_config = {"field_type": 'textarea', "lang": StrackLang["Text"]};
                                break;
                            case "checkbox":
                                field_config =  {"field_type": 'checkbox', "lang": StrackLang["Checkbox"]};
                                break;
                            case "belong_to":
                                switch (data["relation_module_code"]){
                                    case "media":
                                        field_config =  {"field_type": 'media', "lang": StrackLang["Media"]};
                                        break;
                                    case "status":
                                        field_config =  {"field_type": 'status', "lang": StrackLang["Status"]};
                                        break;
                                }
                                break;
                            case "horizontal_relationship":
                                field_config =  {"field_type": 'horizontal_relationship', "lang": StrackLang["Horizontal_Relationship"]};
                                break;
                        }
                        $('#stdg_fd_list').empty().append(Strack.custom_field_type(field_config, true));
                        Strack.select_field_type_active(field_config["lang"], field_config["field_type"], data);
                    }
                });
            },
            close: function () {
                Strack.manage_fields_dialog(param);
                if (IsNewfileds) {
                    Strack.G.IsNewfileds = true;
                    IsNewfileds = false;
                }
            }
        });
    },
    select_field_type_active: function(lang, field_type, param){
        $('#stdg_fd_title').html(lang);
        Strack.fill_select_field_dom(field_type);
        $("#Fd_name").val(param["name"]);
        $("#Fd_code").val(param["code"]);
        switch (field_type) {
            case 'text':
                $("#Fd_inputMask").combobox("setValue", param["input_mask"]);
                $("#Fd_inputMask_length").val(param["input_mask_length"]);
                break;
            case 'combobox':
                for(var comb_index in param["combo_list"]){
                    $('#dg_comb_list').append(Strack.cf_comb_item_dom(param["combo_list"][comb_index]));
                }
                Strack.rebuild_comb_index('#dg_comb_list', 10);
                break;
            case 'status':
                // 生成随机id
                param["status_ids"].forEach(function (status_id) {
                    var random_id = 'cf_'+Math.floor(Math.random() * 10000 + 1);
                    $('#dg_status_comb_list').append(Strack.cf_status_comb_item_dom(random_id));
                    Strack.rebuild_comb_index('#dg_status_comb_list', 1);
                    Strack.combobox_widget("#"+random_id, {
                        url: StrackPHP["getStatusList"],
                        valueField: 'id',
                        textField: 'name',
                        groupField: 'correspond_name',
                        width: 250,
                        height: 26,
                        value: status_id
                    });
                });
                break;
            case 'horizontal_relationship':
                $("#Fd_editor").combobox("setValue", param["editor"]);
                $("#Fd_horizontal").combobox("disable")
                    .combobox("setValue", param["horizontal_config_id"]);
                break;
        }
    },
    //添加新字段
    add_custom_field: function () {
        var param = {
            lang: $('#Nlang').val(),
            page_name: $('#Npage_name').val(),
            grid: $('#Ngrid').val(),
            module_id: $('#Nmodule_id').val(),
            project_id: $('#Nproject_id').val()
        };

        var IsNewfileds = false;

        if (Strack.G.IsNewfileds) {
            Strack.G.IsNewfileds = false;
            IsNewfileds = true;
        }
        Strack.dialog_cancel();
        Strack.open_dialog('dialog', {
            title: StrackLang["Add_Custom_Field"],
            width: 820,
            height: 520,
            content: Strack.dialog_dom({
                type: 'add_custom_field',
                hidden: [
                    {case: 101, id: 'Nmode', type: 'hidden', name: 'mode', valid: 1, value: 'add'},
                    {case: 101, id: 'Nlang', type: 'hidden', name: 'lang', valid: 1, value: param.lang},
                    {case: 101, id: 'Npage_name', type: 'hidden', name: 'page_name', valid: 1, value: param.page_name},
                    {case: 101, id: 'Nproject_id', type: 'hidden', name: 'project_id', valid: 1, value: param.project_id},
                    {case: 101, id: 'Ngrid', type: 'hidden', name: 'grid', valid: 1, value: param.grid},
                    {case: 101, id: 'Nmodule_id', type: 'hidden', name: 'module_id', valid: 1, value: param.module_id}
                ],
                footer: [
                    {obj: 'save_custom_field', type: 5, title: StrackLang['Submit']},
                    {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                ]
            }),
            inits: function () {
                // 判断当前模块是否可以
                $.ajax({
                    type: 'POST',
                    url: StrackPHP['whetherSupportHorizontalRelation'],
                    dataType: 'json',
                    data: {
                        module_id: param.module_id
                    },
                    success: function (data) {
                        var field_config = [
                            {"field_type": 'text', "lang": StrackLang["Input"]},
                            {"field_type": 'combobox', "lang": StrackLang["Combobox"]},
                            {"field_type": 'datebox', "lang": StrackLang["Datebox"]},
                            {"field_type": 'datetimebox', "lang": StrackLang["Datetimebox"]},
                            {"field_type": 'textarea', "lang": StrackLang["Text"]},
                            {"field_type": 'checkbox', "lang": StrackLang["Checkbox"]},
                            //表达式字段暂时屏蔽 {"field_type": 'expression', "lang": StrackLang["Expression"]}
                        ];

                        if (data["data"]["allow_belong_to"] === "yes") {
                            field_config.push({
                                "field_type": 'status',
                                "lang": StrackLang["Status"]
                            });
                            field_config.push({
                                "field_type": 'media',
                                "lang": StrackLang["Media"]
                            });
                        }

                        if (data["data"]["allow_horizontal"] === "yes") {
                            field_config.push({
                                "field_type": 'horizontal_relationship',
                                "lang": StrackLang["Horizontal_Relationship"]
                            });
                        }
                        var dom = '';
                        field_config.forEach(function (val) {
                            dom += Strack.custom_field_type(val);
                        });
                        $('#stdg_fd_list').empty().append(dom);
                    }
                });
            },
            close: function () {
                Strack.manage_fields_dialog(param);
                if (IsNewfileds) {
                    Strack.G.IsNewfileds = true;
                    IsNewfileds = false;
                }
            }
        });
    },
    //添加字段类型listdom
    custom_field_type: function (param, active) {
        var dom = '';
        if(!active){
            dom += '<a href="javascript:;" onclick="Strack.select_field_type(this)" class="stdg-left-item" data-fieldtype="' + param["field_type"] + '" data-lang="' + param["lang"] + '">' +
                param["lang"] +
                '</a>';
        }else {
            dom += '<a href="javascript:;" class="stdg-left-item stdg-item-ac">' +
                param["lang"] +
                '</a>';
        }
        return dom;
    },
    //切换添加自定义字段面板
    select_field_type: function (i) {
        var lang = $(i).data("lang"),
            field_type = $(i).data("fieldtype");
        $('.stdg-left-item').removeClass("stdg-item-ac");
        $(i).addClass("stdg-item-ac");
        $('#stdg_fd_title').html(lang);
        Strack.fill_select_field_dom(field_type);
    },
    //添加字段主面板
    fill_select_field_dom: function (field_type) {
        var rconfig = null, idom = '', $fd_main = $('#stdg_fd_main');
        //获取添加字段dom配置
        switch (field_type) {
            case 'text':
                rconfig = Strack.custom_f_text_conf(field_type);
                break;
            case 'combobox':
                rconfig = Strack.custom_f_comb_conf(field_type);
                break;
            case 'textarea':
            case 'checkbox':
                rconfig = Strack.custom_f_textarea_conf(field_type);
                break;
            case 'datebox':
            case 'datetimebox':
            case 'media':
                rconfig = Strack.custom_f_date_conf(field_type);
                break;
            case 'status':
                rconfig = Strack.custom_f_status_conf(field_type);
                break;
            case 'expression':
                rconfig = Strack.custom_f_expression_conf(field_type);
                break;
            case 'horizontal_relationship':
                rconfig = Strack.custom_f_horizontal_conf(field_type);
                break;
        }

        rconfig["hide"].forEach(function (hi) {
            idom += Strack.dialog_items(hi);
        });
        rconfig["show"].forEach(function (ci) {
            idom += Strack.dialog_base_item(ci["lang"], ci);
        });
        $fd_main.empty().append(idom);

        switch (field_type) {
            case 'datebox':
            case 'datetimebox':
            case 'text':
            case 'combobox':
            case 'textarea':
            case 'checkbox':
            case 'horizontal_relationship':
                // 初始化掩码列表控件
                Strack.combobox_widget('#Fd_inputMask', {
                    url: StrackPHP["getInputMaskList"],
                    valueField: 'id',
                    textField: 'name',
                    width: 378,
                    height: 26,
                    value: "arbitrary",
                    onChange: function (newValue, oldValue) {
                        // arbitrary，integer_no_range，letter_no_range 三项可以设置最大长度
                        var $item = $("#Fd_inputMask_length").closest(".st-dialog-items");
                        if ($.inArray(newValue, ["arbitrary", "integer_no_range", "letter_no_range"]) >= 0) {
                            $item.show();
                        } else {
                            $item.hide();
                        }
                    }
                });

                // 初始化水平关联列表控件
                var module_id = $("#Nmodule_id").val();
                Strack.combobox_widget('#Fd_horizontal', {
                    url: StrackPHP["getHorizontalRelationList"],
                    valueField: 'id',
                    textField: 'name',
                    width: 378,
                    height: 26,
                    queryParams: {
                        module_id: module_id
                    }
                });
                break;
        }

        if(field_type === 'horizontal_relationship'){
            // 编辑器
            Strack.combobox_widget('#Fd_editor', {
                data: [
                    {id: 'horizontal_relationship', name: StrackLang["GridDialog"]},
                    {id: 'tagbox', name: StrackLang["TagBox"]}
                ],
                valueField: 'id',
                textField: 'name',
                value: 'tagbox',
                width: 378,
                height: 26
            });
        }
        $(":input").inputmask();
    },
    //添加字段输入Input dom
    custom_f_text_conf: function (type) {
        return {
            "hide": [
                {case: 101, id: 'Fd_type', type: 'hidden', name: 'field_type', valid: 1, value: type}
            ],
            "show": [
                {
                    case: 1,
                    id: 'Fd_name',
                    type: 'text',
                    lang: StrackLang['Field_Name'],
                    name: 'name',
                    valid: "1,128",
                    value: "",
                    mask: "*{1,128}"
                },
                {
                    case: 1,
                    id: 'Fd_code',
                    type: 'text',
                    lang: StrackLang['Code'],
                    name: 'code',
                    valid: "1,128",
                    value: "",
                    mask: "alphaDash"
                },
                {
                    case: 2,
                    id: 'Fd_inputMask',
                    type: 'text',
                    lang: StrackLang['Input_Mask'],
                    name: 'input_mask',
                    valid: "",
                    value: ""
                },
                {
                    case: 1,
                    id: 'Fd_inputMask_length',
                    type: 'text',
                    lang: StrackLang['Input_Mask_Length'],
                    name: 'input_mask_length',
                    valid: "",
                    value: "",
                    mask: "9{1,999999999}"
                }
            ]
        };
    },
    //添加字段输入Combobox dom
    custom_f_comb_conf: function (type) {
        return {
            "hide": [
                {case: 101, id: 'Fd_type', type: 'hidden', name: 'field_type', valid: 1, value: type}
            ],
            "show": [
                {
                    case: 1,
                    id: 'Fd_name',
                    type: 'text',
                    lang: StrackLang['Field_Name'],
                    name: 'name',
                    valid: "1,128",
                    value: "",
                    mask: "*{1,128}"
                },
                {
                    case: 1,
                    id: 'Fd_code',
                    type: 'text',
                    lang: StrackLang['Code'],
                    name: 'code',
                    valid: "1,128",
                    value: "",
                    mask: "alphaDash"
                },
                {
                    case: 103,
                    id: 'Fd_comblist',
                    type: 'text',
                    lang: StrackLang['Combo_List'],
                    name: 'comb_list',
                    valid: 1,
                    value: ""
                }
            ]
        };
    },
    //添加字段输入Text dom
    custom_f_textarea_conf: function (type) {
        return {
            "hide": [
                {case: 101, id: 'Fd_type', type: 'hidden', name: 'field_type', valid: 1, value: type}
            ],
            "show": [
                {case: 1, id: 'Fd_name', type: 'text', lang: StrackLang['Field_Name'], name: 'name', valid: "1,128", value: "", mask: "*{1,128}"},
                {case: 1, id: 'Fd_code', type: 'text', lang: StrackLang['Code'], name: 'code', valid: "1,128", value: "", mask: "alphaDash"}
            ]
        };
    },
    //添加字段输入Datebox dom
    custom_f_date_conf: function (type) {
        return {
            "hide": [
                {case: 101, id: 'Fd_type', type: 'hidden', name: 'field_type', valid: 1, value: type}
            ],
            "show": [
                {
                    case: 1,
                    id: 'Fd_name',
                    type: 'text',
                    lang: StrackLang['Field_Name'],
                    name: 'name',
                    valid: "1,128",
                    value: "",
                    mask: "*{1,128}"
                },
                {
                    case: 1,
                    id: 'Fd_code',
                    type: 'text',
                    lang: StrackLang['Code'],
                    name: 'code',
                    valid: "1,128",
                    value: "",
                    mask: "alphaDash"
                }
            ]
        };
    },
    // 添加自定义状态字段
    custom_f_status_conf: function(type){
        return {
            "hide": [
                {case: 101, id: 'Fd_type', type: 'hidden', name: 'field_type', valid: 1, value: type}
            ],
            "show": [
                {case: 1, id: 'Fd_name', type: 'text', lang: StrackLang['Field_Name'], name: 'name', valid: "1,128", value: "", mask: "*{1,128}"},
                {case: 1, id: 'Fd_code', type: 'text', lang: StrackLang['Code'], name: 'code', valid: "1,128", value: "", mask: "alphaDash"},
                {case: 109, id: 'Fd_comblist', type: 'text', lang: StrackLang['Combo_List'], name: 'comb_list', valid: 1, value: ""}
            ]
        };
    },
    // 添加表达式自定义字段 dom
    custom_f_expression_conf: function(type){
        return {
            "hide": [
                {case: 101, id: 'Fd_type', type: 'hidden', name: 'field_type', valid: 1, value: type}
            ],
            "show": [
                {case: 1, id: 'Fd_name', type: 'text', lang: StrackLang['Field_Name'], name: 'name', valid: "1,128", value: "", mask: "*{1,128}"},
                {case: 1, id: 'Fd_code', type: 'text', lang: StrackLang['Code'], name: 'code', valid: "1,128", value: "", mask: "alphaDash"},
                {case: 7, id: 'Fd_expression', type: 'text', lang: StrackLang['Expression'], name: 'expression', valid: "1", value: "", mask: ""}
            ]
        };
    },
    //添加水平关联自定义字段 dom
    custom_f_horizontal_conf: function (type) {
        return {
            "hide": [
                {case: 101, id: 'Fd_type', type: 'hidden', name: 'field_type', valid: 1, value: type}
            ],
            "show": [
                {case: 1, id: 'Fd_name', type: 'text', lang: StrackLang['Field_Name'], name: 'name', valid: "1,128", value: "", mask: "*{1,128}"},
                {case: 1, id: 'Fd_code', type: 'text', lang: StrackLang['Code'], name: 'code', valid: "1,128", value: "", mask: "alphaDash"},
                {case: 2, id: 'Fd_editor', type: 'text', lang: StrackLang['Editor'], name: 'editor', valid: "1", value: ""},
                {case: 2, id: 'Fd_horizontal', type: 'text', lang: StrackLang['Relation_Module_List'], name: 'relation_module', valid: "1", value: ""}
            ]
        };
    },
    //添加combobox menu list
    add_cf_comb_item: function (i) {
        $('#dg_comb_list').append(Strack.cf_comb_item_dom(''));
        Strack.rebuild_comb_index('#dg_comb_list', 10);
    },
    cf_comb_item_dom: function (val) {
        var dom = '';
        dom += '<div class="dg-cblist-item">' +
            '<div class="dgcb-id aign-left"><input type="text" disabled="disabled"></div>' +
            '<div class="dgcb-name aign-left"><input type="text" value="'+val+'"></div>' +
            '<a href="javascript:;" onclick="Strack.del_cf_comb_item(this)" class="dgcb-deitem aign-left"><i class="icon-uniEA34 icon-right"></i></a>' +
            '</div>';
        return dom;
    },
    //删除combobox menu list
    del_cf_comb_item: function (i) {
        $(i).parent().remove();
        Strack.rebuild_comb_index('#dg_comb_list', 10);
    },
    //生成编号
    rebuild_comb_index: function (id, step) {
        var num = 0;
        $(id).find('.dg-cblist-item').each(function () {
            num += step;
            $(this).find('.dgcb-id input').val(num);
        });
    },
    // 添加status combobox menu list
    add_cf_status_comb_item: function()
    {
        // 生成随机id
        var random_id = 'cf_'+Math.floor(Math.random() * 10000 + 1);
        $('#dg_status_comb_list').append(Strack.cf_status_comb_item_dom(random_id));
        Strack.rebuild_comb_index('#dg_status_comb_list', 1);

        Strack.combobox_widget("#"+random_id, {
            url: StrackPHP["getStatusList"],
            valueField: 'id',
            textField: 'name',
            groupField: 'correspond_name',
            width: 250,
            height: 26
        });
    },
    cf_status_comb_item_dom: function (random_id) {
        var dom = '';
        dom += '<div class="dg-cblist-item">' +
            '<div class="dgcb-id aign-left"><input type="text" disabled="disabled"></div>' +
            '<div class="dgcb-name aign-left"><input id="'+random_id+'" type="text"></div>' +
            '<a href="javascript:;" onclick="Strack.del_cf_status_comb_item(this)" class="dgcb-deitem aign-left" data-randomid="'+random_id+'"><i class="icon-uniEA34 icon-right"></i></a>' +
            '</div>';
        return dom;
    },
    //删除combobox menu list
    del_cf_status_comb_item: function (i) {
        var random_id = $(i).attr("data-randomid");
        $("#"+random_id).combobox("destroy");
        $(i).parent().remove();
        Strack.rebuild_comb_index('#dg_status_comb_list', 1);
    },
    //提交新字段添加
    save_custom_field: function () {
        var ftype = $("#Fd_type").val(),
            vdata = [],
            upallow = false,
            udata = {};

        $(".st-dialog-input").children("i").remove();

        $("#stdg_fd_main").find(".st-dialog-input").each(function () {
            var $input = $(this).children("input"),
                vname = "",
                vval = "",
                valid = "";

            if($input.length === 0){
                $input = $(this).children("textarea");
            }

            if (!$.isEmptyObject($input[0])) {
                vname = $input.attr("data-name");
                valid = $input.data("valid");
                if ($input.hasClass("combobox-f")) {
                    vval = Strack.get_combos_val('#' + $input.attr("id"), 'combobox', 'getValue');
                } else {
                    vval = $('#' + $input.attr("id")).val();
                }
                if (valid == 0 || vval.length > 0) {
                    vdata.push({"field": vname, "value": vval});
                    $input.parent().append(Strack.dialog_error_icon("t"));
                    upallow = true;
                } else {
                    switch (vname) {
                        case "name":
                            layer.msg(StrackLang['Variable_Name_Null'], {icon: 2, time: 1200, anim: 6});
                            break;
                        case "code":
                            layer.msg(StrackLang['Variable_Code_Null'], {icon: 2, time: 1200, anim: 6});
                            break;
                        case "editor":
                            layer.msg(StrackLang['Variable_Editor_Null'], {icon: 2, time: 1200, anim: 6});
                            break;
                        case "relation_module":
                            layer.msg(StrackLang['Variable_Relation_Module_Null'], {icon: 2, time: 1200, anim: 6});
                            break;
                    }
                    $input.parent().append(Strack.dialog_error_icon("e"));
                    upallow = false;
                    return false;
                }
            }
        });
        if (upallow) {
            udata["base_data"] = vdata;
            var $input_arr,comb_arr;
            switch (ftype) {
                case 'combobox'://combobox
                    $input_arr = $("#dg_comb_list").find(".dgcb-name input");
                    comb_arr = [];
                    if ($input_arr.length > 0) {
                        $input_arr.each(function () {
                            var cm_val = $(this).val();
                            if (cm_val) {
                                comb_arr.push(cm_val);
                            } else {
                                layer.msg(StrackLang['Variable_Combobox_Menu_Val_Null'], {icon: 2, time: 1200, anim: 6});
                                upallow = false;
                                return false;
                            }
                        });
                        udata["field_type"] = 'combobox';
                        udata["comb_data"] = comb_arr;
                    } else {
                        upallow = false;
                        layer.msg(StrackLang['Variable_Combobox_Menu_Null'], {icon: 2, time: 1200, anim: 6});
                    }
                    break;
                case "status":// status
                    $input_arr = $("#dg_status_comb_list").find("input.combobox-f");
                    comb_arr = [];
                    if ($input_arr.length > 0) {
                        $input_arr.each(function () {
                            var cm_val = Strack.get_combos_val(this, 'combobox', 'getValue');
                            if (cm_val) {
                                comb_arr.push(cm_val);
                            } else {
                                layer.msg(StrackLang['Variable_Combobox_Menu_Val_Null'], {icon: 2, time: 1200, anim: 6});
                                upallow = false;
                                return false;
                            }
                        });
                        udata["field_type"] = 'belong_to';
                        udata["editor"] = 'combobox';
                        udata["comb_data"] = comb_arr;
                        udata["relation_module_code"] = 'status';
                    } else {
                        upallow = false;
                        layer.msg(StrackLang['Variable_Combobox_Menu_Null'], {icon: 2, time: 1200, anim: 6});
                    }
                    break;
                case "media":// media
                    udata["field_type"] = 'belong_to';
                    udata["editor"] = 'upload';
                    udata["relation_module_code"] = 'media';
                    break;
                default:
                    udata["field_type"] = ftype;
                    break;
            }
        }
        //提交后台新增自定义字段
        if (upallow) {

            //获取隐藏参数
            var hide_param = {};
            $("#st_dialog_form_hide").find('input').each(function () {
                hide_param[$(this).attr("data-name")] = $(this).val();
            });

            udata["base_data"].push({field: "action_scope", value: "current"});

            if (udata["field_type"] === "text") {
                var mask = {field: 'mask', value: ''};
                var base_data_index = {};
                udata["base_data"].forEach(function (val) {
                    base_data_index[val["field"]] = val["value"];
                });
                switch (base_data_index["input_mask"]) {
                    case "arbitrary":
                        mask["value"] = parseInt(base_data_index["input_mask_length"]) > 0 ? '*{1,' + base_data_index["input_mask_length"] + '}' : '*{1,999999999999999999}';
                        break;
                    case "integer_no_range":
                        mask["value"] = parseInt(base_data_index["input_mask_length"]) > 0 ? '9{1,' + base_data_index["input_mask_length"] + '}' : '9{1,999999999999999999}';
                        break;
                    case "letter_no_range":
                        mask["value"] = parseInt(base_data_index["input_mask_length"]) > 0 ? 'a{1,' + base_data_index["input_mask_length"] + '}' : 'a{1,999999999999999999}';
                        break;
                    default:
                        mask["value"] = base_data_index["input_mask"];
                        break;
                }
                udata["base_data"].push(mask);
            }

            var url = '';
            switch (hide_param["mode"]){
                case "add":
                    url = StrackPHP['addCustomFields'];
                    break;
                case "modify":
                    url = StrackPHP['modifyCustomFields'];
                    break;
            }

            $.ajax({
                type: 'POST',
                url: url,
                data: JSON.stringify({
                    param: hide_param,
                    field_data: udata
                }),
                dataType: "json",
                contentType: 'application/json',
                beforeSend: function () {
                    $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                },
                success: function (data) {
                    $.messager.progress('close');
                    if (parseInt(data['status']) === 200) {
                        Strack.dialog_cancel();
                        Strack.top_message({bg: 'g', msg: data['message']});
                    } else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        }
    },
    //冻结表头
    frozen_col: function (i, e) {
        var field = $(i).closest("td").attr("field"),
            $child = $(i).find("i"),
            dindex = $(i).data("index");
        var grid = $(i).closest(".datagrid-view").find(".datagrid-f").attr('id');
        var $grid = $("#" + grid);
        e.stopPropagation();
        if ($child.hasClass("icon-uniF023")) {
            //冻结当前字段
            $grid.datagrid("FrozenColumn", {
                "field": field,
                "index": dindex,
                "isfrozen": "frozen"
            }).datagrid("reload");
        } else {
            $grid.datagrid("FrozenColumn", {
                "field": field,
                "index": dindex,
                "isfrozen": "nofrozen"
            }).datagrid("reload");
        }
        $grid.datagrid("highlightViewSave");
    },
    //头像DOM
    build_comb_avatar: function (val) {
        var adom = '';
        var avatar = Strack.build_avatar(
            val['avatar'],
            "e-avatar-small",
            "d-avatar-small",
            Strack.JointLetter(val['first_name'], val['last_name'])
        );
        adom += '<div class="comb-avatar">' +
            '<div class="comb-aimg aign-left">' + avatar + '</div>' +
            '<div class="comb-name text-ellipsis aign-left">' + val['uname'] + '</div>' +
            '</div>';
        return adom;
    },
    //状态控件显示样式dom
    widget_status_dom: function (i, n, bg) {
        var sdom = '';
        sdom += '<i class="' + i + ' icon-left" style="color:' + Strack.hex_to_rgb(bg, 1) + '" ></i>';
        sdom += n;
        return sdom;
    },
    //全局input tea事件，触发提交和全局变量修改
    init_filter_event: function (p) {
        p.find(".filter-task-panel input,.filter-task-panel textarea")
            .off("change")
            .on("change", function () {
                if ($(this).attr("type") != "checkbox") {
                    Strack.filter_auto(this);
                }
            });
    },
    //自动加载
    filter_auto: function (i) {
        var ischeck = $(i).closest(".datagrid-filter").find(".filter_auto_in").is(":checked");
        if (ischeck) {
            Strack.filter_apply($(i));
        }
    },
    //手动加载
    filter_manual: function (i) {
        Strack.filter_apply($(i));
    },
    //do search 点击手动过滤
    filter_apply: function ($this) {
        var items = $this.closest(".grid-filter-right").find(".filter-items");
        if (items.length > 0) {
            var field, field_type, variable_id, editor, module_code, module_type, table, $in_wrap;
            var term, tval, date_term_ck, date_range_ck, condition;
            var filter_panel = [];
            items.each(function () {
                field = $(this).attr('field');
                field_type = $(this).attr("field_type");
                variable_id = $(this).attr("variable_id");
                editor = $(this).attr('editor');
                module_code = $(this).attr('module');
                module_type = $(this).attr('module_type');
                table = $(this).attr('table');
                $in_wrap = $(this).find(".filter-input-wrap");

                switch (editor) {
                    case "text":
                    case "textarea":
                        term = Strack.get_combos_val($in_wrap.find('.term-list')[0], 'combobox', 'getValue');
                        tval = $in_wrap.find('.input-text').val();
                        if (tval && term) {
                            filter_panel.push({
                                field: field,
                                field_type: field_type,
                                variable_id: variable_id,
                                value: tval,
                                condition: term,
                                editor: editor,
                                module_code: module_code,
                                module_type: module_type,
                                table: table
                            });
                        }
                        break;
                    case "tagbox":
                    case "horizontal_relationship":
                    case "relation":
                    case "checkbox":
                    case "combobox":
                        var $comb_in = $in_wrap.find('.in-combobox');
                        var options = $comb_in.combobox("options");
                        if (options.multiple) {
                            tval = Strack.get_combos_val($comb_in[0], 'combobox', 'getValues');
                            condition = 'IN';
                        } else {
                            tval = Strack.get_combos_val($comb_in[0], 'combobox', 'getValue');
                            condition = 'EQ';
                        }
                        if (tval) {
                            filter_panel.push({
                                field: field,
                                field_type: field_type,
                                variable_id: variable_id,
                                value: tval,
                                condition: condition,
                                editor: editor,
                                module_code: module_code,
                                module_type: module_type,
                                table: table
                            });
                        }
                        break;
                    case "datebox":
                    case "datetimebox":
                        date_term_ck = $in_wrap.find('.in-date-term').prop("checked");
                        date_range_ck = $in_wrap.find('.in-date-range').prop("checked");
                        if (date_term_ck) {
                            term = Strack.get_combos_val($in_wrap.find('.term-list')[0], 'combobox', 'getValue');
                            tval = $in_wrap.find('.term-date').datebox("getValue");
                            if (tval && term) {
                                filter_panel.push({
                                    field: field,
                                    field_type: field_type,
                                    variable_id: variable_id,
                                    value: tval,
                                    condition: term,
                                    editor: editor,
                                    module_code: module_code,
                                    module_type: module_type,
                                    table: table
                                });
                            }
                        }
                        if (date_range_ck) {
                            term = $in_wrap.find('.start-date').datebox("getValue");
                            tval = $in_wrap.find('.end-date').datebox("getValue");
                            if (tval && term) {
                                filter_panel.push({
                                    field: field,
                                    field_type: field_type,
                                    variable_id: variable_id,
                                    value: term + ',' + tval,
                                    condition: 'BETWEEN',
                                    editor: editor,
                                    module_code: module_code,
                                    module_type: module_type,
                                    table: table
                                });
                            }
                        }
                        break;
                }
            });
            var $filter = $this.closest(".datagrid-filter");
            var maindom = $filter.attr("data-maindom"),
                bardom = $filter.attr("data-bardom");

            var $grid = $("#" + maindom).find(".datagrid-f");
            $grid.datagrid("setFilterParams", {
                filter_input: [],
                filter_panel: filter_panel,
                filter_advance: []
            }).datagrid("reload");

            //保存过滤条件缓存
            Strack.save_filter_cache(bardom, 'filter_panel', filter_panel);
            Strack.show_nosaved_filter(bardom, 'filter_panel', StrackLang["Panel_Filter"]);

        } else {
            layer.msg(StrackLang['Please_Choice_Filter'], {icon: 2, time: 1200, anim: 6});
        }
    },
    //分组排序 覆盖sort排序
    group_sort_change: function (i) {
        var grid = $(i).data("grid"),
            ptype = $(i).data("ptype"),
            pid = $(i).data("pid"),
            sort = $(i).data("sort"),
            $grid = $('#' + grid);
        if ($(i).hasClass("field-disable")) {
            $("#gasc_sort_" + ptype).addClass("field-disable");
            $("#gdesc_sort_" + ptype).addClass("field-disable");
            $(".gitem_" + ptype).each(function () {
                if ($(this).find("i").hasClass("icon-checked")) {
                    $("#g" + sort + "_sort_" + ptype).removeClass("field-disable");
                    var fdata = {}, hdata,
                        field = $(this).data("field"),
                        grid = $(this).data("grid"),
                        $grid = $('#' + grid);
                    fdata[field] = sort;
                    hdata = [{"sortName": field, "sortOrder": sort}];
                    Strack.DataSortAc($grid, $(this), ptype, fdata, hdata, "noadv", true);
                    Strack.save_storage("GroupSort_" + pid + "_" + ptype, JSON.stringify(hdata));
                    Strack.delete_storage("AdvSort_" + pid + "_" + ptype);
                }
            });
        }
    },
    // 缩略图控件
    thumb_media_widget: function(id, data, auth)
    {
        // 生成随机id
        var random_id = Math.floor(Math.random() * 1000000 + 1);
        var thumb_css = "thumb-"+data["module_id"]+"-"+data["link_id"];

        var param = {
            id: random_id,
            css: thumb_css,
            link_id: data["link_id"],
            module_id: data["module_id"],
            has_media : data['has_media'],
            media_param :   data['param']
        };

        // 添加到thumb dom容器
        $(id).empty().append(Strack.thumb_media_widget_dom(random_id, param, auth));

        // 初始化控件
        if (data['has_media'] === 'yes'){
            Strack.init_thumb_media(random_id);
        }

        Strack.init_dropdown();
    },
    // 生成通用控件缩略图 dom
    thumb_media_common_dom: function(val, param){
        var random_id = Math.floor(Math.random() * 1000000 + 1);
        var thumb_css = param["config"]["fields"]+"-"+param["param"]["module_id"]+"-"+param["param"]["primary"];
        var has_media = 'no';
        var media_param = {};
        if(val && val["total"] > 0){
            has_media = 'yes';
            media_param = val["rows"][0]["param"];
            switch (param.from){
                case 'common':
                    Strack.G.infoMediaNeedInit.push(random_id);
                    break;
                case 'grid':
                    Strack.G.gridMediaNeedInit.push(random_id);
                    break;
            }
        }
        var thumb_param = {
            id: random_id,
            css: thumb_css,
            link_id: param["param"]["primary"],
            module_id: param["param"]["module_id"],
            has_media : has_media,
            media_param :  media_param
        };
       return Strack.thumb_media_widget_dom(random_id, thumb_param, {'modify_thumb': 'no', 'clear_thumb': 'no'})
    },
    // 生成表格可以预览缩略图
    build_grid_preview_thumb_dom: function(param){
        var val = {"total":0,"rows":[]};
        if(param.thumb){
            val.total = 1;
            val.rows.push({'param': param.param});
        }
        return Strack.thumb_media_common_dom(val, {
            param: {
                primary: param.id,
                module_id: param.module_id
            },
            from: 'grid',
            config: param.field_config
        });
    },
    // thumb 缩略图dom
    thumb_media_widget_dom: function(random_id, param, auth)
    {
        var dom = '';
        dom += '<div class="item-thumb-warp '+param.css+'" thumb-type="thumb">'+
            '<div id="light_box_main_'+random_id+'" class="task-thumb-show" data-id="'+random_id+'">'+
            // 缩略图预览
            Strack.thumb_media_preview_dom(param) +
            '</div>'+
            '<div id="light_box_video_'+random_id+'" class="light-video">'+
            // 缩略图视频
            Strack.thumb_media_preview_video_dom(param)+
            '</div>';

        if(auth["modify_thumb"] === "yes" && auth["clear_thumb"] === "yes") {
            dom += '<div class="ui secondary vertical menu thumb-menu-bnt" data-linkid="' + param["link_id"] + '" data-moduleid="' + param["module_id"] + '">' +
                '<div class="ui dropdown item">' +
                '<i class="icon-uniF03A"></i>' +
                '<div class="menu">';

            if (auth["modify_thumb"] === "yes") {
                dom += '<a href="javascript:;" class="item" onclick="Strack.change_item_media(this)">' + StrackLang["Modify_Thumb"] + '</a>';
            }

            if (auth["clear_thumb"] === "yes") {
                dom += '<a href="javascript:;" class="item" onclick="Strack.clear_item_thumb(this)">' + StrackLang["Clear_Thumb"] + '</a>';
            }

            dom += '</div>' +
                '</div>' +
                '</div>';
        }

        dom +='</div>';

        return dom;
    },
    // 初始化缩略图控件
    init_thumb_media: function(random_id)
    {
        lightGallery(document.getElementById('light_box_main_'+random_id), {
            galleryId: random_id,
            appendSubHtmlTo: '.lg-item',
            addClass: 'lg-comments',
            mode: 'lg-fade',
            enableDrag: false,
            download: false,
            enableSwipe: false
        });

    },
    // 初始化通用控件区域媒体
    init_other_thumb_media: function(from)
    {
        switch (from){
            case 'common':
                Strack.G.infoMediaNeedInit.forEach(function (val) {
                    Strack.init_thumb_media(val);
                });
                Strack.G.infoMediaNeedInit = [];
                break;
            case 'grid':
                Strack.G.gridMediaNeedInit.forEach(function (val) {
                    Strack.init_thumb_media(val);
                });
                Strack.G.gridMediaNeedInit = [];
                break;
        }
    },
    // 缩略图控件预览DOM
    thumb_media_preview_dom: function (data) {
        var dom = '';
        var param = data["media_param"];
        if (data['has_media'] === 'yes' && $.inArray(param['type'], ['image', 'video']) >= 0) {
            // 存在缩略图
            dom += Strack.light_box_item_dom(data.id, param)['main_dom'];
        } else {
            // 不存在缩略图
            var null_icon = data["media_param"]["icon"]? data["media_param"]["icon"] : "icon-uniE61A";
            dom += '<div class="task-thumb-null">' +
                '<i class="icon-left-p ' + null_icon + '"></i>' +
                '</div>';
        }
        return dom;
    },
    // 缩略图控件预览视频依赖DOM
    thumb_media_preview_video_dom: function(data)
    {
        var dom = '';
        if (data['has_media'] === 'yes' && data["media_param"]['type'] === 'video') {
            var video_url = data["media_param"]['base_url']+data["media_param"]['md5_name']+'.mp4';
            dom += '<video class="lg-video-object lg-html5" controls preload="none" loop="loop" >' +
                '<source src="'+video_url+'" type="video/mp4">' +
                'Your browser does not support HTML5 video.' +
                '</video>';
        }
        return dom;
    },
    //Note 缩略图组装
    show_note_img_att: function (id, data) {
        var main_dom = '',
            video_dom = '',
            item_dom,
            random_id;
        if(data['has_media'] === 'yes'){
            data['param'].forEach(function (item) {
                random_id = 'item'+Math.floor(Math.random() * 100000 + 1);
                item_dom = Strack.light_box_item_dom(random_id, item);
                main_dom += item_dom['main_dom'];
                video_dom += item_dom['video_dom'];
            });
        }

        var dom = '<div id="light_box_main_'+id+'">' +
            main_dom +
            '</div>'+
            video_dom;
        return dom;
    },
    // 灯箱 lighting box 基础dom
    light_box_item_dom: function(id, param)
    {
        var main_dom = '',
            video_dom = '';
        switch (param['type']){
            case 'image':
                // 图片类型
                var responsive = [];
                var url = '',
                    min_size = 999999,
                    min_size_url = '',
                    max_size_url = '',
                    size = 0;
                var size_list = [];
                if(Strack.is_string(param['size'])){
                    size_list = param['size'].split(",");
                }else {
                    size_list = param['size'];
                }
                size_list.forEach(function (val) {
                    url = param['base_url']+param['md5_name']+'_'+val+'.'+param['ext'];
                    if(val === 'origin'){
                        size = param['width'];
                        max_size_url = url;
                    }else {
                        size = val.split('x')[0];
                    }
                    if(size < min_size){
                        min_size_url = url;
                    }
                    responsive.push(url+' '+size)
                });

                main_dom = '<a class="light-box" data-responsive="'+responsive.join(",")+'" data-src="'+max_size_url+'" >'+
                    '<img src="'+min_size_url+'" />'+
                    '<div class="light-poster">'+
                    '<i class="icon icon-uniE647"></i>'+
                    '</div>'+
                    '</a>';
                break;
            case 'video':
                // 视频类型
                var img_url = param['base_url']+param['md5_name']+'.jpg';
                main_dom = '<a class="light-box" data-poster="'+img_url+'"  data-html="#light_box_video_'+id+'" >'+
                    '<img class="img-responsive" src="'+img_url+'">'+
                    '<div class="light-poster">'+
                    '<i class="icon icon-uniE647"></i>'+
                    '</div>'+
                    '</a>';
                // 视频类型附带video dom
                var video_url = param['base_url']+param['md5_name']+'.mp4';
                video_dom +=  '<div id="light_box_video_'+id+'" class="light-video">'+
                    '<video class="lg-video-object lg-html5" controls preload="none" loop="loop" >' +
                    '<source src="'+video_url+'" type="video/mp4">' +
                    'Your browser does not support HTML5 video.' +
                    '</video>' +
                    '</div>';
                break;
        }
        return {main_dom:main_dom, video_dom: video_dom};
    },
    //缩略图
    build_thumb_dom: function (img, icon) {
        var dimg = '';
        if (img) {
            dimg += '<img class="proj_thumb_ck" src="' + img + '">';
        } else {
            dimg += '<div class="panel-thumb-null proj_thumb_ck"><i class="' + icon + '"></i></div>';
        }
        return dimg;
    },
    // 生成grid缩略图 dom
    build_grid_thumb_dom: function (thumb) {
        var img_dom = '';
        if (thumb) {
            img_dom += '<img src="' + thumb + '">';
        } else {
            img_dom += '<i class="icon-left-p icon-uniE61A"></i>';
        }
        var dom = '';
        dom += '<a href="#" class="athumb"  >' + img_dom + '</a>';
        return dom;
    },
    // 获取媒体上传服务器地址信息
    get_media_server: function(callback, errorback)
    {
        $.ajax({
            type: 'POST',
            url: StrackPHP['getMediaUploadServer'],
            dataType: "json",
            success: function (data) {
                if (parseInt(data['status']) === 200) {
                    Strack.G.Media_Server = data["data"];
                    callback(data["data"]);
                }else {
                    // 服务器不存在或者错误
                    if(errorback){
                        errorback(data);
                    }else {
                        layer.msg(data['message'], {icon: 7, time: 1200, anim: 6});
                    }
                }
            }
        });
    },
    // 组装生成媒体缩略图url
    assembly_media_thumb_data: function(server_data, media_data)
    {
        var thumb_data = {
            "size" : "",
            "thumb" : ""
        };
        switch (media_data["type"]) {
            case 'video':
                // 视频保存原始尺寸
                thumb_data["size"] = media_data["width"]+"x"+media_data["height"];
                thumb_data["thumb"] = server_data['request_url']+""+media_data['path']+""+media_data['md5_name']+".jpg";
                break;
            case 'image':
                // 获取图片上传尺寸
                thumb_data["size"] = media_data["size"];
                var size_array = media_data["size"].split(",");
                var min_size = 999999;
                var min_size_string = 'origin';
                size_array.forEach(function (val) {
                    if (val !== 'origin' && val.indexOf("x") !== -1) {
                        var item_arr = val.split("x");
                        if (item_arr[0] < min_size) {
                            min_size_string = val;
                        }
                    }
                });
                thumb_data["thumb"] = server_data['request_url']+""+media_data['path']+""+media_data['md5_name']+"_"+min_size_string+"."+media_data['ext'];
                break;
        }
        return thumb_data;
    },
    // 媒体上传成功写入数据库
    save_media_data: function(add_data, callback)
    {
        add_data["media_data"]["base_url"] = add_data["media_server"]["request_url"]+add_data["media_data"]["path"];
        $.ajax({
            type: 'POST',
            url: StrackPHP['saveMediaData'],
            dataType: "json",
            data: JSON.stringify(add_data),
            contentType: 'application/json',
            success: function (data) {
                if (parseInt(data['status']) === 200) {
                    Strack.top_message({bg:'g',msg: data['message']});
                    // 成功更新图像数据
                    if(!Strack.Websocket.List.hasOwnProperty("update")){
                        data.data.status = 200;
                        Strack.update.thumbnail(data['data']);
                    }
                }else {
                    layer.msg(data['message'], {icon: 7, time: 1200, anim: 6});
                }
                callback(data);
            }
        });
    },
    // 上传用户头像Dialog
    upload_avatar_dialog: function(i)
    {
        var user_id = $(i).attr("data-userid"),
            module_id = $(i).attr("data-moduleid"),
            avatar_id = $(i).attr("data-avatarid");

        Strack.get_media_server(
            function (data) {
                Strack.open_dialog('dialog', {
                    title: StrackLang['Modify_Avatar'],
                    width: 580,
                    height: 700,
                    top: null,
                    content: Strack.dialog_dom({
                        type: 'avatar',
                        header_extra: {
                            user_data: {
                                dom_id : avatar_id,
                                user_id : user_id,
                                module_id : module_id
                            },
                            lang: StrackLang['Modify_Avatar']
                        },
                        hidden:[
                            {case:101,id:'Nuser_id',type:'hidden',name:'user_id',valid:1,value: user_id},
                            {case:101,id:'Nmodule_id',type:'hidden',name:'module_id',valid:1,value: module_id}
                        ],
                        footer:[
                            {obj:'upload_avatar', type: 5, title: StrackLang['Upload']},
                            {id: 'delete_img', type: 3, title: StrackLang['Clear_Canvas']},
                            {obj:'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                        ]
                    }),
                    inits: function () {
                        //初始化裁切js
                        Strack.js('crop_avatar_js', StrackPHP['JS'] + '/jquery.Jcrop.min.js');
                        //头像上传
                        $('.user-avatar-wrap').hide();
                        Strack.upload_preview({
                            UpBtn: "img_upload",
                            Showpanel: true,
                            Canvas: "canvas_crop_img",
                            Cancel: ['.user-avatar', '.user-avatar-wrap', '#delete_img'],
                            Jcrop: "canvas_crop_tool",
                            Width: 522,
                            Height: 302,
                            MinLimit: 90
                        });
                    },
                    close: function () {
                        Strack.G.Jcrop_Thumb = null;
                        Strack.G.Jcrop_Thumb_Ext = '';
                    }
                });
            }
        );
    },
    // 上传头像
    upload_avatar: function () {
        if (Strack.G.Jcrop_Thumb) {
            var user_id = $('#Nuser_id').val(),
                module_id = $('#Nmodule_id').val(),
                img_data = Strack.G.Jcrop_Canvas.toDataURL("image/png");

            var media_server = Strack.G.Media_Server;
            $.ajax({
                type: 'POST',
                url: media_server['upload_url'],
                dataType: "json",
                data: {
                    token: media_server['token'],
                    size : '90x90',
                    ext : Strack.G.Jcrop_Thumb_Ext,
                    crop: JSON.stringify({
                        x: Strack.G.Jcrop_Thumb.x,
                        y: Strack.G.Jcrop_Thumb.y,
                        w: Strack.G.Jcrop_Thumb.w,
                        h: Strack.G.Jcrop_Thumb.h
                    }),
                    base64Img: img_data
                },
                beforeSend: function () {
                    $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                },
                success: function (data) {
                    if(parseInt(data["status"]) === 200){
                        // 上传成功写入数据库
                        Strack.save_media_data({
                            link_id : user_id,
                            module_id: module_id,
                            media_server: media_server,
                            media_data: data['data'],
                            mode: 'single'
                        }, function (data) {
                            $.messager.progress('close');
                            Strack.dialog_cancel();
                        });
                    }else {
                        // 上传失败获取失败信息
                        $.messager.progress('close');
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });

        } else {
            layer.msg(StrackLang['Please_Select_Image_File'], {icon: 2, time: 1200, anim: 6});
        }
    },
    //修改缩略图
    change_item_media: function (i) {
        var $parent = $(i).closest('.thumb-menu-bnt');
        var link_id = $parent.attr("data-linkid"),
            module_id = $parent.attr("data-moduleid");

        Strack.open_change_item_media({title: StrackLang['Modify_Thumb'], link_id:link_id, module_id:module_id, mode: "single", from: 'widget', field_type: 'built_in', variable_id: 0});
    },
    // 上传Onset附件
    upload_onset_att: function(i)
    {
        var from = $(i).attr("data-from"),
            module_id = $(i).attr("data-moduleid");
        var link_id = $(i).attr("data-linkid");
        Strack.open_change_item_media({title: StrackLang['Upload_Onset_Reference'], link_id:link_id, module_id:module_id, mode: "multiple", from: 'onset' , field_type: 'built_in', variable_id: 0});
    },
    // 加载onset附件
    load_onset_attachment: function(id, onset_param)
    {
        $.ajax({
            type: 'POST',
            url: StrackPHP['getOnsetAttachment'],
            contentType: "application/json",
            data: JSON.stringify(onset_param),
            dataType: 'json',
            beforeSend: function () {
                $('.onset-wrap-right').prepend(Strack.loading_dom('white', '', 'onset_att'));
            },
            success: function (data) {
                if(data["has_media"] === "yes"){
                    Strack.generate_media_list_dom(id, data)
                }else {
                    $(id).html('<div class="datagrid-empty-no">'+StrackLang["Please_Upload_Onset_Reference"]+'</div>');
                }
                $('#st-load_onset_att').remove();
            }
        });
    },
    // 表格工具栏打开水平关联添加面板
    create_horizontal_relationship: function(i)
    {
        var $grid_toolbar = $(i).closest(".grid-toolbar");
        var $this = $(i);
        var param = {
            project_id : $grid_toolbar.data("projectid"),
            grid_id : $grid_toolbar.data("grid"),
            variable_id : $this.attr("variableid"),
            src_module_id : $this.attr("srcmoduleid"),
            dst_module_id : $this.attr("dstmoduleid"),
            src_link_id : $this.attr("srclinkid"),
            horizontal_type : $this.attr("horizontaltype"),
            link_data: [],
            from : 'toolbar'
        };

        console.log(param);

        Strack.open_h_relationship_dialog(param);
    },
    // 打开水平关联表格对话框
    open_h_relationship_dialog: function(param)
    {
        Strack.open_dialog('dialog',{
            title: StrackLang["Horizontal_Relationship"],
            width: 1200,
            height: 600,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mdst_module_id',type:'hidden',name:'temp_id',valid:1,value: param['dst_module_id']},
                    {case:101,id:'Mgrid_id',type:'hidden',name:'id_field',valid:1,value: param['grid_id']},
                    {case:101,id:'Msrc_link_id',type:'hidden',name:'category',valid:1,value:param['src_link_id']},
                    {case:101,id:'Msrc_module_id',type:'hidden',name:'category',valid:1,value:param['src_module_id']},
                    {case:101,id:'Mlink_ids',type:'hidden',name:'module_code',valid:1,value: param['link_data'].join(",")}
                ],
                items:[
                    {case:12,id:'',type:'text',lang:'',name:'',valid:'',value:0}
                ],
                footer:[
                    {obj:'update_h_relate_set', type:5, title:StrackLang['Update']},
                    {obj:'dialog_cancel', type:8, title:StrackLang['Cancel']}
                ]
            }),
            inits:function(){

                var $datagrid = $('#h_relationship_src');

                $datagrid.datagrid({
                    url: StrackPHP["getHRelationDestData"],
                    width:540,
                    height:460,
                    fitColumns:true,
                    DragSelect: true,
                    frozenColumns:[[
                        {field: 'id', checkbox:true}
                    ]],
                    columns:[[
                        {field: 'show_id', title: StrackLang['ID'], align: 'center', width: 80,  formatter: function(value,row,index) {
                                return row["id"];
                            }
                        },
                        {field: 'name', title: StrackLang['Name'], align: 'center', width: 160},
                        {field: 'code', title: StrackLang['Code'], align: 'center', width: 160}
                    ]],
                    queryParams: {
                        filter_data: JSON.stringify(param),
                        selected_ids : JSON.stringify(param["link_data"]),
                        search_val : '',
                        mode: 'all'
                    },
                    pagination: true,
                    pageNumber: 1,
                    pageSize: 300,
                    pageList: [300, 500, 1000, 2000],
                    pagePosition: 'bottom',
                    pageLayout:["list", "prev", "sep", "manual", "sep", "next", "refresh"]
                });


                $('#h_relationship_search').searchbox({
                    searcher:function(value){
                        $datagrid.datagrid("reload",  {
                            filter_data: JSON.stringify(param),
                            search_val : value,
                            mode: 'all'
                        });
                    },
                    height: 28,
                    width: 540,
                    buttonRightVal: 2,
                    buttonRadius: false,
                    prompt: StrackLang["Search_More"]
                });

                $('#h_relationship_dst').datagrid({
                    url: StrackPHP["getHRelationDestData"],
                    width:540,
                    height:488,
                    fitColumns:true,
                    DragSelect: true,
                    frozenColumns:[[
                        {field: 'id', checkbox:true}
                    ]],
                    columns:[[
                        {field: 'show_id', title: StrackLang['ID'], align: 'center', width: 80,  formatter: function(value,row,index) {
                                return row["id"];
                            }
                        },
                        {field: 'name', title: StrackLang['Name'], align: 'center', width: 160},
                        {field: 'code', title: StrackLang['Code'], align: 'center', width: 160}
                    ]],
                    queryParams: {
                        filter_data: JSON.stringify(param),
                        selected_ids : JSON.stringify(param["link_data"]),
                        search_val : '',
                        mode: 'selected'
                    },
                    pagination: true,
                    pageNumber: 1,
                    pageSize: 300,
                    pageList: [300, 500, 1000, 2000],
                    pagePosition: 'bottom',
                    pageLayout:["list", "prev", "sep", "manual", "sep", "next", "refresh"]
                });
            },
            close: function () {
                $("#"+param.grid_id).datagrid("reload");
            }
        });
    },
    // 选择需要水平关联的数据移入右边面板
    move_to_h_relation_panel: function()
    {
        var $src_grid = $('#h_relationship_src'),
            $dst_grid = $('#h_relationship_dst');
        var rows = $src_grid.datagrid('getSelections');
        if (rows.length < 1) {
            layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
        } else {
            var index = 0;
            var c_ids = [];
            var options = $src_grid.datagrid("options");
            var selected_ids = JSON.parse(options.queryParams.selected_ids);


            rows.forEach(function (val) {
                index = $src_grid.datagrid("getRowIndex", val);
                if($.inArray(val["id"], selected_ids) === -1){
                    Strack.G.horizontalRelationIds["add"].push(val["id"]);
                }
                c_ids.push(val["id"]);
                $src_grid.datagrid("deleteRow", index);
                $dst_grid.datagrid("appendRow", val);
            });

            // 重新判断需要删除的ids
            var new_del_ids = [];
            Strack.G.horizontalRelationIds["delete"].forEach(function (id) {
                if($.inArray(id, c_ids) === -1){
                    new_del_ids.push(id);
                }
            });
            Strack.G.horizontalRelationIds["delete"] = new_del_ids;
        }
    },
    // 删除选择的关联
    remove_h_relate_set: function()
    {
        var $src_grid = $('#h_relationship_src'),
            $dst_grid = $('#h_relationship_dst');

        var rows = $dst_grid.datagrid('getSelections');

        if (rows.length < 1) {
            layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
        } else {
            var options = $src_grid.datagrid("options");
            var filter = JSON.parse(options.queryParams.filter_data);
            var selected_ids = JSON.parse(options.queryParams.selected_ids);

            var index = 0;
            var c_del_ids = [];
            rows.forEach(function (val) {
                if($.inArray(val["id"], selected_ids) >= 0){
                    Strack.G.horizontalRelationIds["delete"].push(val["id"]);
                }
                c_del_ids.push(val["id"]);
                index = $dst_grid.datagrid("getRowIndex", val);
                $dst_grid.datagrid("deleteRow", index);
            });

            // 重新判断需要添加的ids
            var new_add_ids = [];
            Strack.G.horizontalRelationIds["add"].forEach(function (id) {
                if($.inArray(id, c_del_ids) === -1){
                    new_add_ids.push(id);
                }
            });
            Strack.G.horizontalRelationIds["add"] = new_add_ids;

            filter["link_data"] = [];
            var s_rows = $dst_grid.datagrid('getRows');

            s_rows.forEach(function (val) {
                filter["link_data"].push(val["id"]);
            });

            options.queryParams.filter_data = JSON.stringify(filter);

            $src_grid.datagrid("reload", options.queryParams);
        }
    },
    // 提交保存关联
    update_h_relate_set: function()
    {
        var $dst_grid = $('#h_relationship_dst');
        var options = $dst_grid.datagrid("options");
        var filter = JSON.parse(options.queryParams.filter_data);

        if (Strack.G.horizontalRelationIds["add"].length < 1 && Strack.G.horizontalRelationIds["delete"].length < 1) {
            layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
        } else {
            // 提交后台处理
            $.ajax({
                type : 'POST',
                url : StrackPHP['modifyHRelationDestData'],
                data : JSON.stringify({
                    param : filter,
                    up_data : Strack.G.horizontalRelationIds
                }),
                dataType : 'json',
                contentType: "application/json",
                beforeSend : function () {
                    $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
                },
                success : function (data) {
                    $.messager.progress('close');
                    Strack.G.horizontalRelationIds = {"add":[], "delete":[]};
                    if(parseInt(data['status']) === 200){
                        Strack.top_message({bg:'g',msg: data['message']});
                        Strack.dialog_cancel();
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        }
    },
    // 一对多关联面板
    open_has_many_dialog: function(param)
    {
        Strack.open_dialog('dialog',{
            title: StrackLang["Has_Many_Relation"],
            width: 1200,
            height: 600,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mdst_module_id',type:'hidden',name:'temp_id',valid:1,value: param['dst_module_id']},
                    {case:101,id:'Mgrid_id',type:'hidden',name:'id_field',valid:1,value: param['grid_id']},
                    {case:101,id:'Msrc_link_id',type:'hidden',name:'category',valid:1,value:param['src_link_id']},
                    {case:101,id:'Msrc_module_id',type:'hidden',name:'category',valid:1,value:param['src_module_id']},
                    {case:101,id:'Mfield_module',type:'hidden',name:'category',valid:1,value:param['field_module']},
                    {case:101,id:'Mfield_table',type:'hidden',name:'category',valid:1,value:param['field_table']},
                    {case:101,id:'Mlink_ids',type:'hidden',name:'module_code',valid:1,value: param['link_data'].join(",")}
                ],
                items:[
                    {case:12,id:'',type:'text',lang:'',name:'',valid:'',value:0}
                ],
                footer:[
                    {obj:'update_has_many_set', type:5, title:StrackLang['Update']},
                    {obj:'dialog_cancel', type:8, title:StrackLang['Cancel']}
                ]
            }),
            inits:function(){

                var $datagrid = $('#h_relationship_src');

                $datagrid.datagrid({
                    url: StrackPHP["getHasManyRelationData"],
                    width:540,
                    height:460,
                    fitColumns:true,
                    ctrlSelect: true,
                    DragSelect: true,
                    frozenColumns:[[
                        {field: 'id', checkbox:true}
                    ]],
                    columns:[[
                        {field: 'show_id', title: StrackLang['ID'], align: 'center', width: 80,  formatter: function(value,row,index) {
                                return row["id"];
                            }
                        },
                        {field: 'name', title: StrackLang['Name'], align: 'center', width: 160},
                        {field: 'code', title: StrackLang['Code'], align: 'center', width: 160}
                    ]],
                    queryParams: {
                        filter_data: JSON.stringify(param),
                        selected_ids : JSON.stringify(param["link_data"]),
                        search_val : '',
                        mode: 'all'
                    },
                    pagination: true,
                    pageNumber: 1,
                    pageSize: 300,
                    pageList: [300, 500, 1000, 2000],
                    pagePosition: 'bottom',
                    pageLayout:["list", "prev", "sep", "manual", "sep", "next", "refresh"]
                });


                $('#h_relationship_search').searchbox({
                    searcher:function(value){
                        $datagrid.datagrid("reload",  {
                            filter_data: JSON.stringify(param),
                            selected_ids : JSON.stringify(param["link_data"]),
                            search_val : value,
                            mode: 'all'
                        });
                    },
                    height: 28,
                    width: 540,
                    buttonRightVal: 2,
                    buttonRadius: false,
                    prompt: StrackLang["Search_More"]
                });

                $('#h_relationship_dst').datagrid({
                    url: StrackPHP["getHasManyRelationData"],
                    width:540,
                    height:488,
                    fitColumns:true,
                    DragSelect: true,
                    frozenColumns:[[
                        {field: 'id', checkbox:true}
                    ]],
                    columns:[[
                        {field: 'show_id', title: StrackLang['ID'], align: 'center', width: 80,  formatter: function(value,row,index) {
                                return row["id"];
                            }
                        },
                        {field: 'name', title: StrackLang['Name'], align: 'center', width: 160},
                        {field: 'code', title: StrackLang['Code'], align: 'center', width: 160}
                    ]],
                    queryParams: {
                        filter_data: JSON.stringify(param),
                        selected_ids : JSON.stringify(param["link_data"]),
                        search_val : '',
                        mode: 'selected'
                    },
                    pagination: true,
                    pageNumber: 1,
                    pageSize: 300,
                    pageList: [300, 500, 1000, 2000],
                    pagePosition: 'bottom',
                    pageLayout:["list", "prev", "sep", "manual", "sep", "next", "refresh"]
                });
            },
            close: function () {
                $("#"+param.grid_id).datagrid("reload");
            }
        });
    },
    // 提交保存一对多关联
    update_has_many_set: function()
    {
        var $dst_grid = $('#h_relationship_dst');
        var options = $dst_grid.datagrid("options");
        var filter = JSON.parse(options.queryParams.filter_data);

        if (Strack.G.horizontalRelationIds["add"].length < 1 && Strack.G.horizontalRelationIds["delete"].length < 1) {
            layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
        } else {
            // 提交后台处理
            $.ajax({
                type : 'POST',
                url : StrackPHP['modifyHasManyRelationData'],
                data : JSON.stringify({
                    param : filter,
                    up_data : Strack.G.horizontalRelationIds
                }),
                dataType : 'json',
                contentType: "application/json",
                beforeSend : function () {
                    $.messager.progress({ title:StrackLang['Waiting'], msg:StrackLang['loading']});
                },
                success : function (data) {
                    $.messager.progress('close');
                    Strack.G.horizontalRelationIds = {"add":[], "delete":[]};
                    if(parseInt(data['status']) === 200){
                        Strack.top_message({bg:'g',msg: data['message']});
                        Strack.dialog_cancel();
                    }else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                }
            });
        }
    },
    // 生成多媒体文件列表dom
    generate_media_list_dom: function(id, data)
    {
        var main_random_id = 'main_'+Math.floor(Math.random() * 10000 + 1);
        $(id).empty().append(Strack.show_note_img_att(main_random_id, data));
        Strack.init_thumb_media(main_random_id);
    },
    // 打开媒体缩略图上传对话框
    open_change_item_media: function(param , callback){
        var queueSizeLimit = 1;
        var dg_h = 240;
        var queue_dom_id = 11;
        var multi = false;
        if(param.mode === "multiple"){
            queueSizeLimit = 0;
            dg_h = 380;
            queue_dom_id = 9;
            multi = true;
        }
        Strack.get_media_server(
            function (media_server) {
                Strack.open_dialog('dialog', {
                    title: param.title,
                    width: 480,
                    height: dg_h,
                    content: Strack.dialog_dom({
                        type: 'normal',
                        hidden: [
                            {case: 101, id: 'Mlink_id', type: 'hidden', name: 'link_id', valid: 1, value: param.link_id},
                            {case: 101, id: 'Mmode', type: 'hidden', name: 'mode', valid: 1, value: param.mode},
                            {case: 101, id: 'Mmodule_id', type: 'hidden', name: 'module_id', valid: 1, value: param.module_id},
                            {case: 101, id: 'Mfield_type', type: 'hidden', name: 'field_type', valid: 1, value: param.field_type},
                            {case: 101, id: 'Mvariable_id', type: 'hidden', name: 'variable_id', valid: 1, value: param.variable_id}
                        ],
                        items: [
                            {case: queue_dom_id, id: 'Mmedia_queue', type: 'text', lang: StrackLang['Media_Attachment'], name: 'media_queue', valid: 0, value: ''}
                        ],
                        footer: [
                            {obj: 'choice_media', type: 6, title: ''},
                            {obj: 'upload_item_thumb', type: 5, title: StrackLang['Update']},
                            {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                        ]
                    }),
                    inits: function () {
                        $('#choice_media').uploadifive({
                            'auto': false,
                            'formData': {
                                timestamp: Strack.current_time(),
                                token: media_server['token'],
                                size : '250x140'
                            },
                            'multi': multi,
                            'queueSizeLimit': queueSizeLimit,
                            'queueID': 'queue',
                            'uploadScript': media_server["upload_url"],
                            'onUpload': function (file) {
                                if (file == 0) {
                                    layer.msg(StrackLang["Please_Select_File"], {icon: 2, time: 1200, anim: 6});
                                } else {
                                    $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                                }
                            },
                            'onUploadComplete': function (file, data) {
                                var resJson = JSON.parse(data);
                                if (parseInt(resJson['status']) === 200) {
                                    // 上传成功写入数据库
                                    var widget_param = {};
                                    if(param.from === "grid"){
                                        widget_param = {
                                            type : 'grid',
                                            index : param.index,
                                            dom : param.td_dom.attr("id"),
                                            editor: 'media'
                                        };
                                    }
                                    Strack.save_media_data({
                                        link_id : param.link_id,
                                        mode: param.mode,
                                        field_type: param.field_type,
                                        variable_id: param.variable_id,
                                        module_id: param.module_id,
                                        media_server: media_server,
                                        media_data: resJson['data'],
                                        widget_param: widget_param
                                    }, function (res_data) {
                                        if(!multi) {
                                            $.messager.progress('close');
                                            Strack.dialog_cancel();
                                            if(param.from === "grid" && !Strack.Websocket.List.hasOwnProperty("update")){
                                                res_data.data.status = 200;
                                                Strack.update.widget(res_data.data, widget_param);
                                            }
                                        }
                                    });
                                    if(callback && !multi){
                                        callback(data);
                                    }
                                } else {
                                    layer.msg(resJson['message'], {icon: 7, time: 1200, anim: 6});
                                }
                            },
                            'onQueueComplete': function () {
                                if(multi){
                                    $.messager.progress('close');
                                    Strack.dialog_cancel();
                                }
                            }
                        });
                    }
                });
            }
        );
    },
    // 上传缩略图媒体
    upload_item_thumb: function () {
        var queueLength = $('.uploadifive-queue-item').length;
        if (queueLength > 0) {
            $('#choice_media').uploadifive('upload');
        } else {
            layer.msg(StrackLang["Please_Select_File"], {icon: 2, time: 1200, anim: 6});
        }
    },
    // 清除缩略图
    clear_item_thumb: function (i) {
        var $parent = $(i).closest('.thumb-menu-bnt');
        var link_id = $parent.attr("data-linkid"),
            module_id = $parent.attr("data-moduleid");

        Strack.submit_clear_item_thumb({
            link_id: link_id,
            module_id: module_id,
            mode: 'single'
        });
    },
    // 提交处理删除缩略图
    submit_clear_item_thumb: function(param, callback)
    {
        $.ajax({
            type: 'POST',
            url: StrackPHP['clearMediaThumbnail'],
            dataType: "json",
            data: param,
            beforeSend: function () {
                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
            },
            success: function (data) {
                $.messager.progress("close");
                if(parseInt(data['status']) === 200){
                    Strack.dialog_cancel();
                    Strack.top_message({bg:'g',msg: data['message']});
                    if(callback){
                        callback();
                    }
                }else {
                    layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                }
            }
        });
    },
    // 表格批量新增缩略图
    grid_change_item_thumb: function(i)
    {
        var grid = $(i).data("grid");
        var module_id = $(i).data("moduleid");
        console.log(grid);
        console.log(module_id);
        var rows = $('#' + grid).datagrid('getSelections');
        if (rows.length > 0) {
            var ids = [];
            rows.forEach(function (val) {
                ids.push(val['id']);
            });
            Strack.open_change_item_media({title: StrackLang['Modify_Thumb'], link_id:ids.join(","), module_id:module_id, mode: "batch", from: 'batch', field_type: 'built_in', variable_id: 0}, function f() {
                $('#' + grid).datagrid('reload');
            });
        } else {
            layer.msg(StrackLang['Please_Select_Grid_One'], {icon: 2, time: 1200, anim: 6});
        }
    },
    // 表格批量清除缩略图
    grid_clear_item_thumb: function(i)
    {
        var grid = $(i).data("grid");
        var module_id = $(i).data("moduleid");
        var rows = $('#' + grid).datagrid('getSelections');
        if (rows.length > 0) {
            var ids = [];
            rows.forEach(function (val) {
                ids.push(val['id']);
            });
            Strack.submit_clear_item_thumb({
                link_id: ids.join(","),
                module_id: module_id,
                mode: 'batch'
            }, function () {
                $('#' + grid).datagrid('reload');
            });
        } else {
            layer.msg(StrackLang['Please_Select_Grid_One'], {icon: 2, time: 1200, anim: 6});
        }
    },
    //左侧导航隐藏文字
    toggle_media_menu: function (i, status) {
        var $left_panel = $(".st-menu-left");
        var $right_panel = $(".st-menu-right");
        var page = $(i).data("page");
        var c_status = '';
        if(status){
            c_status = status;
            switch (status) {
                case "show":
                    $left_panel.css({"width": "240px"});
                    $right_panel.css({"left": "241px"});
                    $left_panel.removeClass("st-m-hide");
                    break;
                case "hide":
                    $left_panel.css({"width": "60px"});
                    $right_panel.css({"left": "61px"});
                    $left_panel.addClass("st-m-hide");
                    break;
            }
        }else {
            if ($left_panel.hasClass("st-m-hide")) {
                c_status = "show";
                $left_panel.css({"width": "240px"});
                $right_panel.css({"left": "241px"});
                $left_panel.removeClass("st-m-hide");
            } else {
                c_status = "hide";
                $left_panel.css({"width": "60px"});
                $right_panel.css({"left": "61px"});
                $left_panel.addClass("st-m-hide");
            }
        }
        Strack.save_storage(page, c_status);
    },
    //切换过滤面板
    toggle_filter: function (i) {
        var maindom = $(i).attr("data-maindom"),
            bardom = $(i).attr("data-bardom");
        Strack.do_toggle_filter(i, bardom, maindom, '');
    },
    //应用过滤面板显示隐藏
    apply_toggle_filter: function (bardom, maindom, mode) {
        var filter_icon = $('#' + maindom).find(".search-filter-button");
        Strack.do_toggle_filter(filter_icon[0], bardom, maindom, mode);
    },
    //执行过滤面板显示隐藏
    do_toggle_filter: function (i, bardom, maindom, mode) {
        var $filter_main = $("#" + bardom),
            $datagrid_main = $("#" + maindom);

        if ($(i).find(".icon-uniF141").length > 0 && mode !== "show") {
            $(i).html('<i class="icon-uniF142"></i>');
            $filter_main.removeClass("filter-full-active")
                .addClass("filter-full-hide")
                .css({
                    width: 0
                });
            $datagrid_main.css("width", "100%");
        } else {
            $(i).html('<i class="icon-uniF141"></i>');
            $filter_main.removeClass("filter-full-hide")
                .addClass("filter-full-active");
            if ($filter_main.hasClass("filter-min")) {
                $datagrid_main.css("width", "calc(100% - 200px)");
                $filter_main.css({
                    width: 200
                });
            } else {
                $datagrid_main.css("width", "calc(100% - 380px)");
                $filter_main.css({
                    width: 380
                });
            }
        }
    },
    toggle_filter_field: function (i) {
        var bardom = $(i).attr("data-bardom");
        var offset = $(i).offset();
        var top_h = 0;
        if($(".globel-top-notice").length > 0){
            top_h = offset.top -6;
        }else {
            top_h = offset.top + 30
        }
        $("#search_list_" + bardom).css({
            top: top_h,
            left: offset.left
        }).show();
    },
    toggle_filter_main: function (i) {
        var $parent = $(i).closest('.datagrid-filter');
        var maindom = $parent.attr("data-maindom"),
            bardom = $parent.attr("data-bardom");
        var $filter_main = $("#" + bardom),
            $datagrid_main = $("#" + maindom),
            $label = $filter_main.find(".filter-label-list");
        if ($(i).find(".icon-uniE94E").length > 0) {
            $(i).html('<i class="icon-uniE957"></i>');
            $filter_main.removeClass('filter-min').css({
                width: 380
            });
            $label.addClass('filter-lable-hide');
            $datagrid_main.css("width", "calc(100% - 380px)");
        } else {
            $(i).html('<i class="icon-uniE94E"></i>');
            $filter_main.addClass('filter-min').css({
                width: 200
            });
            $label.removeClass('filter-lable-hide');
            $datagrid_main.css("width", "calc(100% - 200px)");
        }
    },
    //显示filter字段列表
    show_filter_filter: function (i) {
        $(i).closest(".grid-filter-right")
            .find(".filter-task-list")
            .toggle();
    },
    //新增或者取消过滤项
    toggle_filter_item: function (i) {
        var $this = $(i);
        var $pright = $this.closest(".grid-filter-right");
        var from = $this.attr("from");

        var param = {
            field: $this.attr("field"),
            project_id: $this.attr("project_id"),
            module_id: $this.attr("module_id"),
            field_type: $this.attr("field_type"),
            variable_id: $this.attr("variable_id"),
            module: $this.attr("module_code"),
            editor: $this.attr("editor"),
            lang: $this.attr("lang"),
            table: $this.attr("table"),
            belong: $this.attr("belong"),
            value_show: $this.attr("value_show"),
            flg_module: $this.attr("flg_module"),
            data_source: $this.attr("data_source"),
            frozen_module: $this.attr("frozen_module")
        };

        switch (from) {
            case "bar":
                if (!$this.hasClass("item-active")) {
                    $this.addClass("item-active")
                        .find("i")
                        .removeClass("icon-unchecked")
                        .addClass("icon-checked");
                    Strack.filter_item_base($pright, param);
                    var $no_filter = $pright.find('.no-filter-task');
                    if ($no_filter.length > 0) {
                        $no_filter.remove();
                    }
                } else {
                    var p = $this.closest(".grid-filter-right");
                    Strack.destroy_filter_item(p, param.field, param.module);
                }
                break;
            case "search":
                var $pdom = $this.closest(".filter-task-list");
                var maindom = $pdom.attr("data-maindom");
                if (!$this.hasClass("item-active")) {
                    $this.addClass("item-active")
                        .find("i")
                        .removeClass("icon-unchecked")
                        .addClass("icon-checked");
                    $("#" + maindom).find(".search-filter-field").addClass("search-bar-active");
                } else {
                    $this.removeClass("item-active")
                        .find("i")
                        .removeClass("icon-checked")
                        .addClass("icon-unchecked");
                    var no_checked = true;
                    $pdom.find(".field-item").each(function () {
                        if ($(this).find("i").hasClass("icon-checked")) {
                            no_checked = false;
                        }
                    });
                    if (no_checked) {
                        $("#" + maindom).find(".search-filter-field").removeClass("search-bar-active");
                    }
                }
                break;
        }
    },
    //清除搜索框数据
    clear_searchbox: function (maindom, bardom) {
        var $grid_search = $("#" + maindom).find("#grid_search");
        $grid_search.searchbox("clear");
        $("#search_list_" + bardom).find(".field-item").each(function () {
            if ($(this).find("i").hasClass("icon-checked")) {
                Strack.toggle_filter_item(this);
            }
        });
    },
    //删除当前filter item项
    delete_filter_item: function (i) {
        var $this = $(i);
        var field = $this.closest(".filter-items").attr("field"),
            module = $this.closest(".filter-items").attr("module");
        var p = $this.closest(".grid-filter-right");
        Strack.destroy_filter_item(p, field, module);
    },
    //删除filter item项
    destroy_filter_item: function (p, field, module) {
        $("#fitem_" + module + '_' + field).remove();
        p.find(".filter-task-list .item-active").each(function () {
            if ($(this).attr("field") == field && $(this).attr("module_code") == module) {
                $(this).removeClass("item-active")
                    .find("i")
                    .removeClass("icon-checked")
                    .addClass("icon-unchecked");
            }
        });
        if (p.find(".filter-items").length == 0) {
            p.find(".filter-task-panel").html('<div class="no-filter-task">' + StrackLang["No_Filter_Item"] + '</div>');
        }
    },
    //删除过滤条件
    filter_item_delete: function (i) {
        var filter_id = $(i).attr("filter_id");
        var $filter = $(i).closest(".datagrid-filter");
        var bardom = $filter.attr("data-bardom"),
            maindom = $filter.attr("data-maindom");
        if (filter_id) {
            var dg = $("#" + maindom).find(".datagrid-table");
            $.ajax({
                type: 'POST',
                url: StrackPHP['deleteFilter'],
                dataType: 'json',
                data: {
                    id: filter_id
                },
                beforeSend: function () {
                    dg.datagrid("loading");
                },
                success: function (data) {
                    Strack.top_message({bg: 'g', msg: data['message']});
                    dg.datagrid("loaded").datagrid("reloadFilterTags");
                }
            });
        }
    },
    //置顶或者取消过滤条件
    filter_item_stick: function (i) {
        var filter_id = $(i).attr("filter_id");
        var stick = $(i).attr("stick") == "yes" ? "no" : "yes";
        var $filter = $(i).closest(".datagrid-filter");
        var bardom = $filter.attr("data-bardom"),
            maindom = $filter.attr("data-maindom");
        if (filter_id) {
            var dg = $("#" + maindom).find(".datagrid-table");
            $.ajax({
                type: 'POST',
                url: StrackPHP['stickFilter'],
                dataType: 'json',
                data: {
                    filter_id: filter_id,
                    stick: stick
                },
                beforeSend: function () {
                    dg.datagrid("loading");
                },
                success: function (data) {
                    Strack.top_message({bg: 'g', msg: data['message']});
                    dg.datagrid("loaded").datagrid("reloadFilterTags");
                }
            });
        }
    },
    //保存过滤条件
    save_filter_condition: function (i) {
        var $unsaved = $(i).closest(".datagrid-filter")
            .find(".unsaved-filter-item");
        if ($unsaved.is(":hidden")) {
            layer.msg(StrackLang["No_Filter_Need_Save"], {icon: 2, time: 1200, anim: 6});
        } else {
            var save_bnt = $unsaved.find(".fbar-save-bnt");
            Strack.save_active_filter(save_bnt[0]);
        }
    },
    //保存当前激活的
    save_active_filter: function (i) {
        var $filter = $(i).closest(".datagrid-filter");
        var bardom = $filter.attr("data-bardom"),
            maindom = $filter.attr("data-maindom"),
            page = $filter.attr("data-page"),
            project_id = $filter.attr("data-projectid"),
            module_type = $filter.attr("data-moduletype"),
            module_code = $filter.attr("data-modulecode");

        var $unsaved = $("#" + bardom).find(".unsaved-filter-item");
        var from = $unsaved.attr("data-from");
        var dg = $("#" + maindom).find(".datagrid-table");
        var options = $(dg).datagrid("options");
        var filter = JSON.parse(options.queryParams.filter_data);
        if (filter) {
            //打开保存过滤条件设置面板
            Strack.open_dialog('dialog', {
                title: StrackLang['Save_Filter'],
                width: 480,
                height: 360,
                content: Strack.dialog_dom({
                    type: 'normal',
                    hidden: [
                        {case: 101, id: 'Mproject_id', type: 'hidden', name: 'project_id', valid: 1, value: project_id},
                        {case: 101, id: 'Mpage', type: 'hidden', name: 'page', valid: 1, value: page},
                        {
                            case: 101,
                            id: 'Mmodule_type',
                            type: 'hidden',
                            name: 'module_type',
                            valid: 1,
                            value: module_type
                        },
                        {
                            case: 101,
                            id: 'Mmodule_code',
                            type: 'hidden',
                            name: 'module_code',
                            valid: 1,
                            value: module_code
                        },
                        {case: 101, id: 'Mfilter', type: 'hidden', name: 'filter', valid: 1, value: ""},
                        {case: 101, id: 'Mgrid', type: 'hidden', name: 'grid', valid: 1, value: dg.attr("id")}
                    ],
                    items: [
                        {
                            case: 1,
                            id: 'Mfilter_name',
                            type: 'text',
                            lang: StrackLang['Name'],
                            name: 'name',
                            valid: '1,64',
                            value: ""
                        },
                        {case: 2, id: 'Mfilter_color', lang: StrackLang['Color'], name: 'color', valid: '1', value: ""},
                        {case: 2, id: 'Mfilter_stick', lang: StrackLang['Stick'], name: 'stick', valid: '1'},
                        {case: 2, id: 'Mfilter_public', lang: StrackLang['Public'], name: 'public', valid: '1'}
                    ],
                    footer: [
                        {obj: 'do_save_active_filter', type: 5, title: StrackLang['Submit']},
                        {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                    ]
                }),
                inits: function () {
                    $("#Mfilter").val(JSON.stringify(filter));

                    Strack.combobox_widget('#Mfilter_color', {
                        url: StrackPHP["getFilterColorList"],
                        valueField: 'id',
                        textField: 'name',
                        value: 'grey',
                        formatter: function (row) {
                            return '<div class="combo-icons-warp" style="overflow: hidden"><div class="ui ' + row.id + ' label filter-tag-label"></div><div class="combo-name">' + row.name + '</div></div>';
                        }
                    });

                    Strack.combobox_widget('#Mfilter_stick', {
                        url: StrackPHP["getStickType"],
                        valueField: 'id',
                        textField: 'name',
                        value: 'no'
                    });

                    Strack.combobox_widget('#Mfilter_public', {
                        url: StrackPHP["getPublicType"],
                        valueField: 'id',
                        textField: 'name',
                        value: 'yes'
                    });
                }
            });
        }
    },
    //执行保存过滤操作
    do_save_active_filter: function () {
        var grid = $("#Mgrid").val(),
            $grid = $("#" + grid);
        Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', StrackPHP['saveFilter'], {
            back: function (data) {
                Strack.top_message({bg: 'g', msg: data['message']});
                $grid.datagrid("reloadFilterTags", data.data);
                $grid.datagrid("highlightViewSave");
                Strack.dialog_cancel();
            }
        });
    },
    //删除未保存过滤
    delete_unsave_filter: function (i) {
        var $fitem = $(i).closest(".filter-tag-item");
        if ($fitem.hasClass("filter-tag-ac")) {
            Strack.reset_filter_default(i);
        } else {
            var $filter = $(i).closest(".datagrid-filter");
            var bardom = $filter.attr("data-bardom");
            $("#" + bardom).find(".unsaved-filter-item").hide();
        }
    },
    //filter恢复默认设置
    reset_filter_default: function (i) {
        var $filter = $(i).closest(".datagrid-filter");
        var bardom = $filter.attr("data-bardom"),
            maindom = $filter.attr("data-maindom");
        Strack.do_reset_filter(maindom, bardom, true);
    },
    //执行重置filter过滤
    do_reset_filter: function (maindom, bardom, reload) {
        if (reload) {
            var dg = $("#" + maindom).find(".datagrid-table"),
                $grid = $(dg);
            $grid.datagrid("setFilterParams", {
                filter_input: [],
                filter_panel: [],
                filter_advance: []
            }).datagrid("reload");

            $grid.datagrid("highlightViewSave");
        }

        var $bardom = $("#" + bardom);

        var $unsaved = $bardom.find(".unsaved-filter-item");
        $unsaved.hide();

        //清除过滤条件选中
        $bardom.find(".filter-tag-item").removeClass("filter-tag-ac");

        var from = $unsaved.attr("data-from");
        //清除浏览器缓存
        Strack.clear_filter_cache(bardom);
        switch (from) {
            case "filter_input":
                Strack.clear_searchbox(maindom, bardom);
                break;
        }
    },
    //获取当前过滤缓存
    get_filter_cache: function (bardom, from) {
        var filter_json = Strack.read_storage("grid_filter_" + bardom);
        if (filter_json) {
            var filter_data = JSON.parse(filter_json);
            if (filter_data["from"] == from) {
                return filter_data["data"];
            } else {
                return null;
            }
        } else {
            return null;
        }
    },
    //保存当前过滤缓存
    save_filter_cache: function (bardom, from, data) {
        Strack.save_storage("grid_filter_" + bardom, JSON.stringify({from: from, data: data}));
    },
    //清除当前过滤缓存
    clear_filter_cache: function (bardom) {
        Strack.delete_storage("grid_filter_" + bardom);
    },
    //filter item项 DOM
    filter_item_base: function (p, param) {
        var dom = '';
        var id = 'fitem_' + param["module"] + '_' + param["field"];
        dom += '<div id="' + id + '" class="filter-items" field="' + param["field"] + '" field_type="' + param["field_type"] + '" variable_id="' + param["variable_id"] + '" editor="' + param["editor"] + '" module="' + param["module"] + '" table="' + param["table"] + '" >' +
            '<div class="filter-ilabel">' +
            '<label class="aign-left"><strong>' + param["lang"] + '</strong><span class="text-faded"> ( ' + param["belong"] + ' ) </span></label>' +
            '<a href="javascript:;" class="pfilter-delete aign-right" onclick="Strack.delete_filter_item(this)"><i class="icon-uniE6DB"></i></a>' +
            '</div>' +
            "<div class='p-filter-inpt filter-input-wrap'>" +
            Strack.filter_item_widget(param["editor"], param) +
            '</div>' +
            '</div>';
        p.find(".filter-task-panel").append(dom);
        //初始化控件
        Strack.init_filter_item("#" + id, param["editor"], param);
        Strack.init_filter_event(p);
        return dom;
    },
    //初始化控件item
    init_filter_item: function (id, type, param) {
        switch (type) {
            case "tagbox":
            case "horizontal_relationship":
            case "relation":
            case "combobox":
            case "checkbox":
                var comb = ($(id).find(".in-combobox"))[0];
                var comb_multiple = $.inArray(type, ["tagbox", "combobox", "horizontal_relationship"]) >=0 ? true : false;
                Strack.combobox_widget(comb, {
                    url: StrackPHP["getWidgetData"],
                    valueField: 'id',
                    textField: 'name',
                    width: 279,
                    height: 28,
                    multiple: comb_multiple,
                    queryParams: {
                        type: type,
                        fields: param.value_show,
                        field_type: param.field_type,
                        variable_id: param.variable_id,
                        project_id: param.project_id,
                        module_id: param.module_id,
                        module: param.module,
                        primary: 0,
                        flg_module: param.flg_module,
                        frozen_module: param.frozen_module,
                        data_source: param.data_source
                    },
                    formatter: function (row) {
                        switch (param["fields"]) {
                            case "assignee":
                            case "created_by":
                                return Strack.build_comb_avatar(row);
                                break;
                            default:
                                return row["name"];
                                break;
                        }
                    },
                    onLoadSuccess: function () {
                    },
                    onChange: function (newValue, oldValue) {
                        Strack.filter_auto(this);
                    }
                });
                break;
            case "text":
            case "textarea":
                var exp = ($(id).find(".term-list"))[0];
                //$(id).find(".input-text").val();
                Strack.combobox_widget(exp, {
                    data: Strack.filter_express(['EQ', 'NEQ', "LIKE", "NOTLIKE"]),
                    valueField: 'id',
                    textField: 'name',
                    height: 28,
                    onChange: function (newValue, oldValue) {
                        var ptype = $(this).data("ptype"),
                            filter = $(this).data("filter");
                        Strack.filter_auto(this);
                    }
                });
                break;
            case "datebox":
            case "datetimebox":
                var $date_ck = $(id).find(".in-date-term"),
                    $date_range_ck = $(id).find(".in-date-range"),
                    $date_input = $(id).find(".data-input-wrap");
                //date check box
                $date_ck.on("click", function () {
                    $date_range_ck.attr("checked", false);
                    if ($date_ck.is(':checked')) {
                        $date_input.empty().append(Strack.filter_item_widget("date_term", param));
                        Strack.init_filter_item($date_input, "date_term", param);
                    } else {
                        $date_input.empty();
                    }
                });
                //Date_Range cheack box
                $date_range_ck.on("click", function () {
                    $date_ck.attr("checked", false);
                    if ($date_range_ck.is(':checked')) {
                        $date_input.empty().append(Strack.filter_item_widget("date_range", param));
                        Strack.init_filter_item($date_input, "date_range", param);
                    } else {
                        $date_input.empty();
                    }
                });
                break;
            case "date_term":
                var term_list = id.find(".term-list"),
                    term_date = id.find(".term-date");
                Strack.combobox_widget(term_list[0], {
                    data: Strack.filter_express(['EQ', 'NEQ', 'GT', 'EGT', 'LT', 'ELT']),
                    valueField: 'id',
                    textField: 'name',
                    height: 28,
                    onChange: function (newValue, oldValue) {
                        var ptype = $(this).data("ptype"),
                            filter = $(this).data("filter");
                        Strack.filter_auto(this);
                    }
                });

                Strack.filter_date_box(term_date[0], '', 28, '', false, 8);
                break;
            case "date_range":
                var start_date = id.find(".start-date"),
                    end_date = id.find(".end-date");
                Strack.filter_date_box(start_date[0], '', 28, '', false, 8);
                Strack.filter_date_box(end_date[0], '', 28, '', false, 8);
                break;
        }
    },
    //Filter 过滤方法
    filter_express: function (list) {
        var express = [];
        list.forEach(function (exp) {
            express.push(Strack.express_item(exp));
        });
        return express;
    },
    //Filter 表达式
    express_item: function (exp) {
        switch (exp) {
            case 'EQ':
                return {id: 'EQ', name: StrackLang["Exp_EQ"]};
            case 'NEQ':
                return {id: "NEQ", name: StrackLang["Exp_NEQ"]};
            case "GT":
                return {id: "GT", name: StrackLang["Exp_GT"]};
            case "EGT":
                return {id: "EGT", name: StrackLang["Exp_EGT"]};
            case "LT":
                return {id: "LT", name: StrackLang["Exp_LT"]};
            case "ELT":
                return {id: "ELT", name: StrackLang["Exp_ELT"]};
            case "LIKE":
                return {id: "LIKE", name: StrackLang["Exp_LIKE"]};
            case "NOTLIKE":
                return {id: "NOTLIKE", name: StrackLang["Exp_NOTLIKE"]};
            case "BETWEEN":
                return {id: "BETWEEN", name: StrackLang["Exp_BETWEEN"]};
            case "NOT BETWEEN":
                return {id: "NOT BETWEEN", name: StrackLang["Exp_NOT_BETWEEN"]};
            case "IN":
                return {id: "IN", name: StrackLang["Exp_IN"]};
            case "NOT IN":
                return {id: "NOT IN", name: StrackLang["Exp_NOT_IN"]};
        }
    },
    //filter 控件 DOM
    filter_item_widget: function (type, param) {
        var dom = '';
        switch (type) {
            case "combobox":
            case "tagbox":
            case "horizontal_relationship":
            case "relation":
            case "checkbox":
                dom += '<input class="in-combobox" />';
                break;
            case "text":
            case "textarea":
                dom += '<div  class="pf-widget-term aign-left"><input class="term-list" /></div>' +
                    '<div  class="pf-widget-input aign-left"><input class="input-text" type="text" /></div>';
                break;
            case "datebox":
            case "datetimebox":
                dom = "<div class='pf-widget-date'>" +
                    '<div class="widget-date-item">' +
                    '<div class="aign-left"><input type="checkbox" class="in-date-term"></div>' +
                    '<div class="widget-date-name aign-left">' + StrackLang["Date"] + '</div>' +
                    '</div>' +
                    '<div class="widget-date-item">' +
                    '<div class="aign-left"><input type="checkbox" class="in-date-range"></div>' +
                    '<div class="widget-date-name aign-left">' + StrackLang["Date_Range"] + '</div>' +
                    '</div>' +
                    '<div class="p-filter-inpt data-input-wrap">' +
                    '</div>' +
                    '</div>';
                break;
            case "date_term":
                dom = '<div class="pf-widget-term aign-left"><input class="term-list"></div>' +
                    '<div class="pf-widget-input aign-left"><input class="term-date"></div>';
                break;
            case "date_range":
                dom = '<div class="pf-widget-even aign-left interval-right-10"><input class="start-date"></div>' +
                    '<div class="pf-widget-even aign-left"><input class="end-date"></div>';
                break;
        }
        return dom;
    },
    //过滤面板保持设置
    stick_filter_bar: function (i) {
        var page = $(i).closest('.datagrid-filter').attr("data-page");
        var $title = $(i).find("span"),
            stick = '';
        if ($(i).hasClass("stick-on")) {
            $title.html(StrackLang["Keep_Display"]);
            $(i).removeClass("stick-on");
            stick = 'no';
        } else {
            $title.html(StrackLang["Cancel_Keep"]);
            $(i).addClass("stick-on");
            stick = 'yes';
        }
        $.ajax({
            type: 'POST',
            url: StrackPHP["saveUserFilterKeepConfig"],
            data: {
                stick: stick,
                page: page
            },
            dataType: 'json',
            beforeSend: function () {
                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
            },
            success: function (data) {
                $.messager.progress('close');
                Strack.top_message({bg: 'g', msg: data['message']});
            }
        });
    },
    //获取逻辑列表
    get_logic_list: function () {
        return [
            {id: 'and', name: 'and'},
            {id: 'or', name: 'or'}
        ];
    },
    //高级filter编辑设置
    open_advance_filter: function (i) {
        var $filter = $(i).closest(".datagrid-filter");

        var module_id = $filter.attr("data-moduleid"),
            maindom = $filter.attr("data-maindom"),
            bardom = $filter.attr("data-bardom"),
            project_id = $filter.attr("data-projectid"),
            page = $filter.attr("data-page"),
            schema_page = $filter.attr("data-schemapage");

        Strack.dialog_cancel();
        Strack.open_dialog('dialog', {
            title: StrackLang["Advanced_Filter"],
            width: 620,
            height: 440,
            content: Strack.dialog_dom({
                type: 'adv_filter',
                hidden: [
                    {case: 101, id: 'Fmodule_id', type: 'hidden', name: 'module_id', valid: 1, value: module_id},
                    {case: 101, id: 'Fpage', type: 'hidden', name: 'page', valid: 1, value: page},
                    {case: 101, id: 'Fschema_page', type: 'hidden', name: 'page', valid: 1, value: schema_page},
                    {case: 101, id: 'Fmaindom', type: 'hidden', name: 'maindom', valid: 1, value: maindom},
                    {case: 101, id: 'Fbardom', type: 'hidden', name: 'maindom', valid: 1, value: bardom},
                    {case: 101, id: 'Fproject_id', type: 'hidden', name: 'project_id', valid: 1, value: project_id},
                ],
                footer: [
                    {obj: 'do_advance_filter', type: 5, title: StrackLang['Submit']},
                    {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                ]
            }),
            inits: function () {
                Strack.combobox_widget('#logic_comb', {
                    data: Strack.get_logic_list(),
                    valueField: 'id',
                    textField: 'name',
                    width: 70,
                    height: 26,
                    value: 'and'
                });

                //判断是否存在高级过滤设置
                Strack.init_advance_filter(bardom);
            }
        });
    },
    //初始化高级过滤历史项
    init_advance_filter: function (bardom) {
        var filter_data = Strack.get_filter_cache(bardom, 'filter_advance'),
            key_deny = ["logic", "multiple", "number"];
        if (filter_data) {

            if (parseInt(filter_data["number"]) > 1) {
                var gid = "";
                Strack.init_advance_group(filter_data["number"], 'multiple');
                $('.dgcb-query-group').each(function (index) {
                    for (var key in filter_data[index]) {
                        if ($.inArray(key, key_deny) < 0) {
                            Strack.init_advance_item(this, filter_data[index][key], 'multiple');
                        }
                    }
                    gid = $(this).find(".advh_logic").attr("id");
                    $('#' + gid).combobox("setValue", filter_data[index]["logic"]);
                });
                $('#logic_comb').combobox("setValue", filter_data["logic"]);
            } else {
                Strack.init_advance_group(filter_data["number"], 'single');
                $('.dgcb-query-group').each(function () {
                    for (var key in filter_data) {
                        if ($.inArray(key, key_deny) < 0) {
                            Strack.init_advance_item(this, filter_data[key], 'single');
                        }
                    }
                });
                $('#logic_comb').combobox("setValue", filter_data["logic"]);
            }
        }
    },
    //生成高级过滤项组
    init_advance_group: function (num) {
        for (var i = 0; i < num; i++) {
            Strack.add_filter_group("");
        }
    },
    //生成高级过滤项
    init_advance_item: function (i, data, multiple) {
        var trid = "group_" + Math.floor(Math.random() * 1000 + 1),
            $group = $(i).closest(".dgcb-query-group"),
            page = $('#Fpage').val(),
            schema_page = $('#Fschema_page').val(),
            project_id = $('#Fproject_id').val(),
            module_id = $('#Fmodule_id').val(),
            express = null;

        switch (data["editor"]) {
            case "text":
            case "textarea":
                express = ['EQ', 'NEQ', "LIKE", "NOTLIKE"];
                break;
            case "tagbox":
            case "horizontal_relationship":
            case "relation":
            case "combobox":
            case "checkbox":
                express = ['EQ', "IN", "NOT IN"];
                break;
            case "datebox":
            case "datetimebox":
                express = ['EQ', 'NEQ', "GT", "EGT", "LT", "ELT", "BETWEEN"];
                break;
        }
        $group.find(".dgcb-query-cond").append(Strack.adv_filter_group_dom(trid));

        $("#condth_" + trid).attr("data-field", data["field"])
            .attr("data-fieldtype", data["field_type"])
            .attr("data-variableid", data["variable_id"])
            .attr("data-editor", data["editor"])
            .attr("data-module", data["module_code"])
            .attr("data-moduletype", data["module_type"])
            .attr("data-frozenmodule", data["frozen_module"])
            .attr("data-multiple", multiple)
            .attr("data-table", data["table"]);

        //数据初始化
        Strack.combobox_widget('#Fds_' + trid, {
            url: StrackPHP["getAdvanceFilterFields"],
            valueField: 'id',
            textField: 'lang',
            width: 120,
            height: 25,
            value: data["module_code"] + '.' + data["field"],
            groupField: "belong",
            queryParams: {
                module_id: module_id,
                page: page,
                schema_page: schema_page,
                project_id: project_id
            },
            onSelect: function (record) {
                var $parent = $(this).closest(".dgcb-cond-item"),
                    logic_id = $parent.find(".cond_lgoic").attr("id"),
                    cond_in = $parent.find(".cond-entity-in"),
                    val_id = $parent.find(".cond_value").attr("id");
                $parent
                    .attr("data-field", record["fields"])
                    .attr("data-fieldtype", record["field_type"])
                    .attr("data-variableid", record["variable_id"])
                    .attr("data-editor", record["editor"])
                    .attr("data-moduleid", record["module_id"])
                    .attr("data-modulecode", record["module_code"])
                    .attr("data-datasource", record["data_source"])
                    .attr("data-module", record["module"])
                    .attr("data-moduletype", record["module_type"])
                    .attr("data-frozenmodule", record["frozen_module"])
                    .attr("data-valueshow", record["value_show"])
                    .attr("data-multiple", "single")
                    .attr("data-table", record["table"]);

                Strack.init_adv_filter_cond(logic_id, val_id, cond_in, record);
            }
        });

        //赋值
        var $item_parent = $('#Fds_' + trid).closest(".dgcb-cond-item");
        $item_parent
            .attr("data-field", data["fields"])
            .attr("data-fieldtype", data["field_type"])
            .attr("data-variableid", data["variable_id"])
            .attr("data-editor", data["editor"])
            .attr("data-moduleid", data["module_id"])
            .attr("data-modulecode", data["module_code"])
            .attr("data-datasource", data["data_source"])
            .attr("data-module", data["module"])
            .attr("data-moduletype", data["module_type"])
            .attr("data-valueshow", data["value_show"])
            .attr("data-frozenmodule", data["frozen_module"])
            .attr("data-multiple", "single")
            .attr("data-table", data["table"]);

        Strack.combobox_widget('#Fls_' + trid, {
            data: Strack.filter_express(express),
            valueField: 'id',
            textField: 'name',
            width: 120,
            height: 25,
            value: data["condition"],
            onSelect: function (record) {
                var drid = "date_" + Math.floor(Math.random() * 1000 + 1),
                    $parent = $(this).closest(".dgcb-cond-item"),
                    editor = $parent.attr("data-editor"),
                    cond_in = $parent.find(".cond-entity-in"),
                    val_id = $parent.find(".cond_value").attr("id"),
                    fdom = '';

                switch (record["id"]) {
                    case "IN":
                    case "NOT IN":
                        $('#' + val_id).combobox("setOptions", {
                            "multiple": true,
                            "value": ""
                        }).combobox("reload");
                        $parent.attr("data-multiple", "multiple");
                        break;
                    case "BETWEEN":
                        fdom = '<input id="' + val_id + '" class="cond_value" style="width: 180px;display: none">' +
                            '<div class="cond-v-start aign-left"><input id="Fdis_' + drid + '" class="condv_sdate cond_v_date" style="width: 90px;"></div>' +
                            '<div class="cond-v-end aign-left"><input id="Fdie_' + drid + '" class="condv_edate cond_v_date" style="width: 90px;"></div>';
                        cond_in.empty().append(fdom);
                        Strack.filter_date_box('#Fdis_' + drid, '', 25, "", false, 8);
                        Strack.filter_date_box('#Fdie_' + drid, '', 25, "", false, 8);
                        break;
                    default:
                        switch (editor) {
                            case "combobox":
                            case "tagbox":
                            case "checkbox":
                            case "horizontal_relationship":
                            case "relation":
                                $('#' + val_id).combobox("setOptions", {
                                    "multiple": false,
                                    "value": ""
                                }).combobox("reload");
                                $parent.attr("data-multiple", "single");
                                break;
                            case "datebox":
                            case "datetimebox":
                                cond_in.empty().append('<input id="' + val_id + '" class="cond_value" style="width: 180px">');
                                Strack.filter_date_box('#' + val_id, '', 25, "", false, 8);
                                break;
                        }
                        break;
                }
            }
        });

        switch (data["editor"]) {
            case "text":
            case "textarea":
                $('#Fvs_' + trid).val(data["value"]);
                break;
            case "tagbox":
            case "horizontal_relationship":
            case "relation":
            case "combobox":
            case "checkbox":
                var comb_val = "", multip = false;
                if (data["condition"] === 'EQ') {
                    comb_val = data["value"];
                } else {
                    multip = true;
                    comb_val = data["value"].split(",");
                }

                Strack.combobox_widget('#Fvs_' + trid, {
                    url: StrackPHP["getWidgetData"],
                    valueField: 'id',
                    textField: 'name',
                    height: 25,
                    value: comb_val,
                    queryParams: {
                        primary: 0,
                        project_id: project_id,
                        module: data['module'],
                        module_type: data['module_type'],
                        field_type: data['field_type'],
                        variable_id: data['variable_id'],
                        fields: data['value_show'],
                        module_id: data['module_id'],
                        data_source: data['data_source'],
                        flg_module: data['flg_module'],
                        frozen_module: data['frozen_module']
                    },
                    multiple: multip
                });

                break;
            case "datebox":
            case "datetimebox":
                if (data["condition"] === 'BETWEEN') {
                    var date_id = "date_" + Math.floor(Math.random() * 1000 + 1),
                        fddom = '';
                    var cval_arr = data["value"].split(",");
                    fddom = '<input id="Fvs_' + trid + '" class="cond_value" style="width: 180px;display: none">' +
                        '<div class="cond-v-start aign-left"><input id="Fdis_' + date_id + '" class="condv_sdate cond_v_date" style="width: 90px;"></div>' +
                        '<div class="cond-v-end aign-left"><input id="Fdie_' + date_id + '" class="condv_edate cond_v_date" style="width: 90px;"></div>';
                    $("#condth_" + trid).find(".cond-entity-in").empty().append(fddom);
                    Strack.filter_date_box('#Fdis_' + date_id, "", 25, cval_arr[0], false, 8);
                    Strack.filter_date_box('#Fdie_' + date_id, "", 25, cval_arr[1], false, 8);
                } else {
                    Strack.filter_date_box('#Fvs_' + trid, '', 25, data["value"], false, 8);
                }
                break;
        }
    },
    //添加高级过滤项
    do_advance_filter: function () {
        var maindom = $("#Fmaindom").val(),
            bardom = $("#Fbardom").val();
        var adv_data = Strack.scan_advance_filter();
        var dg = $("#" + maindom).find(".datagrid-table");
        if (!$.isEmptyObject(adv_data["adv_filter"])) {
            $(dg).datagrid("setFilterParams", {
                filter_input: [],
                filter_panel: [],
                filter_advance: adv_data["adv_filter"]
            }).datagrid("reload");

            Strack.save_filter_cache(bardom, "filter_advance", adv_data["adv_filter"]);
            Strack.show_nosaved_filter(bardom, 'filter_advance', StrackLang["Advanced_Filter"]);
            Strack.dialog_cancel();
        }
    },
    //显示未保存过滤项
    show_nosaved_filter: function (bardom, from, name) {
        var $bardom = $("#" + bardom);
        var $unsaved = $bardom.find(".unsaved-filter-item");
        $bardom.find(".exist-filter-item .filter-tag-item").removeClass("filter-tag-ac");
        $unsaved.find(".filter-tag-item").addClass("filter-tag-ac");
        $unsaved.attr("data-from", from)
            .find(".filter-tag-name").html(name);
        $unsaved.show();
    },
    //组装Advanced Filters data
    scan_advance_filter: function (avd_type) {
        var adv_group = $('#dg_adv_filter').find(".dgcb-query-group");
        var item_num = $('.dgcb-query-group').length;
        var adv_filter = {}, logic_n = '', zindex = 0, go_on = true;

        switch (adv_group.length) {
            case 0:
                if (avd_type != 20) {
                    layer.msg(StrackLang['Advanced_Filter_Group_Null'], {icon: 2, time: 1200, anim: 6});
                }
                break;
            case 1:
                //只有一个group
                logic_n = Strack.get_combos_val('#logic_comb', 'combobox', 'getValue');
                if (logic_n) {
                    adv_group.each(function () {
                        var $item = $(this).find(".dgcb-cond-item"), itemp = null, aindex = 0;
                        $item.each(function () {
                            itemp = Strack.get_adv_fd_item(this);
                            if (itemp) {
                                adv_filter[aindex] = itemp;
                                aindex++;
                            } else {
                                adv_filter = {};
                                layer.msg(StrackLang['Advanced_Filter_Full_Null'], {icon: 2, time: 1200, anim: 6});
                                go_on = false;
                                return false;
                            }
                        });
                    });
                    if (!$.isEmptyObject(adv_filter)) {
                        adv_filter["logic"] = logic_n;
                        adv_filter["number"] = item_num;
                    }
                } else {
                    layer.msg(StrackLang['Advanced_Filter_Logic_Null'], {icon: 2, time: 1200, anim: 6});
                    go_on = false;
                }
                break;
            default:
                logic_n = Strack.get_combos_val('#logic_comb', 'combobox', 'getValue');
                if (logic_n) {
                    adv_group.each(function () {
                        var $item = $(this).find(".dgcb-cond-item"), itemp = null, hgarr = {}, aindex = 0;
                        var $hlogic = $(this).find('.advh_logic').attr("id");
                        var hlogic = Strack.get_combos_val('#' + $hlogic, 'combobox', 'getValue');
                        $item.each(function () {
                            itemp = Strack.get_adv_fd_item(this);
                            if (itemp) {
                                hgarr[aindex] = itemp;
                                aindex++;
                            } else {
                                hgarr = {};
                                return false;
                            }
                        });
                        if (!$.isEmptyObject(hgarr)) {
                            hgarr["logic"] = hlogic;
                            adv_filter[zindex] = hgarr;
                            zindex++;
                        } else {
                            adv_filter = {};
                            layer.msg(StrackLang['Advanced_Filter_Full_Null'], {icon: 2, time: 1200, anim: 6});
                            go_on = false;
                            return false;
                        }
                    });
                    if (!$.isEmptyObject(adv_filter)) {
                        adv_filter["logic"] = logic_n;
                        adv_filter["number"] = item_num;
                    }
                } else {
                    layer.msg(StrackLang['Advanced_Filter_Logic_Null'], {icon: 2, time: 1200, anim: 6});
                    go_on = false;
                }
                break;
        }
        return {adv_filter: adv_filter, go_on: go_on, item_num: item_num};
    },
    //获得高级过滤每行数据
    get_adv_fd_item: function (i) {
        var editor = $(i).attr("data-editor"),
            field = $(i).attr("data-field"),
            field_type = $(i).attr("data-fieldtype"),
            module = $(i).attr("data-module"),
            module_id = $(i).attr("data-moduleid"),
            module_code = $(i).attr("data-modulecode"),
            frozen_module = $(i).attr("data-frozenmodule"),
            module_type = $(i).attr("data-moduletype"),
            variable_id = $(i).attr("data-fieldtype") == "built_in" ? 0 : $(i).attr("data-variableid"),
            value_show = $(i).attr("data-valueshow"),
            data_source = $(i).attr("data-datasource"),
            multiple = $(i).attr("data-multiple"),
            table = $(i).attr("data-table"),
            $fd = $(i).find(".cond_field").attr("id"),
            $flg = $(i).find(".cond_lgoic").attr("id"),
            $fval = $(i).find(".cond_value").attr("id"),
            fdarr = {},
            cval = "";

        var field_id = Strack.get_combos_val('#' + $fd, 'combobox', 'getValue'),
            logic = Strack.get_combos_val('#' + $flg, 'combobox', 'getValue');

        if (editor) {
            switch (editor) {
                case "tagbox":
                case "horizontal_relationship":
                case "relation":
                case "combobox"://combobox
                case "checkbox":
                    switch (multiple) {
                        case "single":
                            cval = Strack.get_combos_val('#' + $fval, 'combobox', 'getValue');
                            break;
                        case "multiple":
                            var cval_arr = Strack.get_combos_val('#' + $fval, 'combobox', 'getValues');
                            cval = cval_arr.join(",");
                            break;
                    }
                    break;
                case "text"://text
                    cval = $(i).find(".cond_value").val();
                    break;
                case "datebox"://date 有两种情况
                case "datetimebox":
                    switch (logic) {
                        case "BETWEEN":
                            var $dstart = $(i).find(".condv_sdate").attr("id"),
                                $dend = $(i).find(".condv_edate").attr("id");
                            var ctarr = [], cstart = "", cend = "";
                            cstart = $('#' + $dstart).datebox("getValue");
                            cend = $('#' + $dend).datebox("getValue");
                            if (cstart && cend) {
                                ctarr.push(cstart);
                                ctarr.push(cend);
                                cval = ctarr.join(",")
                            } else {
                                cval = "";
                            }
                            break;
                        default:
                            cval = $('#' + $fval).datebox("getValue");
                            break;
                    }
                    break;
            }


            if (field_id && logic && cval) {
                $(i).find(".cond-entity-en").empty().append(Strack.dialog_error_icon("t"));
                fdarr = {
                    field: field,
                    field_type: field_type,
                    variable_id: variable_id,
                    module: module,
                    module_id: module_id,
                    module_type: module_type,
                    module_code: module_code,
                    value_show: value_show,
                    table: table,
                    condition: logic,
                    data_source: data_source,
                    frozen_module: frozen_module,
                    value: cval,
                    editor: editor,
                    multiple: multiple
                };
                return fdarr;
            } else {
                $(i).find(".cond-entity-en").empty().append(Strack.dialog_error_icon("e"));
                return false;
            }
        } else {
            $(i).find(".cond-entity-en").empty().append(Strack.dialog_error_icon("e"));
            return false;
        }
    },
    //添加过滤项组
    add_filter_group: function (i) {
        var gid = "group_" + Math.floor(Math.random() * 1000 + 1),
            $adv_wrap = $('#dg_adv_filter'),
            h_css = "display-hide";
        $adv_wrap.append(Strack.filter_group_dom(gid, h_css));
        Strack.combobox_widget('#' + gid, {
            data: Strack.get_logic_list(),
            valueField: 'id',
            textField: 'name',
            width: 70,
            height: 26,
            value: 'and'
        });
        Strack.toggle_filter_group();
    },
    //过滤项Group DOM
    filter_group_dom: function (rid, ohide) {
        var fdom = '';
        fdom += '<div class="dgcb-query-group">' +
            '<div class="dgcb-query-hd">' +
            '<div class="dgcb-item-log aign-left ' + ohide + '">' +
            '<div class="query-all-name aign-left">' + StrackLang["ConditionalLogic"] + '</div>' +
            '<div class="query-all-input aign-left"><input id="' + rid + '" class="advh_logic" style="width: 53px;"></div>' +
            '</div>' +
            '<div class="dgcb-item-btn aign-left">' +
            '<a href="javascript:;" onclick="Strack.add_adv_filter_item(this)" class="query-all-btn aign-left"><i class="icon-uniEA33"></i>' + StrackLang["AddFilterItem"] + '</a>' +
            '</div>' +
            '<div class="dgcb-item-btn aign-right">' +
            '<a href="javascript:;" onclick="Strack.delete_filter_group(this)" class="query-all-btn aign-left"><i class="icon-uniE6DB"></i></a>' +
            '</div>' +
            '</div>' +
            '<div class="dgcb-query-cond">' +
            '</div>' +
            '</div>';
        return fdom;
    },
    //过滤项Group item DOM
    adv_filter_group_dom: function (trid) {
        var dom = '';
        dom += '<div id="condth_' + trid + '" class="dgcb-cond-item">' +
            '<div class="cond-entity-fd aign-left"><input id="Fds_' + trid + '" class="cond_field" style="width: 120px;"></div>' +
            '<div class="cond-entity-lg aign-left"><input id="Fls_' + trid + '" class="cond_lgoic" style="width: 120px;"></div>' +
            '<div class="cond-entity-in aign-left"><input id="Fvs_' + trid + '" class="cond_value" style="width: 180px;" ></div>' +
            '<a href="javascript:;" onclick="Strack.delete_filter_cond(this)" class="cond-entity-de aign-left"><i class="icon-uniEA34"></i></a>' +
            '<div class="cond-entity-en aign-left"></div>' +
            '</div>';
        return dom;
    },
    //添加过滤项 条件
    add_adv_filter_item: function (i) {
        var trid = "group_" + Math.floor(Math.random() * 1000 + 1),
            $pgroup = $(i).closest(".dgcb-query-group"),
            express = ['EQ', 'NEQ', 'GT', 'EGT', 'LT', 'ELT'];

        var module_id = $('#Fmodule_id').val(),
            module_code = $('#Fmodule_code').val(),
            project_id = $('#Fproject_id').val(),
            page = $('#Fpage').val(),
            schema_page = $('#Fschema_page').val();

        $pgroup.find(".dgcb-query-cond").append(Strack.adv_filter_group_dom(trid));

        Strack.combobox_widget('#Fds_' + trid, {
            url: StrackPHP["getAdvanceFilterFields"],
            valueField: 'id',
            textField: 'lang',
            width: 120,
            height: 25,
            groupField: "belong",
            queryParams: {
                module_id: module_id,
                project_id: project_id,
                page: page,
                schema_page: schema_page
            },
            onSelect: function (record) {
                var $parent = $(this).closest(".dgcb-cond-item"),
                    logic_id = $parent.find(".cond_lgoic").attr("id"),
                    cond_in = $parent.find(".cond-entity-in"),
                    val_id = $parent.find(".cond_value").attr("id");
                $parent
                    .attr("data-field", record["fields"])
                    .attr("data-fieldtype", record["field_type"])
                    .attr("data-variableid", record["variable_id"])
                    .attr("data-editor", record["editor"])
                    .attr("data-moduleid", record["module_id"])
                    .attr("data-modulecode", record["module_code"])
                    .attr("data-datasource", record["data_source"])
                    .attr("data-module", record["module_alias"])
                    .attr("data-moduletype", record["module_type"])
                    .attr("data-frozenmodule", record["frozen_module"])
                    .attr("data-valueshow", record["value_show"])
                    .attr("data-multiple", "single")
                    .attr("data-table", record["table"]);

                Strack.init_adv_filter_cond(logic_id, val_id, cond_in, record);
            }
        });

        Strack.combobox_widget('#Fls_' + trid, {
            data: Strack.filter_express(express),
            valueField: 'id',
            textField: 'name',
            width: 120,
            height: 25,
            onSelect: function (record) {
                var drid = "date_" + Math.floor(Math.random() * 1000 + 1),
                    $parent = $(this).closest(".dgcb-cond-item"),
                    editor = $parent.attr("data-editor"),
                    cond_in = $parent.find(".cond-entity-in"),
                    val_id = $parent.find(".cond_value").attr("id"),
                    fdom = '';

                switch (record["id"]) {
                    case "IN":
                    case "NOT IN":
                        $('#' + val_id).combobox("setOptions", {
                            "multiple": true,
                            "value": ""
                        }).combobox("reload");
                        $parent.attr("data-multiple", "multiple");
                        break;
                    case "BETWEEN":
                        fdom = '<input id="' + val_id + '" class="cond_value" style="width: 180px;display: none">' +
                            '<div class="cond-v-start aign-left"><input id="Fdis_' + drid + '" class="condv_sdate cond_v_date" style="width: 90px;"></div>' +
                            '<div class="cond-v-end aign-left"><input id="Fdie_' + drid + '" class="condv_edate cond_v_date" style="width: 90px;"></div>';
                        cond_in.empty().append(fdom);
                        Strack.filter_date_box('#Fdis_' + drid, '', 25, "", false, 8);
                        Strack.filter_date_box('#Fdie_' + drid, '', 25, "", false, 8);
                        break;
                    default:
                        switch (editor) {
                            case "combobox":
                                $('#' + val_id).combobox("setOptions", {
                                    "multiple": false,
                                    "value": ""
                                }).combobox("reload");
                                $parent.attr("data-multiple", "single");
                                break;
                            case "datebox":
                            case "datetimebox":
                                cond_in.empty().append('<input id="' + val_id + '" class="cond_value" style="width: 180px">');
                                Strack.filter_date_box('#' + val_id, '', 25, "", false, 8);
                                break;
                        }
                        break;
                }
            }
        });

    },
    //初始化过滤项类型
    init_adv_filter_cond: function (logic_id, val_id, cond_in, record) {
        var express = null,
            project_id = $("#Fproject_id").val();
        cond_in.empty().append('<input id="' + val_id + '" class="cond_value" style="width: 180px;" >');
        //按类型来初始化过滤选项
        switch (record["editor"]) {
            case "text"://text
            case "textarea":
                express = ['EQ', 'NEQ', "LIKE", "NOTLIKE"];
                break;
            case "tagbox":
            case "horizontal_relationship":
            case "relation":
            case "combobox"://combobox
            case "checkbox":
                express = ['EQ', "IN", "NOT IN"];
                //获取对应数据
                var comb_param =  {
                    url: StrackPHP["getWidgetData"],
                    valueField: 'id',
                    textField: 'name',
                    height: 25,
                    queryParams: {
                        primary: 0,
                        project_id: project_id,
                        module_id: record['module_id'],
                        module: record['module'],
                        module_type: record['module_type'],
                        field_type: record['field_type'],
                        fields: record['value_show'],
                        data_source: record['data_source'],
                        variable_id: record['variable_id'],
                        flg_module: record['flg_module'],
                        frozen_module: record['frozen_module']
                    }
                };
                Strack.combobox_widget('#' + val_id, comb_param);
                break;
            case "datebox"://datebox
            case "datetimebox"://datetimebox
                express = ['EQ', 'NEQ', "GT", "EGT", "LT", "ELT", "BETWEEN"];
                Strack.filter_date_box('#' + val_id, '', 25, "", false, 8);
                break;
        }
        $('#' + logic_id).combobox('loadData', Strack.filter_express(express))
            .combobox("setValue", 'EQ');
    },
    //删除过滤项
    delete_filter_cond: function (i) {
        $(i).closest(".dgcb-cond-item").remove();
    },
    //删除过滤组
    delete_filter_group: function (i) {
        $(i).closest(".dgcb-query-group").remove();
        Strack.toggle_filter_group();
    },
    //隐藏和显示组管理
    toggle_filter_group: function () {
        var $group = $('#dg_adv_filter').find('.dgcb-query-group'),
            $itemlog = $(".dgcb-item-log");
        if ($group.length > 1) {
            $itemlog.removeClass("display-hide");
        } else {
            $itemlog.addClass("display-hide");
        }
    },
    //切换过滤条件
    toggle_ac_filter: function (i) {
        var filter_type = $(i).attr("filter_type"),
            filter_id = $(i).attr("filter_id");
        var $filter = $(i).closest(".datagrid-filter");
        var maindom = $filter.attr("data-maindom");
        var bardom = $filter.attr("data-bardom");
        var dg = $("#" + maindom).find(".datagrid-table");
        $filter.find(".filter-tag-item").removeClass("filter-tag-ac");
        $(i).closest(".filter-tag-item").addClass("filter-tag-ac");

        if (filter_type === "exist") {
            //切换到已经存在的过滤条件
            $.ajax({
                type: 'POST',
                url: StrackPHP["getFilterSingle"],
                data: JSON.stringify({
                    filter_id: filter_id
                }),
                dataType: 'json',
                contentType: "application/json",
                success: function (data) {
                    var opts = dg.datagrid("options");
                    var old_filter = JSON.parse(opts.queryParams.filter_data);

                    old_filter['filter']["filter_advance"] = data['filter']["filter_advance"];
                    old_filter['filter']["filter_input"] = data['filter']["filter_input"];
                    old_filter['filter']["filter_panel"] = data['filter']["filter_panel"];
                    old_filter['filter']["request"] = data['filter']["request"];

                    opts.queryParams.filter_data = JSON.stringify(old_filter);
                    dg.datagrid("setOptions", {
                        queryParams: opts.queryParams
                    }).datagrid("reload");

                    dg.datagrid("highlightViewSave");
                }
            });
        } else {
            //切换到当前未保存过滤条件
            var $unsaved = $(i).closest(".unsaved-filter-item");
            var from = $unsaved.attr("data-from");
            var opts = dg.datagrid("options");
            var opts_filter = JSON.parse(opts.queryParams.filter_data);
            opts_filter[from] = Strack.get_filter_cache(bardom, from);
            opts.queryParams.filter_data = JSON.stringify(opts_filter);

            dg.datagrid("setOptions", {
                queryParams: opts.queryParams
            }).datagrid("reload");
        }
    },
    //工具栏下来菜单点击item
    click_down_item: function (i) {
        var $this = $(i),
            belong = $this.attr("belong"),
            from = $this.attr("from");

        var field_item = {
            field: $this.attr("field"),
            field_type: $this.attr("field_type"),
            module: $this.attr("module"),
            module_code: $this.attr("module_code"),
            module_type: $this.attr("module_type"),
            table: $this.attr("table"),
            value_show: $this.attr("value_show"),
            editor: $this.attr("editor"),
            lang: $this.attr("lang"),
            sort: $this.attr("field_sort"),
            edit: $this.attr("field_edit"),
            belong: belong,
            width: $this.attr("field_width")
        };

        var $main = $(i).closest(".entity-datalist");
        var $grid = $main.find(".datagrid-table");

        //高亮视图保存提示
        $grid.datagrid("highlightViewSave");

        var options = $grid.datagrid("options");
        var field_config = options.columnsFieldConfig;

        //切换选择图标
        var checked = Strack.toggle_item_icon(i, from);
        switch (from) {
            case "show":
                //字段操作
                if (checked) {
                    //增加临时查询字段
                    $grid.datagrid("addQueryFields", field_item)
                        .datagrid("reload");
                } else {
                    //删除临时字段
                    $grid.datagrid("cutQueryFields", field_item)
                        .datagrid("reload");
                }
                break;
            case "group":
                //分组操作
                if (checked) {
                    //应用分组
                    var group_data = Strack.generate_grid_group_data(field_item, field_config);
                    $grid.datagrid("setOptions",
                        {
                            groupActive: true,
                            groupField: field_item.value_show,
                            groupFormatter: function (value, rows) {
                                return '<span class="">' + value + '( ' + rows.length + ' )</span>';
                            }
                        })
                        .datagrid("setFilterParams", {
                            group: group_data
                        })
                        .datagrid("reload");
                } else {
                    //取消分组
                    $grid.datagrid("setOptions", {
                        groupActive: false
                    }).datagrid("setFilterParams", {
                        group: {}
                    }).datagrid("reload");
                }
                break;
            case "sort":
                //排序操作
                var sort_data = {};
                sort_data[field_item["value_show"]] = {
                    type: "asc",
                    field: field_item["field"],
                    field_type: field_item["field_type"],
                    value_show: field_item["value_show"],
                    module_code: field_item["module_code"]
                };
                if (checked) {
                    Strack.sort_grid_icon($grid, sort_data, "single");
                } else {
                    Strack.sort_grid_icon($grid, {}, "single");
                }
                break;
            case "view":
                //切换视图操作
                var $grid_view = $(i).closest(".grid-toolbar");
                var view_id = $(i).attr("view_id"),
                    page = $grid_view.attr("data-page"),
                    project_id = $grid_view.attr("data-projectid");
                Strack.toggle_view(view_id, page, project_id);
                break;
        }
    },
    //切换菜单项选中图标
    toggle_item_icon: function (i, from) {
        var $icon = $(i).find("i");
        var checked = false;
        if ($icon.hasClass("icon-unchecked")) {
            switch (from) {
                case "group":
                    var $g_parent = $(i).closest(".grid_group");
                    $g_parent.find(".group-field i")
                        .removeClass("icon-checked")
                        .addClass("icon-unchecked");
                    $icon.removeClass("icon-unchecked")
                        .addClass("icon-checked");
                    break;
                case "sort":
                    break;
                case "view":
                    var $v_parent = $(i).closest(".grid-toolbar");
                    $v_parent.find(".view-g-item i")
                        .removeClass("icon-checked")
                        .addClass("icon-unchecked");
                    $icon.removeClass("icon-unchecked")
                        .addClass("icon-checked");
                    break;
                case "project_status":
                case "project_time":
                    var options = $(i).attr("options");
                    var $p_parent = $(i).closest("." + from);
                    if (options === "all" || from === "project_time") {
                        $p_parent.find(".view-g-item i")
                            .removeClass("icon-checked")
                            .addClass("icon-unchecked");
                    } else {
                        // 去掉all
                        $($p_parent.find(".view-g-item i")[0]).removeClass("icon-checked")
                            .addClass("icon-unchecked");
                    }
                    $icon.removeClass("icon-unchecked")
                        .addClass("icon-checked");
                    break;
                default:
                    $icon.removeClass("icon-unchecked")
                        .addClass("icon-checked");
                    break;
            }
            checked = true;
        } else {
            switch (from) {
                case "view":
                    break;
                default:
                    $icon.removeClass("icon-checked")
                        .addClass("icon-unchecked");
                    break;
            }
        }
        return checked;
    },
    //生成 grid 分组条件
    generate_grid_group_data: function (field_item, field_config) {
        var group_param = {};
        group_param[field_item["value_show"]] = {
            type: "asc",
            field: field_item["field"],
            field_type: field_item["field_type"],
            value_show: field_item["value_show"],
            module_code: field_item["module_code"]
        };
        return group_param;
    },
    // 获取 grid 分组字段
    get_grid_group_field: function(data)
    {
        var field = '', order = '';
        for(var key in data){
            field = key;
            order = data[key];
        }
        return {"field":field, "order": order};
    },
    //取消分组
    delete_group: function (i) {
        var panel = $(i).attr("data-panel");
        var $g_parent = $(i).closest(".grid_group");
        $g_parent.find(".group-field i")
            .removeClass("icon-checked")
            .addClass("icon-unchecked");
        var $grid = $(i).closest(".entity-datalist").find(".datagrid-table");
        $grid.datagrid("setOptions", {
            groupActive: false
        }).datagrid("setFilterParams", {
            group: []
        }).datagrid("reload");

        $grid.datagrid("highlightViewSave");
    },
    //排序字段
    sort_grid_item: function (i) {
        var grid = $(i).data("grid"),
            field = $(i).data("field"),
            sort = $(i).attr("data-sort"),
            $grid = $('#' + grid);

        var order, sort_data = {};
        switch (sort) {
            case "asc":
                order = "desc";
                break;
            case "desc":
                order = "empty";
                break;
            default:
                order = "asc";
                break;
        }


        if (order !== "empty") {
            var options = $grid.datagrid("options");
            var field_config = options.columnsFieldConfig;

            sort_data[field_config[field]["field_map"]] = {
                type: order,
                field: field_config[field]["fields"],
                field_type: field_config[field]["field_type"],
                value_show: field_config[field]["field_map"],
                module_code: field_config[field]["module_code"]
            };
        }

        $grid.datagrid("highlightViewSave");

        Strack.sort_grid_icon($grid, sort_data, "single");
    },
    //修改排序图标
    sort_grid_icon: function ($grid, sort_data, type) {
        //数据表格图标
        Strack.init_sort_grid_icon($grid, sort_data, type);

        //下拉菜单排序图标修改
        var $grid_sort = $grid.closest(".entity-datalist").find(".grid_sort");
        Strack.init_sort_icon($grid_sort, sort_data, type);

        $grid.datagrid("setOptions", {
            "sortConfig": sort_data
        });

        $grid.datagrid("setFilterParams", {
            sort: sort_data
        }).datagrid("reload");

        if (type === "advance") {
            Strack.dialog_cancel();
        }
    },
    //初始化grid排序按钮
    init_sort_grid_icon: function ($grid, sort_data, type) {
        var field;
        $grid.closest(".datagrid-view")
            .find(".datagrid-sort").each(function () {
            field = $(this).closest("td").attr("field");
            $(this).removeClass("datagrid-sort-desc datagrid-sort-asc")
                .children("a")
                .attr("data-sort", "");

            if (sort_data.hasOwnProperty(field)) {
                if (sort_data[field]["type"] !== "empty") {
                    $(this).addClass("datagrid-sort-" + sort_data[field]["type"])
                        .children("a")
                        .attr("data-sort", sort_data[field]["type"]);
                }
                //给当前点击按钮添加选择状态
                $(this).find("a").attr("data-sort", sort_data[field]["type"]);
            }
        });
    },
    //初始化排序按钮
    init_sort_icon: function ($grid_sort, sort_data, type) {

        Strack.show_sort_down_icon($grid_sort, sort_data, type);

        //下拉菜单字段选择
        var show_field;
        $grid_sort.find(".sort-field").each(function () {
            show_field = $(this).attr("value_show");
            if (sort_data.hasOwnProperty(show_field)) {
                if (sort_data[show_field] !== "empty") {
                    $(this).find("i")
                        .removeClass("icon-unchecked")
                        .addClass("icon-checked");
                } else {
                    $(this).find("i")
                        .removeClass("icon-checked")
                        .addClass("icon-unchecked");
                }
            } else {
                $(this).find("i")
                    .removeClass("icon-checked")
                    .addClass("icon-unchecked");
            }
        });
    },
    init_show_sort_down_icon: function ($grid_sort, sort_data, type) {
        var t_fields = [];
        for (var item in sort_data) {
            t_fields.push(item);
        }
        if (t_fields.length) {
            Strack.show_sort_down_icon($grid_sort, t_fields, sort_data, type);
        }
    },
    show_sort_down_icon: function ($grid_sort, sort_data, type) {
        var sort_name;
        var frist_sort_type = '';
        for(var key in sort_data){
            frist_sort_type = sort_data[key]["type"];
            break;
        }
        $grid_sort.find(".sort-bnt").each(function () {
            sort_name = $(this).attr("data-sort");
            switch (sort_name) {
                case "asc":
                    if (sort_name === frist_sort_type && type === "single") {
                        $(this).removeClass("field-disable");
                    } else {
                        $(this).addClass("field-disable");
                    }
                    break;
                case "desc":
                    if (sort_name === frist_sort_type && type === "single") {
                        $(this).removeClass("field-disable");
                    } else {
                        $(this).addClass("field-disable");
                    }
                    break;
                case "advance":
                    if (type === "advance") {
                        $(this).removeClass("field-disable");
                    } else {
                        $(this).addClass("field-disable");
                    }
                    break;
            }
        });
    },
    //排序下拉菜单
    dropdown_sort: function (i) {
        var order = $(i).attr("data-sort"),
            $grid_sort = $(i).closest(".grid_sort");
        var value_show = '',
            field = '',
            field_type = '',
            module = '',
            module_code = '',
            sort_data = {};

        //查找当前已经存在的字段
        $grid_sort.find(".sort-field").each(function () {
            module = $(this).attr("module");
            if ($(this).find("i").hasClass("icon-checked")) {
                field = $(this).attr("field");
                value_show = $(this).attr("value_show");
                field_type = $(this).attr("field_type");
                module_code = $(this).attr("module_code");
            }
        });

        var $grid = $(i).closest(".entity-datalist").find(".datagrid-table");
        if (value_show.length>0) {
            sort_data[value_show] = {
                type: order,
                field: field,
                field_type: field_type,
                value_show: value_show,
                module_code: module_code
            };
            Strack.sort_grid_icon($grid, sort_data, "single");
        }
    },
    //取消排序
    sort_cancel: function (i) {
        var $grid = $(i).closest(".entity-datalist")
            .find(".datagrid-table");
        $grid.datagrid("setOptions", {"sortConfig": {}});
        Strack.sort_grid_icon($grid, {}, "single");
        $grid.datagrid("highlightViewSave");
    },
    //高级排序设置
    advance_sort: function (i) {
        var $grid_view = $(i).closest(".grid-toolbar");

        var project_id = $grid_view.attr("data-projectid"),
            panel_id = $grid_view.attr("id");
        var grid_id = $grid_view.attr("data-grid"),
            page = $grid_view.attr("data-page"),
            schema_page = $grid_view.attr("data-schemapage"),
            module_id = $grid_view.attr("data-moduleid");

        Strack.open_dialog('dialog', {
            title: StrackLang['Sort_Adv'],
            width: 420,
            height: 320,
            content: Strack.dialog_dom({
                type: 'adv_sort',
                hidden: [
                    {case: 101, id: 'Mpanel_id', type: 'hidden', name: 'panel_id', valid: 1, value: panel_id},
                    {case: 101, id: 'Mgrid', type: 'hidden', name: 'grid', valid: 1, value: grid_id}
                ],
                footer: [
                    {obj: 'do_advance_sort', type: 5, title: StrackLang['Submit']},
                    {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                ]
            }),
            inits: function () {
                Strack.combobox_widget('#sort_first,#sort_second,#sort_third', {
                    url: StrackPHP["getSortFields"],
                    valueField: 'id',
                    textField: 'lang',
                    width: 160,
                    height: 25,
                    groupField: 'belong',
                    queryParams: {
                        project_id: project_id,
                        page: page,
                        schema_page: schema_page,
                        module_id: module_id,
                        field_list_type: ['sort']
                    },
                    onSelect: function (record) {

                    }
                });

                Strack.combobox_widget('#sort_first_func,#sort_second_func,#sort_third_func', {
                    url: StrackPHP["getSortList"],
                    valueField: 'id',
                    textField: 'name',
                    width: 110,
                    height: 25
                });
            }
        });
    },
    //高级过滤方法
    do_advance_sort: function () {
        var grid = $("#Mgrid").val(),
            panel_id = $("#Mpanel_id").val(),
            $grid = $('#' + grid);

        var sort_f1 = Strack.get_combos_val('#sort_first', 'combobox', 'getValue'),
            sort_f2 = Strack.get_combos_val('#sort_second', 'combobox', 'getValue'),
            sort_f3 = Strack.get_combos_val('#sort_third', 'combobox', 'getValue'),
            sort_in1 = Strack.get_combos_val('#sort_first_func', 'combobox', 'getValue'),
            sort_in2 = Strack.get_combos_val('#sort_second_func', 'combobox', 'getValue'),
            sort_in3 = Strack.get_combos_val('#sort_third_func', 'combobox', 'getValue');

        var row_1_val = $('#sort_first').combobox("getRowValue", "id"),
            row_2_val = $('#sort_second').combobox("getRowValue", "id"),
            row_3_val = $('#sort_third').combobox("getRowValue", "id");

        var module_code = "";

        //执行过滤查询
        var options = $grid.datagrid("options");
        var field_config = options.columnsFieldConfig;

        $("#shang_first,#shang_second,#shang_third").find("i").remove();


        var sort_data = {};

        if (!(sort_f1 && sort_in1)) {
            layer.msg(StrackLang['AdvSort_Null'], {icon: 2, time: 1200, anim: 6});
            $("#shang_first").append(Strack.dialog_error_icon("e"));
        } else {
            $("#shang_first").append(Strack.dialog_error_icon("t"));
            sort_data[field_config[row_1_val["value_show"]]["field_map"]] = {
                type: sort_in1,
                field: field_config[row_1_val["value_show"]]["fields"],
                field_type: field_config[row_1_val["value_show"]]["field_type"],
                value_show: field_config[row_1_val["value_show"]]["field_map"],
                module_code: field_config[row_1_val["value_show"]]["module_code"]
            };

            if (sort_f2 && sort_in2) {
                $("#shang_second").append(Strack.dialog_error_icon("t"));
                sort_data[field_config[row_2_val["value_show"]]["field_map"]] = {
                    type: sort_in2,
                    field: field_config[row_2_val["value_show"]]["fields"],
                    field_type: field_config[row_2_val["value_show"]]["field_type"],
                    value_show: field_config[row_2_val["value_show"]]["field_map"],
                    module_code: field_config[row_2_val["value_show"]]["module_code"]
                };
            }
            if (sort_f3 && sort_in3) {
                $("#shang_third").append(Strack.dialog_error_icon("t"));
                sort_data[field_config[row_3_val["value_show"]]["field_map"]] = {
                    type: sort_in3,
                    field: field_config[row_3_val["value_show"]]["fields"],
                    field_type: field_config[row_3_val["value_show"]]["field_type"],
                    value_show: field_config[row_3_val["value_show"]]["field_map"],
                    module_code: field_config[row_3_val["value_show"]]["module_code"]
                };
            }

            Strack.sort_grid_icon($grid, sort_data, "advance");
        }
    },
    //保存视图
    save_view: function (i) {
        var select_view = Strack.select_view_param(i);
        if (select_view["allow_edit"] === "allow") {
            var $grid_view;
            var panel = $(i).attr("data-panel");
            switch (panel) {
                case "grid":
                    $grid_view = $(i).closest(".grid-toolbar");
                    var $grid = $(i).closest(".entity-datalist").find(".datagrid-table");
                    $grid.datagrid("delHighlightViewSave");
                    break;
                case "list":
                    $grid_view = $(i).closest(".list-toolbar");
                    Strack.del_highlight_view_save(i);
                    break;
            }

            var view_type = select_view["view_id"] > 0 ? 'custom' : 'default';

            var param = {
                view_type: view_type,
                panel: panel,
                page: $grid_view.attr("data-page"),
                project_id: $grid_view.attr("data-projectid"),
                maindom: $grid_view.attr("data-maindom"),
                bardom: $grid_view.attr("data-bardom")
            };

            var view_data = Strack.get_view_data(param);

            Strack.submit_save_view(select_view["view_id"], view_data, param);
        } else {
            //当前视图不允许编辑，另存为新的自己所属视图
            Strack.save_as_view(i);
        }
    },
    //保存当前用户所属视图修改
    submit_save_view: function (view_id, view_data, param) {
        var url = param.view_type === "default" ? StrackPHP['saveDefaultView'] : StrackPHP['saveView'];
        $.ajax({
            type: 'POST',
            url: url,
            dataType: "json",
            data: {
                id: view_id,
                page: param['page'],
                project_id: param['project_id'],
                view_data: JSON.stringify(view_data)
            },
            beforeSend: function () {
                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
            },
            success: function (data) {
                $.messager.progress("close");
                Strack.dialog_cancel();
                Strack.top_message({bg: 'g', msg: data['message']});
            }
        });
    },
    //获取当前正在使用视图数据
    select_view_param: function (i) {
        var $grid_view;
        var panel = $(i).attr("data-panel");
        switch (panel) {
            case "grid":
                $grid_view = $(i).closest(".grid-toolbar");
                break;
            case "list":
                $grid_view = $(i).closest(".list-toolbar");
                break;
        }
        var $view_item = $grid_view.find(".view-g-item");
        var select_view = {};
        select_view["project_id"] = $grid_view.attr("data-projectid");
        $view_item.each(function () {
            if ($(this).find("i").hasClass("icon-checked")) {
                select_view["view_id"] = parseInt($(this).attr("view_id"));
                select_view["allow_edit"] = $(this).attr("allow_edit");
            }
        });
        return select_view;
    },
    //视图另存为
    save_as_view: function (i) {
        var $grid_view;
        var panel = $(i).attr("data-panel");
        switch (panel) {
            case "grid":
                $grid_view = $(i).closest(".grid-toolbar");
                break;
            case "list":
                $grid_view = $(i).closest(".list-toolbar");
                break;
        }
        Strack.open_dialog('dialog', {
            title: StrackLang['Save_View'],
            width: 480,
            height: 240,
            content: Strack.dialog_dom({
                type: 'normal',
                hidden: [
                    {case: 101, id: 'Mpanel', type: 'hidden', name: 'panel', valid: 1, value: panel},
                    {
                        case: 101,
                        id: 'Mpage',
                        type: 'hidden',
                        name: 'page',
                        valid: 1,
                        value: $grid_view.attr("data-page")
                    },
                    {
                        case: 101,
                        id: 'Mproject_id',
                        type: 'hidden',
                        name: 'project_id',
                        valid: 1,
                        value: $grid_view.attr("data-projectid")
                    },
                    {
                        case: 101,
                        id: 'Mmaindom',
                        type: 'hidden',
                        name: 'maindom',
                        valid: 1,
                        value: $grid_view.attr("data-maindom")
                    },
                    {
                        case: 101,
                        id: 'Mbardom',
                        type: 'hidden',
                        name: 'bardom',
                        valid: 1,
                        value: $grid_view.attr("data-bardom")
                    }
                ],
                items: [
                    {
                        case: 1,
                        id: 'Mview_name',
                        type: 'text',
                        lang: StrackLang['Name'],
                        name: 'name',
                        valid: '1,128',
                        value: ""
                    },
                    {case: 2, id: 'Mview_public', lang: StrackLang['Public'], name: 'public', valid: '1', value: ""}
                ],
                footer: [
                    {obj: 'submit_save_as_view', type: 5, title: StrackLang['Submit']},
                    {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                ]
            }),
            inits: function () {
                Strack.combobox_widget('#Mview_public', {
                    url: StrackPHP["getPublicType"],
                    valueField: 'id',
                    textField: 'name',
                    value: 'yes'
                });
            }
        });
    },
    submit_save_as_view: function () {
        Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', StrackPHP['saveAsView'], {
            back: function (data) {
                Strack.dialog_cancel();
                Strack.top_message({bg: 'g', msg: data['message']});
                location.reload();
            }
        }, {
            extra: function (data) {
                data.view_data = JSON.stringify(Strack.get_view_data({
                    panel: data.panel,
                    page: data.page,
                    project_id: data.project_id,
                    maindom: data.maindom,
                    bardom: data.bardom
                }));
                return data;
            }
        });
    },
    //修改实体设置
    modify_view: function (i) {
        var $grid_view;
        var panel = $(i).attr("data-panel");
        switch (panel) {
            case "grid":
                $grid_view = $(i).closest(".grid-toolbar");
                break;
            case "list":
                $grid_view = $(i).closest(".list-toolbar");
                break;
        }

        var $ac_item = $grid_view.find(".view-g-active");

        var param = {
            view_id: $ac_item.attr("view_id"),
            view_name: $ac_item.attr("view_name"),
            view_public: $ac_item.attr("view_public"),
            allow_edit: $ac_item.attr("allow_edit")
        };

        if (parseInt(param.view_id) > 0 && param.allow_edit == "allow") {
            Strack.open_dialog('dialog', {
                title: StrackLang['Modify_View_Title'],
                width: 480,
                height: 240,
                content: Strack.dialog_dom({
                    type: 'normal',
                    hidden: [
                        {case: 101, id: 'Mview_id', type: 'hidden', name: 'view_id', valid: 1, value: param.view_id}
                    ],
                    items: [
                        {
                            case: 1,
                            id: 'Mview_name',
                            type: 'text',
                            lang: StrackLang['Name'],
                            name: 'name',
                            valid: '1,128',
                            value: param.view_name
                        },
                        {case: 2, id: 'Mview_public', lang: StrackLang['Public'], name: 'public', valid: '1', value: ""}
                    ],
                    footer: [
                        {obj: 'submit_modify_view', type: 5, title: StrackLang['Submit']},
                        {obj: 'dialog_cancel', type: 8, title: StrackLang['Cancel']}
                    ]
                }),
                inits: function () {
                    Strack.combobox_widget('#Mview_public', {
                        url: StrackPHP["getPublicType"],
                        valueField: 'id',
                        textField: 'name',
                        value: param.view_public
                    });
                }
            });
        } else {
            layer.msg(StrackLang['View_Deny_Modify'], {icon: 2, time: 1200, anim: 6});
        }
    },
    //提交视图修改
    submit_modify_view: function () {
        Strack.ajax_dialog_form('#st_dialog_form .dialog-widget-val', '', StrackPHP['modifyView'], {
            back: function (data) {
                Strack.dialog_cancel();
                Strack.top_message({bg: 'g', msg: data['message']});
                window.location.reload();
            }
        });
    },
    //获取当前视图数据
    get_view_data: function (param) {
        //获取排序设置
        var view_data = {};
        switch (param.panel) {
            case "grid":
                var $grid = $("#" + param.maindom).find(".datagrid-table");
                var opts = $grid.datagrid("options");

                var filter = JSON.parse(opts.queryParams.filter_data);
                var sort_data = opts.sortData;

                view_data["sort"] = {
                    sort_query: filter.filter.sort,
                    sort_data: sort_data
                };

                //获取分组设置
                view_data["group"] = filter.filter.group;

                //获取字段设置
                var field_list = [];

                if (opts.frozenColumns.length > 1) {
                    //第一层 index = 0 冻结字段 全是 colspan
                    var field_list_first = [];
                    opts.frozenColumns[0].forEach(function (val) {
                        field_list_first.push({
                            colspan: val.colspan,
                            frozen_status: true
                        });
                    });
                    opts.columns[0].forEach(function (val) {
                        val["frozen_status"] = false;
                        // step字段判断是否隐藏增加hidden属性
                        if(val["step"] === "yes"){
                            if($("#stid_"+val["fname"]).find("i.icon-uniEA39").length > 0){
                                val["hidden_status"] = "no";
                            }else {
                                val["hidden_status"] = "yes";
                            }
                        }
                        field_list_first.push(val);
                    });

                    //第二层 index = 1
                    var field_list_second = [];
                    //冻结字段
                    opts.frozenColumns[1].forEach(function (val) {
                        if (val && val.field !== "id") {
                            field_list_second.push({
                                field: val.field,
                                width: parseInt(val.width),
                                frozen_status: true
                            });
                        }
                    });

                    //普通字段
                    opts.columns[1].forEach(function (val) {
                        if (val && val.field !== "id") {
                            if (val.step) {
                                var field_temp = {
                                    field: val.field,
                                    title: val.title,
                                    align: 'center',
                                    width: parseInt(val.width),
                                    findex: val.findex,
                                    hidden: val.hidden,
                                    drag: val.drag,
                                    step: true,
                                    step_index: val.step_index,
                                    belong: val.belong,
                                    frozen_status: false
                                };
                                if ($.inArray(val.step_index, ['first', 'last']) >= 0) {
                                    //step 第一个元素 和 最后一个元素
                                    field_temp["bdc"] = val.bdc;
                                    field_temp["cbd"] = val.cbd;
                                    field_temp["cellClass"] = val.cellClass;
                                    field_temp["deltaWidth"] = val.deltaWidth;
                                }
                                field_list_second.push(field_temp);
                            } else {
                                field_list_second.push({
                                    field: val.field,
                                    width: parseInt(val.width),
                                    frozen_status: false
                                });
                            }
                        }
                    });

                    field_list.push(field_list_first, field_list_second);
                } else {

                    //冻结字段
                    opts.frozenColumns[0].forEach(function (val) {
                        if (val && val.field !== "id") {
                            field_list.push({
                                field: val.field,
                                width: parseInt(val.width),
                                frozen_status: true
                            });
                        }
                    });

                    //普通字段
                    opts.columns[0].forEach(function (val) {
                        if (val && val.field !== "id") {
                            field_list.push({
                                field: val.field,
                                width: parseInt(val.width),
                                frozen_status: false
                            });
                        }
                    });
                }

                view_data["fields"] = field_list;

                //判断当前是否有选中过滤条件，无则忽略当前临时过滤
                var $ac_item = $("#" + opts.filterConfig.id).find(".exist-filter-item .filter-tag-ac");
                var filter_id = $ac_item.attr("filter_id");


                if (filter_id > 0) {
                    //获取过滤设置
                    view_data["filter"] = {
                        filter_id: filter_id,
                        sort: {"sort_data": sort_data, "sort_query": filter.filter.sort},
                        group: filter.filter.group,
                        request: filter.filter.request,
                        filter_input: filter.filter.filter_input,
                        filter_panel: filter.filter.filter_panel,
                        filter_advance: filter.filter.filter_advance
                    };
                } else {
                    view_data["filter"] = {
                        filter_id: 0,
                        sort: {"sort_data": {}, "sort_query": {}},
                        group: {},
                        request: {},
                        filter_input: {},
                        filter_panel: {},
                        filter_advance: {}
                    };
                }
                break;
        }
        return view_data;
    },
    //切换视图显示
    toggle_view: function (view_id, page, project_id) {
        $.ajax({
            type: 'POST',
            url: StrackPHP['toggleView'],
            dataType: "json",
            data: {
                view_id: view_id,
                project_id: project_id,
                page: page
            },
            beforeSend: function () {
                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
            },
            success: function (data) {
                $.messager.progress('close');
                window.location.reload();
            }
        });
    },
    //删除当前视图
    delete_view: function (i) {
        var select_view = Strack.select_view_param(i);
        var $grid_view;
        var panel = $(i).attr("data-panel");
        switch (panel) {
            case "grid":
                $grid_view = $(i).closest(".grid-toolbar");
                break;
            case "list":
                $grid_view = $(i).closest(".list-toolbar");
                break;
        }
        var page = $grid_view.attr("data-page");
        if (select_view["allow_edit"] === "allow") {
            $.ajax({
                type: 'POST',
                url: StrackPHP['deleteView'],
                dataType: "json",
                data: {
                    id: select_view["view_id"],
                    project_id: select_view["project_id"],
                    page: page
                },
                beforeSend: function () {
                    $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                },
                success: function (data) {
                    $.messager.progress("close");
                    window.location.reload();
                }
            });
        } else {
            layer.msg(StrackLang['View_Deny_Remove'], {icon: 2, time: 1200, anim: 6});
        }
    },
    //工具栏视图按钮高亮显示
    highlight_view_save: function (i) {
        var $toolbar = $(i).closest(".list-toolbar");
        $toolbar.find(".grid-view-bnt").addClass("dg-bnt-active");
    },
    //删除工具栏视图按钮高亮显示
    del_highlight_view_save: function (i) {
        var $toolbar = $(i).closest(".list-toolbar");
        $toolbar.find(".grid-view-bnt").removeClass("dg-bnt-active");
    },
    //错误提示图标
    dialog_error_icon: function (eid) {
        var edom = '';
        switch (eid) {
            case "e":
                edom += '<i class="dialog-form-error form-tip icon-uniF00D"></i>';
                break;
            case "t":
                edom += '<i class="dialog-form-ok form-tip icon-uniF00C"></i>';
                break;
        }
        return edom;
    },
    //调整dropdown面板位置
    dropdown_reset: function () {
        var dtype, t, l, mh, cmh, cwh, ct;
        $('.stdown-filter').each(function () {
            dtype = $(this).data("dtype");
            mh = $(this).data("height");
            if ($("#filter_proj_" + dtype).length > 0) {
                t = $(this).offset().top;
                l = $(this).offset().left;
                if (dtype > 100) {
                    cwh = $(window).height();
                    cmh = t + mh + 71;
                    if (cmh > cwh) {
                        ct = t - mh - 41;
                        $("#filter_proj_" + dtype).css({'top': ct + 35, 'left': l - 160});
                    } else {
                        $("#filter_proj_" + dtype).css({'top': t + 30, 'left': l - 160});
                    }
                } else {
                    $("#filter_proj_" + dtype).css({'top': t + 30, 'left': l - 160});
                }
            }
        });
    },
    //loging 加载效果
    loading_dom: function (type, title, name) {
        var loading = '',
            lt = title;
        if (!lt) {
            lt = ''
        }
        if (!name) {
            name = '';
        } else {
            name = '_' + name;
        }
        switch (type) {
            case 'black':
                loading = '<div id="st-load' + name + '" class="ui active dimmer st-load"><div class="ui text loader">' + lt + '</div></div>';
                break;
            case 'white':
                loading = '<div id="st-load' + name + '" class="ui active inverted dimmer st-load"><div class="ui text loader">' + lt + '</div></div>';
                break;
            case 'null':
                loading = '<div id="st-load' + name + '" class="ui active inverted stnull dimmer st-load"><div class="ui text loader">' + lt + '</div></div>';
                break;
            default :
                break;
        }
        return loading;
    },
    //获取首字母并且大写
    upper_first_str: function (str) {
        if (str == '' || str == null || typeof(str) != "string") {
            return '';
        } else {
            return str.charAt(0).toUpperCase();
        }
    },
    //生成头像dom
    build_avatar: function (user_id, url, uname) {
        var avatar = '';
        var widget_css = 'thumb-34-'+user_id;
        if (url) {
            avatar = '<img class="'+widget_css+'" src="' + url + '" thumb-type="avatar" />';
        } else {
            avatar = '<span class="'+widget_css+'" thumb-type="avatar">' + uname + '</span>';
        }
        return avatar;
    },
    //封装dialog griddata删除操作 --Ajax提交
    ajax_grid_delete: function (edom, primary, confirm, url, eg, cdg) {
        var param = eg ? eg: '';
        var rows = $('#' + edom).datagrid('getSelections');
        var ids = [];
        rows.forEach(function (val) {
            ids.push(val[primary]);
        });
        if (rows.length < 1) {
            layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
        } else {
            Strack.do_ajax_grid_delete(edom, confirm, url, cdg, ids, param);
        }
    },
    // 执行数据表格删除操作
    do_ajax_grid_delete: function(edom, confirm, url, cdg, ids, param) {
        $.messager.confirm(StrackLang['Confirmation_Box'], confirm, function (flag) {
            if (flag) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: JSON.stringify({
                        primary_ids: ids.join(','),
                        param: param
                    }),
                    dataType: 'json',
                    contentType: 'application/json',
                    beforeSend: function () {
                        $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                    },
                    success: function (data) {
                        $.messager.progress('close');
                        if (parseInt(data['status']) === 200) {
                            if (!cdg) {
                                Strack.dialog_cancel();
                            }
                            Strack.top_message({bg: 'g', msg: data['message']});
                            $('#' + edom).datagrid('reload');
                        } else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }
        });
    },
    //封装dialog 基础删除操作 --Ajax提交
    ajax_base_delete: function (ids, confirm, url, callback) {
        $.messager.confirm(StrackLang['Confirmation_Box'], confirm, function (flag) {
            if (flag) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        primary_ids: ids
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                    },
                    success: function (data) {
                        $.messager.progress('close');
                        if (parseInt(data['status']) === 200) {
                            Strack.dialog_cancel();
                            Strack.top_message({bg: 'g', msg: data['message']});
                            callback(data);
                        } else {
                            layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                        }
                    }
                });
            }
        });
    },
    //封装dialog form表单提交 --Ajax提交
    ajax_dialog_form: function (dom, err_lang, url, call, param_call) {
        var data = Strack.submit_dialog_form(dom),
            clang = '';
        if (data['error_num'] < 0) {
            if (err_lang.length > 0) {
                //提供报错信息
                switch (data['error_num']) {
                    case -1:
                    case -2:
                        //字段长度错误
                        clang = data['error_name'] + '' + data['error_num'];
                        layer.msg(err_lang[clang], {icon: 2, time: 1200, anim: 6});
                        break;
                    default:
                        clang = 'illegal';
                        layer.msg(StrackLang['Illegal_Operation'], {icon: 2, time: 1200, anim: 6});
                        break;
                }
            } else {
                //默认报错信息
                layer.msg(data['error_message'], {icon: 2, time: 1200, anim: 6});
            }
        } else {
            var param;
            //增加提交数据
            if (param_call) {
                param = param_call.extra(data);
            } else {
                param = data;
            }
            if (url) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: JSON.stringify(param),
                    dataType: 'json',
                    contentType: 'application/json',
                    beforeSend: function () {
                        $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
                    },
                    success: function (data) {
                        $.messager.progress('close');
                        if (call) {
                            call.back(data);
                        }
                    }
                });
            } else {
                return param;
            }

        }
    },
    //封装dialog form表单提交 --组装数据
    submit_dialog_form: function (dom) {
        $('.form-tip').remove();
        var formdata = {};
        var widget_type = '';
        var allow_widget_type = ["input", "widget", "json", "textarea", "tags", "datalist"];
        //组装数据
        $(dom).each(function () {
            widget_type = $(this).attr("data-widget");

            if ($.inArray(widget_type, allow_widget_type) >= 0) {
                // 当前输入框在允许范围之内
                var id = $(this).attr('id'),
                    valid = $(this).data('valid'),
                    vname = $(this).data('name'),
                    cname = this.className,
                    itype = $(this).attr('type'),
                    val = null,
                    e_num = 0;
                var ids;

                switch (widget_type) {
                    case "input":
                    case "text":
                    case "textarea":
                        val = $(this).val();
                        break;
                    case "json":
                        val = Strack.get_json_editor_val(id);
                        break;
                    case "widget":
                        //处理控件数值
                        var name_arr = cname.split(" ");
                        switch (String(name_arr[1])) {
                            case 'combobox-f':
                                ids = Strack.get_combos_val('#' + this.id, 'combobox', 'getValues');
                                if (ids.length > 0) {
                                    val = ids.join(',')
                                } else {
                                    val = ''
                                }
                                break;
                            case 'combotree-f':
                                ids = Strack.get_combos_val('#' + this.id, 'combotree', 'getValues');
                                if (ids.length > 0) {
                                    val = ids.join(',')
                                } else {
                                    val = ''
                                }
                                break;
                            case 'datebox-f':
                                val = $('#' + this.id).datebox("getValue");
                                if (!val) {
                                    val = "";
                                }
                                break;
                            case 'switchbutton-f':
                                val = Strack.get_switch_val('#' + this.id);
                                break;
                            default:
                                val = $(this).val();
                                break;
                        }
                        break;
                    case 'tags':
                        var tagids = [];
                        $('#st_dialog_form').find(".tag-items").each(function () {
                            tagids.push($(this).data("id"));
                        });
                        val = tagids.join(",");
                        break;
                    case "datalist":
                        break;
                }

                //处理验证
                if (valid) {
                    var field_name = $(this).closest('.st-dialog-input').prev().html();
                    var valid_data = Strack.valid_form(valid, val, field_name);

                    //返回错误信息或者提交成功
                    if (valid_data['status']) {
                        Strack.get_valid_icon(this.id, 1, itype);
                        formdata[vname] = val;
                    } else {
                        Strack.get_valid_icon(this.id, -1, itype);
                        formdata['error_message'] = valid_data['message'];
                        formdata['error_num'] = parseInt(valid_data['error_num']);
                        formdata['error_name'] = vname;
                        return false;
                    }
                } else {
                    formdata[vname] = val;
                }
            }
        });
        return formdata;
    },
    //给form加上验证状态图标
    get_valid_icon: function (tid, type, itype) {
        if (itype !== 'hidden') {
            var $error_icon = $('#' + tid);
            switch (type) {
                case 1://ok
                    $error_icon.parent().append(Strack.dialog_error_icon("t"));
                    break;
                case -1://error
                    $error_icon.parent().append(Strack.dialog_error_icon("e"));
                    break;
                default ://ok
                    $error_icon.parent().append(Strack.dialog_error_icon("t"));
                    break;
            }
        }
    },
    // 切换rule权限设置数据表头
    rule_grid_header_checkbox: function(i)
    {
        var pos = $(i).data("pos"),
            field = $(i).data("field");

        var $this_checkbox = $(i).find(".tree-checkbox");
        var $all_checkbox = $(".datagrid-row td[field = "+field+"]");
        // 顶部应该被选中状态
        var $top_checkbox = $("#rule_header_checkbox_"+field),
            $parent_checkbox,
            $temp_checkbox;

        var top_item_number = 0,
            top_checked_number = 0,
            parent_item_number = 0,
            parent_checked_number = 0;

        var reset_rule_grid_data = {};

        switch (pos){
            case "header":
                if($this_checkbox.hasClass("tree-checkbox1") || $this_checkbox.hasClass("tree-checkbox2")){
                    $this_checkbox.removeClass("tree-checkbox1")
                        .removeClass("tree-checkbox2")
                        .addClass("tree-checkbox0");
                    $all_checkbox.each(function () {
                        $(this).find(".tree-checkbox")
                            .removeClass("tree-checkbox1")
                            .removeClass("tree-checkbox2")
                            .addClass("tree-checkbox0");
                    });
                }else {
                    $this_checkbox.removeClass("tree-checkbox0")
                        .removeClass("tree-checkbox2")
                        .addClass("tree-checkbox1");
                    $all_checkbox.each(function () {
                        $(this).find(".tree-checkbox")
                            .removeClass("tree-checkbox0")
                            .removeClass("tree-checkbox2")
                            .addClass("tree-checkbox1");
                    })
                }
                break;
            case "parent":
                // 选中，取消当前分组下面所有项
                var code = $(i).data("code");
                var parent;
                if($this_checkbox.hasClass("tree-checkbox1") || $this_checkbox.hasClass("tree-checkbox2")){
                    $this_checkbox.removeClass("tree-checkbox1")
                        .removeClass("tree-checkbox2")
                        .addClass("tree-checkbox0");

                    $all_checkbox.each(function () {
                        $temp_checkbox = $(this).find(".dg-rule-checkbox");
                        parent = $temp_checkbox.data("parent");
                        if(parent === code){
                            $(this).find(".tree-checkbox")
                                .removeClass("tree-checkbox1")
                                .removeClass("tree-checkbox2")
                                .addClass("tree-checkbox0");

                            parent_item_number++;
                            top_item_number++;
                            if($(this).find(".tree-checkbox1").length > 0){
                                parent_checked_number++;
                                top_checked_number++;
                            }
                        }else if(parent){
                            top_item_number++;
                            if($(this).find(".tree-checkbox1").length > 0){
                                top_checked_number++;
                            }
                        }

                        if($temp_checkbox.data("code") === code){
                            $parent_checkbox = $temp_checkbox;
                        }
                    });
                }else {
                    $this_checkbox.removeClass("tree-checkbox0")
                        .removeClass("tree-checkbox2")
                        .addClass("tree-checkbox1");
                    $all_checkbox.each(function () {
                        $temp_checkbox = $(this).find(".dg-rule-checkbox");
                        parent = $temp_checkbox.data("parent");
                        if(parent === code){
                            $(this).find(".tree-checkbox")
                                .removeClass("tree-checkbox0")
                                .removeClass("tree-checkbox2")
                                .addClass("tree-checkbox1");
                            parent_item_number++;
                            top_item_number++;
                            if($(this).find(".tree-checkbox1").length > 0){
                                parent_checked_number++;
                                top_checked_number++;
                            }
                        }else if(parent){
                            top_item_number++;
                            if($(this).find(".tree-checkbox1").length > 0){
                                top_checked_number++;
                            }
                        }

                        if($temp_checkbox.data("code") === code){
                            $parent_checkbox = $temp_checkbox;
                        }
                    });
                }

                reset_rule_grid_data = {
                    top_item_number: top_item_number,
                    top_checked_number: top_checked_number,
                    top_checkbox : $top_checkbox,
                    parent_items : [

                    ]
                };

                reset_rule_grid_data["parent_items"][field] =  {
                    parent_item_number: parent_item_number,
                    parent_checked_number: parent_checked_number,
                    parent_checkbox : $parent_checkbox
                };

                Strack.reset_rule_grid_data(reset_rule_grid_data);
                break;
            case "single":
                // 选择，取消当前点击项，判断当前
                var parent = $(i).data("parent");
                var tmp_parent;
                if($this_checkbox.hasClass("tree-checkbox1") || $this_checkbox.hasClass("tree-checkbox2")){
                    $this_checkbox.removeClass("tree-checkbox1")
                        .removeClass("tree-checkbox2")
                        .addClass("tree-checkbox0");
                }else {
                    $this_checkbox.removeClass("tree-checkbox0")
                        .removeClass("tree-checkbox2")
                        .addClass("tree-checkbox1");
                }
                $all_checkbox.each(function () {
                    $temp_checkbox = $(this).find(".dg-rule-checkbox");
                    if($temp_checkbox.data("code") === parent){
                        $parent_checkbox = $temp_checkbox;
                    }

                    tmp_parent = $temp_checkbox.data("parent");
                    if(tmp_parent === parent){
                        parent_item_number++;
                        top_item_number++;
                        if($(this).find(".tree-checkbox1").length > 0){
                            parent_checked_number++;
                            top_checked_number++;
                        }
                    }else if(tmp_parent){
                        top_item_number++;
                        if($(this).find(".tree-checkbox1").length > 0){
                            top_checked_number++;
                        }
                    }
                });

                reset_rule_grid_data = {
                    top_item_number: top_item_number,
                    top_checked_number: top_checked_number,
                    top_checkbox : $top_checkbox,
                    parent_items : [

                    ]
                };

                reset_rule_grid_data["parent_items"][field] =  {
                    parent_item_number: parent_item_number,
                    parent_checked_number: parent_checked_number,
                    parent_checkbox : $parent_checkbox
                };

                Strack.reset_rule_grid_data(reset_rule_grid_data);

                break;
        }
    },
    // 初始化rule权限设置数据表格
    init_rule_grid_data: function(target){
        // 按列处理
        var rule_checks = {
            'view' : {
                top_item_number: 0,
                top_checked_number: 0,
                top_checkbox : null,
                parent_items : {}
            },
            'create' : {
                top_item_number: 0,
                top_checked_number: 0,
                top_checkbox : null,
                parent_items : {}
            },
            'clear' : {
                top_item_number: 0,
                top_checked_number: 0,
                top_checkbox : null,
                parent_items : {}
            },
            'modify' : {
                top_item_number: 0,
                top_checked_number: 0,
                top_checkbox : null,
                parent_items : {}
            },
            'delete' : {
                top_item_number: 0,
                top_checked_number: 0,
                top_checkbox : null,
                parent_items : {}
            }
        };

        var pos,field,code,parent;
        $("#rule_tab_field_function").find(".dg-rule-checkbox")
            .each(function () {
                pos = $(this).attr("data-pos");
                field = $(this).attr("data-field");
                switch (pos){
                    case "header":
                        // 获取顶部对象
                        rule_checks[field]["top_checkbox"] = $(this);
                        break;
                    case "parent":
                        // 获取父节点对象
                        code = $(this).attr("data-code");
                        rule_checks[field]["parent_items"][code] = {
                            parent_item_number: 0,
                            parent_checked_number: 0,
                            parent_checkbox : $(this)
                        };
                        break;
                    case "single":
                        // 统计选中状况
                        parent = $(this).attr("data-parent");
                        code = $(this).attr("data-code");
                        rule_checks[field]["top_item_number"]++;
                        rule_checks[field]["parent_items"][parent]["parent_item_number"]++;

                        if($(this).find(".tree-checkbox").hasClass("tree-checkbox1")){
                            // 当前被选中
                            rule_checks[field]["top_checked_number"]++;
                            rule_checks[field]["parent_items"][parent]["parent_checked_number"]++;
                        }
                        break;
                }
            });

        for(var key in rule_checks){
            Strack.reset_rule_grid_data(rule_checks[key]);
        }
    },
    // 重置rule权限设置数据
    reset_rule_grid_data: function(param)
    {
        // 判断顶部区域checkbox状态
        var $top_checkbox = param.top_checkbox.find(".tree-checkbox");
        if(param.top_checked_number>0){
            if(param.top_checked_number === param.top_item_number){
                $top_checkbox.removeClass("tree-checkbox0")
                    .removeClass("tree-checkbox2")
                    .addClass("tree-checkbox1");
            }else {
                $top_checkbox.removeClass("tree-checkbox0")
                    .removeClass("tree-checkbox1")
                    .addClass("tree-checkbox2");
            }
        }else {
            $top_checkbox.removeClass("tree-checkbox1")
                .removeClass("tree-checkbox2")
                .addClass("tree-checkbox0");
        }

        // 判断分组父级区域checkbox状态
        var value;
        for(var key in param.parent_items){
            value = param.parent_items[key];
            var $parent_checkbox = value.parent_checkbox.find(".tree-checkbox");
            if(value.parent_checked_number>0){
                if(value.parent_checked_number === value.parent_item_number){
                    $parent_checkbox.removeClass("tree-checkbox0")
                        .removeClass("tree-checkbox2")
                        .addClass("tree-checkbox1");
                }else {
                    $parent_checkbox.removeClass("tree-checkbox0")
                        .removeClass("tree-checkbox1")
                        .addClass("tree-checkbox2");
                }
            }else {
                $parent_checkbox.removeClass("tree-checkbox1")
                    .removeClass("tree-checkbox2")
                    .addClass("tree-checkbox0");
            }
        }
    },
    //封装拾取颜色
    color_pick_widget: function (dom, ui, color, cval, w) {
        //添加class 设置参数
        $(dom).addClass('color-pick');
        $(dom).val(cval);
        //设置宽度和颜色
        if (w) {
            $(dom).attr('style', 'width:' + w + 'px;border-color:#' + cval)
        }
        $(dom).colpick({
            layout: ui,
            submit: 0,
            color: cval,
            colorScheme: color,
            onChange: function (hsb, hex, rgb, el, bySetColor) {
                $(el).css('border-color', '#' + hex);
                if (!bySetColor) $(el).val(hex);
            }
        }).keyup(function () {
            $(this).colpickSetColor(this.value);
        });
    },
    //动态创建 easyui dialog
    build_dialog: function (dom) {
        $('body').append('<div id="' + dom + '"></div>');
    },
    //封装 easyui dialog
    open_dialog: function (dom, d) {
        Strack.build_dialog(dom);
        $('#' + dom).dialog({
            title: d.title,
            width: d.width,
            height: d.height,
            top: d.top,
            closed: false,
            cache: false,
            modal: true,
            content: d.content,
            onMove: function (left, top) {
                Strack.dropdown_reset();
            },
            onOpen: function () {
                if (d.inits) {
                    d.inits.call(this)
                }
            },
            onClose: function () {
                $(this).dialog('destroy');
                if (d.close) {
                    d.close.call(this)
                }
            }
        })
    },
    // 封装 json编辑器
    init_json_editor: function (id, options, val) {
        var opt = options ? options : {};
        var container = document.getElementById(id);
        Strack.G.jsonEditor[id] = new JSONEditor(container, opt);
        if (val) {
            Strack.G.jsonEditor[id].set(val);
        }
    },
    // 销毁指定 json编辑器
    destroy_json_editor: function (id) {
        if (Strack.G.jsonEditor[id]) {
            Strack.G.jsonEditor[id].destroy();
            delete Strack.G.jsonEditor[id];
        }
    },
    // 获取指定 json编辑器值
    get_json_editor_val: function (id) {
        if (Strack.G.jsonEditor[id]) {
            return Strack.G.jsonEditor[id].get();
        } else {
            return {};
        }
    },
    //封装 easyui combo combobox combotree combogrid
    get_combos_val: function (dom, combox, type) {
        var combo_dom,
            combo_val = '';
        if (combox) {
            combo_dom = $(dom)[combox]('panel');
            combo_val = $(dom)[combox](type);
            if (combo_dom.children('div').hasClass('combobox-item-selected') || combox === "combotree") {
                return combo_val ? combo_val:'';
            } else {
                combo_val = '';
                return combo_val;
            }
        } else {
            return combo_val;
        }
    },
    //封装 easyui combobox
    combobox_widget: function (dom, param) {
        var options = param ? param : {};
        $(dom).combobox(options);
    },
    //easyui 开关方法赋值
    set_switch_val: function (c_bool) {
        var checkval = null;
        if (parseInt(c_bool) === 1) {
            checkval = true;
        } else {
            checkval = false;
        }
        return checkval;
    },
    //easyui SwitchButton开关封装
    init_open_switch: function (param, callback) {
        var h = param["height"] ? param["height"] : 26;
        var options_param = {
            checked: Strack.set_switch_val(param["value"]),
            width: param["width"],
            height: h,
            onText: param["onText"],
            offText: param["offText"],
            onChange: function (checked) {
                var Cstatus;
                if (checked) {
                    Cstatus = 1;
                } else {
                    Cstatus = 0;
                }
                $(param["dom"]).next().children("input").val(Cstatus);
                // 回调方法
                if (callback) {
                    callback(Cstatus);
                }
            }
        };

        if(param["disabled"]){
            options_param["disabled"] = param["disabled"];
        }

        $(param["dom"]).switchbutton(options_param);
        $(param["dom"]).next().prepend('<input type="hidden" name="switchbutton" value="' + param["value"] + '" >');
    },
    //easyui DateBox封装
    open_date_box: function (dom, w, h, val) {
        $(dom).datebox({
            width: w,
            height: h,
            value: val,
            editable: false
        });
    },
    //easyui DateBox filter 专属封装
    filter_date_box: function (dom, w, h, val, is_timebox) {
        var type = is_timebox ? "datetimebox" : "datebox";
        $(dom).datebox({
            width: w,
            height: h,
            value: val,
            editable: false,
            onSelect: function (date) {
                var ptype = $(this).data("ptype"),
                    filter = $(this).data("filter");
                Strack.filter_auto(this);
            }
        });
    },
    //easyui 获取SwitchButton开关值
    get_switch_val: function (dom) {
        var sval;
        if (dom) {
            sval = $(dom).next().children("input").val();
        } else {
            sval = $('.switchbutton input[name=switchbutton]').val();
        }
        return sval !== 'undefined' ? parseInt(sval) : 0;
    },
    //easui plane 高度计算
    panel_height: function (dom, sub) {
        return $(dom).height() - sub;
    },
    //easui Datagrid 自适应浏览器
    auto_resize_datagrid: function (ddom, data_dom, min_width, exth, domresize) {
        if (domresize) {
            // 获取dom resize变化事件
            $(data_dom).on("mresize", function () {
                Strack.do_resize_datagrid(ddom, data_dom, min_width, exth);
            });
        } else {
            //获取全局 resize变化事件
            $(window).resize(function () {
                Strack.do_resize_datagrid(ddom, data_dom, min_width, exth);
            });
        }
    },
    //easui Datagrid 自适应判断当前datagrid是否隐藏
    do_resize_datagrid: function (ddom, data_dom, min_width, exth) {
        var d_offset;
        if ($(data_dom).is(':hidden')) {
            d_offset = $(data_dom).show().offset();
            Strack.resize_datagrid_active(ddom, d_offset, min_width, exth);
            $(data_dom).removeAttr("style");
        } else {
            d_offset = $(data_dom).offset();
            Strack.resize_datagrid_active(ddom, d_offset, min_width, exth);
            Strack.dropdown_reset();
        }
    },
    //easui Datagrid 自适应基础方法
    resize_datagrid_active: function (ddom, d_offset, min_width, exth) {
        var fwidth = $(ddom).closest('.entity-datalist').next('.datagrid-filter').width();
        fwidth = fwidth > 0 ? fwidth : 0;

        var $grid_right_wrap = $('.grid-right-wrap');
        var pright = 0;

        if(!$grid_right_wrap.is(":hidden")){
            pright = $grid_right_wrap.width();
            pright = pright > 0 ? pright + 1 : 0;
        }

        var _5e8 = $.data(ddom, "datagrid"),
            opts = _5e8.options,
            dc = _5e8.dc,
            wrap = _5e8.panel,
            _5e9 = window.innerWidth - d_offset.left - 2 - fwidth - pright,
            _5ea = window.innerHeight - d_offset.top - 2 - exth,
            view = dc.view,
            _5eb = dc.view1,
            _5ec = dc.view2,
            _5ed = _5eb.children("div.datagrid-header"),
            _5ee = _5ec.children("div.datagrid-header"),
            _5ef = _5ed.find("table"),
            _5f0 = _5ee.find("table");

        wrap.css({'width': _5e9, 'height': _5ea});
        view.width(_5e9);
        var _5f1 = _5ed.children("div.datagrid-header-inner").show();
        _5eb.width(_5f1.find("table").width());
        if (!opts.showHeader) {
            _5f1.hide();
        }
        _5ec.width(_5e9 - _5eb._outerWidth());
        _5eb.children()._outerWidth(_5eb.width());
        _5ec.children()._outerWidth(_5ec.width());
        var all = _5ed.add(_5ee).add(_5ef).add(_5f0);
        all.css("height", "");
        var hh = 0;
        //表头高度
        if (opts.HeaderHeight) {
            hh = opts.HeaderHeight;
        } else {
            hh = Math.max(_5ef.height(), _5f0.height());
        }
        all._outerHeight(hh);
        var _5f2 = dc.body2.children("table.datagrid-btable-frozen")._outerHeight();
        var _5f3 = _5f2 + _5ee._outerHeight() + _5ec.children(".datagrid-footer")._outerHeight();
        wrap.children(":not(.datagrid-view,.datagrid-mask,.datagrid-mask-msg)").each(function () {
            _5f3 += $(this)._outerHeight();
        });
        var _5f4 = wrap.outerHeight() - wrap.height();
        _5eb.add(_5ec).children("div.datagrid-body").css({
            marginTop: _5f2,
            height: isNaN(parseInt(_5ea)) ? "" : _5ea - _5f3
        });
        view.height(_5ec.height());
        _5ec.find('.datagrid-body').css('overflow', 'auto');
    },
    //判断easyui是否自适应
    fit_columns: function (c_dom, c_num) {
        var checkfit = null;
        if ($(c_dom).width() > c_num) {
            checkfit = true;
        } else {
            checkfit = false;
        }
        return checkfit;
    },
    // 获取指定数据表格被选中的值
    get_datagrid_select_data: function(id, callback){
        var rows = $(id).datagrid('getSelections');
        var ids = [];
        rows.forEach(function (val) {
            ids.push(val['id']);
        });
        if (rows.length < 1) {
            layer.msg(StrackLang['Please_Select_One'], {icon: 2, time: 1200, anim: 6});
        } else {
            callback(ids);
        }
    },
    //保存添加新增面板设置
    save_dialog_setting: function () {
        var type = $("#Ntype").val(),
            page = $("#Npage").val();
        var fields = [];
        $(".dg-report-de").each(function () {
            fields.push($(this).attr("data-field"));
        });

        $.ajax({
            type: 'POST',
            url: StrackPHP['saveDialogSetting'],
            dataType: "json",
            data: {
                fields: JSON.stringify(fields),
                type: type,
                page: page
            },
            beforeSend: function () {
                $.messager.progress({title: StrackLang['Waiting'], msg: StrackLang['loading']});
            },
            success: function (data) {
                // 更新当前页面缓存
                Strack.G.DialogAddSetting[type] = data;
                $.messager.progress('close');
                Strack.top_message({bg: 'g', msg: StrackLang['Dialog_Setting_Save_SC']});
            }
        });
    },
    // 配置页面顶部显示字段
    top_fields_config: function(i)
    {
        var page = $(i).attr("data-page"),
            pos = $(i).attr("data-pos"),
            project_id = $(i).attr("data-projectid"),
            module_id = $(i).attr("data-moduleid"),
            module_code = $(i).attr("data-modulecode"),
            template_id = $(i).attr("data-templateid");

        Strack.template_set_dialog({'datalist_url': StrackPHP["getDetailsModuleColumns"], 'config_url': StrackPHP["getTemplateUserConfig"], 'title': StrackLang["Template_Details_Top_Field"], 'temp_id': template_id, 'module_code':module_code, 'module_id':module_id, 'project_id': project_id, 'category': 'top_field', 'type': 'top_field', 'page' :page, 'id_field' : 'field_group_id' , 'text_field' : 'lang', 'text_field_lang' : StrackLang["Column"], 'group' : 'belong_table', 'limit': 3, 'submit_bnt'  :'update_details_top_fields_set', 'pos': pos});
    },
    // 模板设置对话框
    template_set_dialog: function(param)
    {
        var item_id = param["item_id"]?param["item_id"] : 0;
        Strack.open_dialog('dialog',{
            title: param["title"],
            width: 800,
            height: 520,
            content: Strack.dialog_dom({
                type:'normal',
                hidden:[
                    {case:101,id:'Mtemp_id',type:'hidden',name:'temp_id',valid:1,value:param['temp_id']},
                    {case:101,id:'Mid_field',type:'hidden',name:'id_field',valid:1,value:param['id_field']},
                    {case:101,id:'Mmodule_code',type:'hidden',name:'module_code',valid:1,value:param['module_code']},
                    {case:101,id:'Mcategory',type:'hidden',name:'category',valid:1,value:param['category']},
                    {case:101,id:'Mtype',type:'hidden',name:'type',valid:1,value:param['type']},
                    {case:101,id:'Mpage',type:'hidden',name:'page',valid:1,value:param['page']},
                    {case:101,id:'Mpos',type:'hidden',name:'pos',valid:1,value:param['pos']}
                ],
                items:[
                    {case:5,id:'',type:'text',lang:'',name:'',valid:'',value:0}
                ],
                footer:[
                    {obj: param["submit_bnt"], type:5, title:StrackLang['Update']},
                    {obj:'dialog_cancel', type:8, title:StrackLang['Cancel']}
                ]
            }),
            inits:function(){
                var $Rdatagrid;
                $('#template-field').datalist({
                    url: param['datalist_url'],
                    width:320,
                    height:380,
                    idField:param["id_field"],
                    valueField:param["id_field"],
                    textField:param["text_field"],
                    groupField:param["group"],
                    checkbox: true,
                    singleSelect: false,
                    queryParams:{
                        item_id: item_id,
                        module_code: param["module_code"],
                        category : param['category'],
                        module_id : param['module_id'],
                        project_id: param['project_id'],
                        template_id : param['temp_id']
                    },
                    onLoadSuccess:function(data){

                        var $datalist = $(this);

                        $.ajax({
                            type:'POST',
                            url: param["config_url"],
                            dataType: 'json',
                            data:{
                                template_id: param["temp_id"],
                                module_code: param["module_code"],
                                category : param['category']
                            },
                            beforeSend:function(){
                                $('#dialog').prepend(Strack.loading_dom('white','','config'));
                            },
                            success:function(data){
                                var columns = [
                                    {field: param["id_field"], checkbox: true},
                                    {field: param["text_field"], title: param["text_field_lang"], align: 'center', width: 160}
                                ];

                                if(param["group"]){
                                    columns.push({field: param["group"], title: StrackLang['Group'], align: 'center', width: 160});
                                }

                                $('#template-columns').datagrid({
                                    data:[],
                                    width:380,
                                    height:380,
                                    rownumbers:true,
                                    fitColumns:true,
                                    columns:[columns],
                                    dragSelection: true,
                                    onLoadSuccess: function(){
                                        $Rdatagrid = $(this);
                                        $Rdatagrid.datagrid('enableDnd');
                                    }
                                });

                                //选择赋值
                                data.forEach(function (val) {
                                    $datalist.datalist('selectRecord', val[param["id_field"]]);
                                });

                                $("#st-load_config").remove();
                            }
                        });
                    },
                    onSelect:function(index, row){
                        // //选中一行 判断
                        var $columns=$('#template-columns');
                        $columns.datagrid('appendRow',row);
                        $Rdatagrid.datagrid('enableDnd');
                        if(param["limit"] >0 ){
                            var rows = $columns.datagrid('getRows');
                            if(rows.length > param["limit"]){
                                $(this).datagrid('unselectRow', index);
                            }
                        }
                    },
                    onUnselect:function(index, row){
                        //取消选中一行，获取当前选择取消row行号
                        var $columns=$('#template-columns'),
                            rownum = $columns.datagrid('getRowIndex',row);
                        $columns.datagrid('deleteRow',rownum);
                    }
                });
            }
        });
    },
    // 获取前台页面模板配置dialog数据
    get_home_template_config: function() {
        var temp_id = $('#Mtemp_id').val(),
            module_code = $('#Mmodule_code').val(),
            category = $('#Mcategory').val(),
            pos = $('#Mpos').val(),
            id_field = $('#Mid_field').val(),
            rows = $('#template-columns').datagrid('getRows');

        var config = [];
        rows.forEach(function (val) {
            switch (category){
                case "top_field":
                case "tab":
                case "step":
                case "step_fields":
                    config.push(val);
                    break;
                default:
                    var temp = {};
                    temp[id_field] = val[id_field];
                    config.push(temp);
                    break;
            }
        });

        var up_data = {
            template_id: temp_id,
            module_code: module_code,
            category: category,
            config: config,
            pos: pos
        };

        return up_data;
    },
    // 上传保存配置
    update_details_top_fields_set: function () {
        var up_data = Strack.get_home_template_config();
        $.ajax({
            type:'POST',
            url:StrackPHP['modifyUserTemplateConfig'],
            data: JSON.stringify(up_data),
            dataType: 'json',
            contentType: "application/json",
            beforeSend:function(){
                $('#dialog').prepend(Strack.loading_dom('white','','config'));
            },
            success:function(data){
                $('#st-load_config').remove();
                Strack.top_message({bg:'g',msg:data['message']});
                if(!$.isEmptyObject(Strack.G.topfieldsRequestParam) || !$.isEmptyObject(Strack.G.sliderTopfieldsRequestParam)){
                    if(up_data.pos === "slider"){
                        Strack.load_info_panel(Strack.G.sliderTopfieldsRequestParam);
                    }else {
                        Strack.load_info_panel(Strack.G.topfieldsRequestParam);
                    }
                }
                Strack.dialog_cancel();
            }
        });
    },
    // 提交详情页面tab配置
    update_details_tab_set: function()
    {
        var up_data = Strack.get_home_template_config();
        $.ajax({
            type:'POST',
            url:StrackPHP['modifyTemplateConfig'],
            data: JSON.stringify(up_data),
            dataType: 'json',
            contentType: "application/json",
            beforeSend:function(){
                $('#dialog').prepend(Strack.loading_dom('white','','config'));
            },
            success:function(data){
                $('#st-load_config').remove();
                Strack.top_message({bg:'g',msg:data['message']});
                if(up_data.pos === "slider"){
                    Strack.refresh_details_tab(up_data.config);
                }else {
                    obj.refresh_details_tab(up_data.config);
                }
                Strack.dialog_cancel();
            }
        });
    },
    //  修改tab配置刷新
    refresh_details_tab: function(config)
    {
        // 获取当前激活的tab
        var $ac_tab = $("#grid_slider_tab .tab_item.active");
        var tab_id = $ac_tab.attr("data-tabid");
        var first_tab = {};
        config.forEach(function (val) {
            if (!first_tab) {
                first_tab = val;
            }
            if (val["tab_id"] === tab_id) {
                first_tab = val;
            }
        });
        Strack.generate_tab_list("grid_slider_tab", Strack.G.gridSliderParam, config);
        Strack.show_datagrid_slider_tab(first_tab);
    },
    /*
     * 上传头像保存在canvas中
     * @param <string> dom    input id
     * @param <string> show   input显示头像
     * @param <string>  cas   canvas容器
     */
    upload_image: function (dom, show, cas, maxh) {
        var ImgType = ["gif", "jpeg", "jpg", "bmp", "png"],
            ErrMsg = [StrackLang['Image_Format_Limit'], StrackLang['Browser_Support']];
        document.getElementById(dom).onchange = function () {
            if (this.value) {
                if (!RegExp("\.(" + ImgType.join("|") + ")$", "i").test(this.value.toLowerCase())) {
                    Strack.top_message({bg: 'r', msg: ErrMsg[0]});
                    this.value = "";
                    return false;
                } else if (navigator.userAgent.indexOf("MSIE") > -1) {
                    //不支持IE浏览器
                    Strack.top_message({bg: 'r', msg: ErrMsg[1]});
                    this.value = "";
                    return false;
                } else {
                    $('#' + show).val(this.value);
                    if (this.files[0]) {
                        var reader = new FileReader();
                        //把图片生成base64码
                        reader.addEventListener("load", function (e) {
                            //把图片保存到canvas中
                            var url = e.target.result,
                                img = new Image();
                            img.addEventListener("load", function () {
                                //在这里对头像大小进行一次压缩保证高度为140px,横向居中裁切
                                var h = parseInt(maxh) > 0 ? maxh : 280;
                                var w = img.width * (h / img.height);
                                $('#' + cas).empty().append('<canvas id="img_cas" width="' + w + '" height="' + h + '"></canvas>');
                                var canvas = document.getElementById('img_cas'),
                                    ctx = canvas.getContext("2d");
                                ctx.drawImage(img, 0, 0, w, h);
                                Strack.G.Jcrop_Canvas = canvas;
                            }, false);
                            img.src = url;
                        }, false);
                        reader.readAsDataURL(this.files[0]);
                    }
                }
            }
        };
    },
    //顶部消息封装
    top_message: function (set) {
        var bg;
        switch (String(set.bg)) {
            case 'r':
                bg = 'error';
                break;
            case 'g':
                bg = 'success';
                break;
            case 'w':
                bg = 'warn';
                break;
            default :
                bg = 'success';
                break;
        }

        layer.msg(set.msg, {
            offset: '10px',
            skin: "a-bounceinT layui-layer-bmsg layui-layer-" + bg,
            time: 3000
        });
    },
    //图片上传获取 填充图像
    upload_preview: function (setting) {
        var _self = this,
            jcrop_api = null,
            canvas = null,
            bounds = null,
            c_w = '',
            c_h = '';

        _self.IsNull = function (value) {
            if (typeof (value) == "function") {
                return false;
            }
            if (value == undefined || value == null || value == "" || value.length == 0) {
                return true;
            }
            return false;
        };

        //默认设置
        _self.DefautlSetting = {
            UpBtn: "",
            Canvas: "",
            Cancel: [""],
            Jcrop: "",
            Showpanel: false,
            Width: 100,
            Height: 100,
            MinLimit: 50,
            ImgType: ["gif", "jpeg", "jpg", "bmp", "png"],
            ErrMsg: [StrackLang['Image_Format_Limit'], StrackLang['Browser_Support']],
            callback: function () {
            }
        };
        //获取用户设置
        _self.Setting = {
            UpBtn: _self.IsNull(setting.UpBtn) ? _self.DefautlSetting.UpBtn : setting.UpBtn,
            Canvas: _self.IsNull(setting.Canvas) ? _self.DefautlSetting.Canvas : setting.Canvas,
            Cancel: _self.IsNull(setting.Cancel) ? _self.DefautlSetting.Cancel : setting.Cancel,
            Jcrop: _self.IsNull(setting.Jcrop) ? _self.DefautlSetting.Jcrop : setting.Jcrop,
            Showpanel: _self.IsNull(setting.Showpanel) ? _self.DefautlSetting.Showpanel : setting.Showpanel,
            Width: _self.IsNull(setting.Width) ? _self.DefautlSetting.Width : setting.Width,
            Height: _self.IsNull(setting.Height) ? _self.DefautlSetting.Height : setting.Height,
            MinLimit: _self.IsNull(setting.MinLimit) ? _self.DefautlSetting.MinLimit : setting.MinLimit,
            ImgType: _self.IsNull(setting.ImgType) ? _self.DefautlSetting.ImgType : setting.ImgType,
            ErrMsg: _self.IsNull(setting.ErrMsg) ? _self.DefautlSetting.ErrMsg : setting.ErrMsg,
            callback: _self.IsNull(setting.callback) ? _self.DefautlSetting.callback : setting.callback
        };
        //生成base64 dataURL 并绘图
        _self.drawImg = function (file, cv) {
            if (file) {
                var reader = new FileReader();
                reader.addEventListener("load", function (e) {
                    var url = e.target.result,
                        img = new Image();
                    //填充图片到canvas
                    img.addEventListener("load", function () {
                        //获取图片宽高
                        var img_width = img.width,
                            img_height = img.height,
                            cv_width = _self.Setting.Width,
                            cv_height = _self.Setting.Height,
                            minlimit = _self.Setting.MinLimit;
                        //居中显示算法 获得canvas长宽
                        var ratio = img_width / img_height, w, h, x, y, r_min, r_max;
                        //判断获取w值即可
                        r_max = cv_width / minlimit;
                        r_min = minlimit / cv_height;
                        if (ratio >= r_max) {
                            w = minlimit * ratio;
                        } else if (ratio <= r_min) {
                            if (img_width > minlimit) {
                                w = img_width;
                            }
                            else {
                                w = minlimit;
                            }
                        } else {
                            if (img_width >= cv_width) {
                                w = cv_width;
                            }
                            else if (img_height <= cv_height) {
                                w = cv_height * ratio;
                            }
                            else {
                                w = img_width;
                            }
                        }
                        h = w / ratio;
                        x = (cv_width - w) / 2;
                        y = -(h - cv_height) / 2;

                        //获取画布的位置 与 宽高
                        var j_x, j_y, j_w, j_h;
                        if (w > cv_width) {
                            j_w = cv_width
                        } else {
                            j_w = w
                        }
                        if (h > cv_height) {
                            j_h = cv_height
                        } else {
                            j_h = h
                        }
                        j_x = -(j_h - cv_height) / 2;
                        j_y = (cv_width - j_w) / 2;

                        //动态创建canvas
                        $('.crop-avatar-img').html('<canvas id="' + cv + '" height="' + j_h + 'px" width="' + j_w + 'px" style="position: absolute;top:' + j_x + 'px;left:' + j_y + 'px">');
                        canvas = document.getElementById(cv);
                        Strack.G.Jcrop_Canvas = canvas;
                        var ctx = canvas.getContext("2d");
                        ctx.globalCompositeOperation = 'copy';

                        //判断是否需要裁切
                        if (_self.Setting.Jcrop != "") {
                            //先销毁裁切
                            if (jcrop_api != null && jcrop_api != '') {
                                $('.jcrop-holder').remove();
                            }
                            //创建jcrop dom
                            $('#' + cv).parent().after('<div id="' + _self.Setting.Jcrop + '"></div>');
                            $('#' + _self.Setting.Jcrop).css({
                                'width': j_w + 'px',
                                'height': j_h + 'px',
                                'top': j_x + 'px',
                                'left': j_y + 'px'
                            });
                            $('#' + _self.Setting.Jcrop).Jcrop({
                                minSize: [minlimit, minlimit],
                                onChange: function (c) {
                                    Strack.G.Jcrop_Thumb = c;
                                    var rx = c.x,
                                        ry = c.y,
                                        ra = minlimit / c.w;
                                    $('.avatar-view-sm1>img').css({
                                        'margin-top': '-' + (ry) * ra + 'px',
                                        'margin-left': '-' + (rx) * ra + 'px',
                                        'width': w * ra + 'px'
                                    });
                                    $('.avatar-view-sm2>img').css({
                                        'margin-top': '-' + ((ry * 2) / 3) * ra + 'px',
                                        'margin-left': '-' + ((rx * 2) / 3) * ra + 'px',
                                        'width': ((w * 2) / 3) * ra + 'px'
                                    });
                                    $('.avatar-view-sm3>img').css({
                                        'margin-top': '-' + (ry / 3) * ra + 'px',
                                        'margin-left': '-' + (rx / 3) * ra + 'px',
                                        'width': (w / 3) * ra + 'px'
                                    });
                                },
                                aspectRatio: 1
                            }, function () {
                                bounds = this.getBounds();
                                jcrop_api = this;
                                jcrop_api.animateTo([0, 0, minlimit, minlimit]);
                            })
                        }
                        //填充图像 生成新的偏移坐标
                        var i_x = 0, i_y = 0;
                        if (w > j_w) {
                            i_x = x
                        }
                        if (h > j_h) {
                            i_y = y
                        }
                        c_w = w;
                        c_h = h;
                        ctx.drawImage(img, i_x, i_y, w, h);

                        //获取预览
                        if (_self.Setting.Jcrop != "") {
                            var imgData = canvas.toDataURL("image/png");
                            $('.avatar-view-sm1').html('<img  src="' + imgData + '" />');
                            $('.avatar-view-sm2').html('<img  src="' + imgData + '" />');
                            $('.avatar-view-sm3').html('<img  src="' + imgData + '" />');
                            //调整预览图
                            $('.avatar-view-sm2>img').css({'width': (w * 2) / 3 + 'px'});
                            $('.avatar-view-sm3>img').css({'width': w / 3 + 'px'});
                        }
                    }, false);
                    img.src = url;
                }, false);
                reader.readAsDataURL(file);
            }
        };
        //清除画布
        _self.Cancel = function () {
            if (canvas) {
                var vtx = canvas.getContext("2d");
                vtx.clearRect(0, 0, c_w, c_h);
                if (jcrop_api != null && jcrop_api != '') {
                    $('.jcrop-holder').remove();
                    $('.avatar-view-sm1,.avatar-view-sm2,.avatar-view-sm3').empty();
                    Strack.G.Jcrop_Thumb = '';
                }
                canvas = null;
                Strack.G.Jcrop_Canvas = canvas;
            }
        };
        //执行方法
        _self.Bind = function () {
            document.getElementById(_self.Setting.UpBtn).onchange = function () {
                if (this.value) {
                    var path = this.value.toLowerCase();
                    if (!RegExp("\.(" + _self.Setting.ImgType.join("|") + ")$", "i").test(path)) {
                        Strack.top_message({bg: 'r', msg: _self.Setting.ErrMsg[0]});
                        this.value = "";
                        return false;
                    } else if (navigator.userAgent.indexOf("MSIE") > -1) {
                        //不支持IE浏览器
                        Strack.top_message({bg: 'r', msg: _self.Setting.ErrMsg[1]});
                        this.value = "";
                        return false;
                    } else {
                        // 获取当前图片后缀
                        var path_arr = path.split(".");
                        Strack.G.Jcrop_Thumb_Ext = path_arr[path_arr.length - 1];
                        _self.drawImg(this.files[0], _self.Setting.Canvas);
                    }
                    _self.Setting.callback();
                }
            };
            if (_self.Setting.Cancel) {
                var cdom = '',
                    $panelshow = $('.crop-avatar-wrap');
                for (var i = 0; i < _self.Setting.Cancel.length; i++) {
                    cdom += _self.Setting.Cancel[i] + ',';
                }
                cdom = cdom.substring(0, cdom.length - 1);
                //这里确定 是否隐藏上传用户图标面板
                //默认是隐藏的
                if (_self.Setting.Showpanel) {
                    $panelshow.show();
                    $(cdom).click(function () {
                        _self.Cancel();
                    });
                } else {
                    $(cdom).click(function () {
                        $panelshow.slideToggle(function () {
                            _self.Cancel();
                        });
                    })
                }
            }
        };
        _self.Bind();
    },
    //全局loading
    global_loading: function () {
        var gloading = '';
        gloading += '<div class="global-loading-wrap">' +
            '<div class="global-masked">' +
            '<i class="icon-strack_logo"></i>' +
            '</div>' +
            '</div>';

        return gloading;
    },
    //取消全局loading
    cancel_global_loading: function () {
        setTimeout(function () {
            $('.global-masked').hide();
            $('.global-loading-wrap').addClass('a-fadeout');
            setTimeout(function () {
                $('.global-loading-wrap').remove();
            }, 1000);
        }, 500);
    },
    //初始化dropdown
    init_dropdown: function () {
        $('.ui.menu , .ui.dropdown').dropdown({
            on: 'hover',
            onHide: function () {
                if(Strack.G.isClickDropdown.status && Strack.G.isClickDropdown.target.html() === $(this).html()){
                    Strack.G.isClickDropdown.target = $(this);
                    Strack.G.isClickDropdown.status = false;
                    return false;
                }
                return true;
            }
        });
    },
    //关闭系统消息
    close_notice_message: function () {
        $(".globel-top-notice").remove();
        $("body").removeClass("has-top-notice-body");
    },
    //记录后台菜单位置
    click_admin_menu: function (i) {
        Strack.save_storage('admin_menu_top', $(".admin-page-left").scrollTop());
    },
    //页面有操作后页面刷新关闭提醒
    on_before_unload_notice: function () {
        return "The current page is not saved! Is it overloaded?";
    },
    // 生成顶部菜单
    build_top_menu: function () {
        $.ajax({
            type: 'POST',
            url: StrackPHP['getTopMenuData'],
            dataType: "json",
            data: {
                menu_name: Strack.G.MenuName,
                module_id: Strack.G.ModuleId,
                module_type: Strack.G.ModuleType,
                project_id: Strack.G.ProjectId
            },
            success: function (data) {
                Strack.TopMenuData = data["menu_data"];
                Strack.generate_top_menu(data["menu_data"]);
                if ($.inArray(Strack.G.MenuName, ['project_inside', 'project_detail']) >= 0 ) {
                    $(".nav-breadcrumb-name").attr("title", data["project_data"]["current_project"]["name"]);
                    $(".nav-breadcrumb-text").html(data["project_data"]["current_project"]["name"]);
                    Strack.top_menu_project_item_dom(data["project_data"]);
                    $(".nav-project-head").show();
                }
                Strack.top_menu_on_resize();
            }
        });
    },
    // 根据数据生成顶部菜单
    generate_top_menu: function (data) {
        var bar_w = $("#nav_main_bar").width();
        var $main = $("#nav_main_list");
        var $hide = $("#nav_hide_list");
        var $bar_hide = $(".nav-main-bar-hide");
        $bar_hide.hide().removeClass("nav_main_active");
        $main.empty();
        $hide.empty();
        var append_w = 46, append_id = '', pre_data, pre_add = true, has_hide = false;
        data.forEach(function (val) {
            if (append_w > bar_w) {
                has_hide = true;
                if (pre_add) {
                    $("#" + append_id).remove();
                    if (pre_data["active"] === "yes") {
                        $bar_hide.addClass("nav_main_active");
                    }
                    $hide.append(Strack.top_menu_hide_dom(pre_data));
                    pre_add = false;
                }

                $hide.append(Strack.top_menu_hide_dom(val));
            } else {
                $main.append(Strack.top_menu_main_dom(val));
            }
            pre_data = val;
            append_id = "top_m_" + val["code"];
            append_w += $("#top_m_" + val["code"]).width() + 2;
        });

        if (has_hide) {
            $bar_hide.show();
        } else {
            $(".nav-main-bar-show").css("margin-left", (bar_w - append_w) / 2);
        }
    },
    // 动态更改顶部菜单项
    refresh_top_menu: function (menu_data) {
        Strack.TopMenuData = menu_data;
        Strack.generate_top_menu(menu_data);
    },
    // 监听顶部菜单事件
    top_menu_on_resize: function () {
        $(".header-main").on("mresize", function () {
            Strack.generate_top_menu(Strack.TopMenuData);
        });
    },
    // 顶部项目菜单list item dom
    top_menu_project_item_dom: function (data) {
        var dom = '';
        var url = Strack.remove_html_ext(StrackPHP["Project_Url"]) + '/'+data["project_last_url"];

        data["active_project_list"].forEach(function (val) {
            dom += '<a href="' + url + ''+val["project_id"]+'.html" class="item" data-value="' + data["current_project"]["name"] + '">' +
                '<span class="project-menu-name text-ellipsis">'+ val["name"] + '</span>' +
                '</a>';
        });
        $("#to_menu_project_list").empty().append(dom);
    },
    // 顶部菜单主要DOM
    top_menu_main_dom: function (data) {
        var dom = '';
        var active = data["active"] === "yes" ? "nav_main_active" : "";
        dom += '<li id="top_m_' + data["code"] + '" class="nav-main-items ' + active + '">';
        if (data["url"] !== '#') {
            dom += '<a href="' + data["url"] + '">' + data["name"] + '</a>';
        } else {
            dom += '<a href="' + data["url"] + '" >' + data["name"] + '</a>';
        }
        dom += '</li>';
        return dom;
    },
    // 顶部菜单隐藏DOM
    top_menu_hide_dom: function (data) {
        var dom = '';
        var active = data["active"] === "yes" ? "active" : "";
        if (data["active"] === "yes") {
            $(".nav-main-bar-hide").addClass("nav_main_active");
        }
        dom += '<a href="' + data["url"] + '" class="item ' + active + '" data-text="' + data["name"] + '">' + data["name"] + '</a>';
        return dom;
    },
    //body点击空白，隐藏
    body_click_event: function () {
        $(document).mouseup(function (e) {


            //控件更新
            var _widget = $('.widget_input');

            if ((!_widget.is(e.target) && _widget.has(e.target).length === 0 && $(e.target).closest(".combo-p").length === 0) || (!$(e.target).hasClass("widget-show") && $(e.target).closest(".widget-show").length === 0 && $(e.target).closest(".combo-p").length === 0)) {
                Strack.widget_update();
            }

            if($(e.target).closest('.st-down-menu').length > 0 || $(e.target).closest('.dropdown').length >0){
                Strack.G.isClickDropdown.status = true;
                Strack.G.isClickDropdown.target = $(e.target).closest('.dropdown');
            }else {
                Strack.G.isClickDropdown.status = false;
                Strack.G.isClickDropdown.target = $(e.target).closest('.dropdown');
                $('.ui.menu , .ui.dropdown').dropdown("hide");
            }


            //更新project name
            var _ptitle = $("#project_top_name");
            if (!_ptitle.is(e.target) && _ptitle.has(e.target).length === 0) {
                if (_ptitle.is(":visible")) {
                    obj.modify_project_name(_ptitle);
                }
            }

            //隐藏过滤字段
            var _filter = $(".filter-task-list");
            if (!_filter.is(e.target) && _filter.has(e.target).length === 0) {
                _filter.slideUp(100);
            }

            //关闭layer
            var _laytips = $(".layui-layer-content");
            if (!_laytips.is(e.target) && _laytips.has(e.target).length === 0 && $('.layui-layer-tips').length > 0) {
                layer.tips("close");
            }

            //关闭datagrid 正在编辑框
            var _dg_table = $(".datagrid-btable");
            if (!_dg_table.is(e.target) && _dg_table.has(e.target).length === 0 && $(e.target).closest(".combo-p").length == 0) {
                var $_edit = $(".datagrid-editable");
                if ($_edit.length > 0) {
                    var index = parseInt($_edit.closest(".datagrid-row").attr("datagrid-row-index"));
                    var dg = $_edit.closest(".datagrid-view").find(".datagrid-f");
                    dg.datagrid("endEdit", index);
                }
            }
        });
    }
};

//JS全局变量
Strack.G = {
    userId: 0,
    Default_Mail: '@strack.com',
    Jcrop_Thumb: '',
    Jcrop_Thumb_Ext: '',
    Note_Uploadifive_Imgs: [],
    Note_Delete_Img_Ids: [],
    Note_Has_Img_Length: 0,
    Jcrop_Canvas: '',
    Media_Server: {},
    cnotedom: '',
    topMenuActive: false,
    Geditor: {},
    GeditorParam: {},
    MDeditor: null,
    Gfilter_data: {},
    Group_data: {},
    Gfilter_list: {},
    GanttFilter: {},
    MediaFilter: {},
    WebplayerPage: false,
    GacPlaylist: [],
    Gmindex: 0,
    GridPage: {},
    KankanItem: {},
    FilterAutoCheck: false,
    FilterProjFirst: 0,
    FilterStepsFirst: 0,
    FilterData: {},//过滤面板已经选择了的参数
    FilterProj: '',//过滤面板project filter是否选中
    FilterEntity: '',//过滤面板entity filter是否选中
    FilterTopJob: {},//顶部Job参数
    FilterTopMsg: {},//顶部Msg参数
    InputExCkfields: {},//导入excel必须字段
    CustomEditIndex: [],
    MenuName: '',
    ProjectId: 0,
    ModuleId: 0,
    ModuleType: 0,
    AccMenu: '',
    TlStart: 0,
    TllogTerval: {},
    SumFilters: null,//自定义字段统计字段data
    IsNewfileds: false,
    Gplaylistid: 0,
    GridStepsHidelist: [],
    FrameRates: {film: 24, NTSC: 29.97, NTSC_Film: 23.98, NTSC_HD: 59.94, PAL: 25, PAL_HD: 50, web: 30, high: 60},
    Timesheet: 'now',
    TimesheetOld: '',
    FilterWidget: [],
    CurrentView: {},
    ViewsetData: {},
    DialogAddSetting: {},
    ImgViewzoom: 1,
    ImgZoomSpeed: 0.1,
    ImgZoomX: 0,
    ImgZoomY: 0,
    Project_Menu: [],
    comboxItemType: 0,
    comboxItemDom: '',
    comboxStepDom: '',
    groupview: null,
    gridFieldCache: {},
    leftScrolling: 0,
    TopMenuData: [],
    jsonEditor: {},
    entityStepTaskAddData: {status: false, data: {}},
    importExcelStep: null,
    importExcelData: {},
    mediaScreenshotStatus: false,
    gridFirstColMap: {},
    gridSliderActiveTab: {},
    gridSliderParam: {},
    mediaViewPlayIndex: 0,
    closeNoteObj : null,
    horizontalRelationIds: {'add':[], 'delete':[]},
    UnReadMessageData: null,
    topfieldsRequestParam: {},
    sliderTopfieldsRequestParam: {},
    sideTimelogParam: {},
    dataGridStepColunmsConfig: {},
    isClickDropdown: {
        status : false,
        target: ''
    },
    infoMediaNeedInit : [],
    gridMediaNeedInit : [],
    batchUploadMediaType: '',
    pageHiddenParam: {}
};

// websocket 封装
Strack.Websocket = {
    // Websocket 对象列表
    List: {},
    heartbeatList: {},
    // 初始化 Websocket 对象
    init : function (name, param) {
        if (window.WebSocket) {
            if(!Strack.Websocket.List[name]){
                // 没有实例化
                var bg_color = '';
                if($(".st-bg-black").length > 0){
                    bg_color = "black";
                }else {
                    bg_color = "white";
                }
                $('.pushable').prepend(Strack.loading_dom(bg_color, StrackLang["Starting_Action"], 'run_action'));

                var ws = new WebSocket(param.url);
                ws.onopen = function (evt) {
                    // 已经成功连接 Websocket 服务
                    Strack.Websocket.List[name] = ws;
                    // 开启心跳维持
                    Strack.Websocket.heartbeat(name);
                    if(param.afterInit){
                        $("#st-load_run_action").remove();
                        param.afterInit({
                            status : 'new',
                            data : evt
                        });
                    }
                };
                ws.onclose = function (evt) {
                    // 关闭 Websocket 服务
                    if(param.onClose){
                        param.onClose(evt.data);
                    }
                };
                ws.onmessage = function (evt) {
                    // 响应接收消息
                    if(param.onMessage){
                        param.onMessage(evt.data);
                    }
                };
                ws.onerror = function (evt) {
                    // 错误接收消息
                    Strack.Websocket.close(name);
                    if(param.afterInit){
                        $("#st-load_run_action").remove();
                        param.afterInit({
                            status : 'error',
                            data : evt,
                            message : 'Connection error.'
                        });
                    }
                };
            }else {
                // 不支持 WebSocket
                if(param.afterInit){
                    param.afterInit({
                        status : 'exist'
                    });
                }
            }
        }else {
            // 不支持 WebSocket
            if(param.afterInit){
                param.afterInit({
                    status : 'error',
                    message : 'No support for webSocket.'
                });
            }
        }
    },
    // 绑定用户id
    bind: function(name, data){
        Strack.Websocket.List[name].send(JSON.stringify({
            "method" : "bind",
            "data" : data
        }));
    },
    // 心跳维持
    heartbeat : function(name)
    {
        if(Strack.Websocket.List[name]){
            // 每半分钟发起一次心跳检测
            Strack.Websocket.heartbeatList[name] = window.setInterval(function(){
                Strack.Websocket.List[name].send(JSON.stringify({"method": "heartbeat"}));
            }, 30000);
        }
    },
    // 发送消息
    send : function(name, data){
        Strack.Websocket.List[name].send(JSON.stringify(data));
    },
    // 删除 Websocket 对象
    close : function (name) {
        var new_list = {};
        var new_heartbeat_list = {};
        if(Strack.Websocket.List[name]){
            // 发送关闭消息
            Strack.Websocket.List[name].send('close');
            Strack.Websocket.List[name].close();
            for(var key in Strack.Websocket.List){
                if(name !== key){
                    new_list[key] = Strack.Websocket.List[key];
                }
            }
            Strack.Websocket.List = new_list;

            clearInterval(Strack.heartbeatList.List[name]);
            for(var key_h in Strack.heartbeatList.List){
                if(name !== key_h){
                    new_heartbeat_list[key_h] = Strack.heartbeatList.List[key_h];
                }
            }
            Strack.heartbeatList.List = new_heartbeat_list;
        }
    }
};

// 浏览器桌面消息通知
Strack.Notify = {
    obj : null,
    // 初始化
    init : function () {
        // 音频属性
        // audio:{
        //     file: StrackPHP['IMG']+ '/notify.mp4'
        // },
        Strack.Notify.obj = new Notify({
            effect: 'flash',
            interval: 500,
            notification:{
                title: 'Notification',
                icon: StrackPHP['IMG'] + '/strack_notice.ico',
                body: 'You have a new message!'
            }
        });
    },
    show: function (title, body) {
        Strack.Notify.obj.notify({
            title: title,
            body: body
        });
    }
};

// 数据更新机制
Strack.update = {
    // 初始化更新服务
    init : function(){
        $.ajax({
            type: 'POST',
            url: StrackPHP['getLogServerConfig'],
            dataType: "json",
            success: function (data) {
                if(data["active"] === "yes" && data["websocket_url"]){
                    Strack.Websocket.init('update',{
                        url: data["websocket_url"]+"?sign="+data["token"],
                        afterInit : function (data) {
                            if(data["status"] === "error"){
                                console.log("ws error:"+data["message"]);
                            }
                        },
                        onMessage: function (data) {
                            var message = JSON.parse(data);
                            switch (message["type"]){
                                case "connect":
                                    Strack.Websocket.bind("update", Strack.get_page_uuid());
                                    break;
                                case "message":
                                    Strack.update.message(message);
                                    break;
                            }
                        }
                    });
                }
            }
        });
    },
    // 获取脏数据刷新
    refresh : function () {

    },
    // 更新消息通知
    message : function (data) {
        var title = '',
            body = '';

        // 更新未读消息数据
        if($.inArray(Strack.G.userId, data["member"]) >=0){
            // 自己的消息才更新
            Strack.G.UnReadMessageData.created = data["created"];
            Strack.G.UnReadMessageData.massage_number = Strack.G.UnReadMessageData.massage_number + 1;
            Strack.top_tool_number('#top_msg_number', Strack.G.UnReadMessageData.massage_number);

            switch (data["message"]["operate"]){
                case "update":
                    title += StrackLang["Modify"]+'-'+data["module_data"]["name"];
                    body += data["message"]["title"]["created_by"]+' '+ StrackLang["Modify"]+' '+data["message"]["title"]["module_name"]+' '+data["message"]["title"]["item_name"];
                    break;
                case "create":
                    title += StrackLang["Create"]+'-'+data["module_data"]["name"];
                    body += data["message"]["title"]["created_by"]+' '+ StrackLang["Create"]+' '+data["message"]["title"]["module_name"]+' '+data["message"]["title"]["item_name"];
                    break;
                case "delete":
                    title += StrackLang["Delete"]+'-'+data["module_data"]["name"];
                    body += data["message"]["title"]["created_by"]+' '+ StrackLang["Delete"]+' '+data["message"]["title"]["module_name"]+' '+data["message"]["title"]["item_name"];
                    break;
            }

            Strack.Notify.show(title, body);
        }

        data.status = 200;
        switch (data.from_type){
            case "thumb":
                // 缩略图处理
                Strack.update.thumbnail(data);
                break;
            case "note":
                // 反馈处理
                Strack.update.note(data);
                break;
            case "widget_common":
                // 通用控件处理
                Strack.update.widget(data, data["param"]["widget_param"]);
                break;
        }
    },
    // 更新通用控件
    widget : function (data, f_param) {
        var $up_item;
        var bg_clolor = '';
        var param = data.param;
        var update = data.data;

        if(f_param.editor !== "media"){
            $up_item = $("."+f_param.dom);
            var $widget_edit = $up_item.find(".widget-edit");
            var $info_content_show = $up_item.find(".info-content-show");
            $widget_edit.attr("data-value", param.val);  // 更新控件值

            if(update.value_show && update.value_show.hasOwnProperty("rows")){
                var list_val = [];
                if(update.value_show.total > 0 && update.hasOwnProperty('custom_config') && update.custom_config.field_type === "belong_to"){
                    switch (update.custom_config.relation_module_code){
                        case 'status':
                            bg_clolor = Strack.hex_to_rgb(update.value_show.rows[0].color, 0.3);
                            $up_item.css("background-color", bg_clolor);
                            $info_content_show.html(Strack.widget_status_dom(update.value_show.rows[0].icon,
                                update.value_show.rows[0].name,
                                update.value_show.rows[0].color
                            ));
                            break;
                        default:
                            update.value_show.rows.forEach(function (val) {
                                list_val.push(val["name"]);
                            });
                            $info_content_show.html(list_val.join(","));
                            break;
                    }
                }else {
                    update.value_show.rows.forEach(function (val) {
                        list_val.push(val["name"]);
                    });
                    $info_content_show.html(list_val.join(","));
                }
            }else {
                $info_content_show.html(update.value_show);
            }
            Strack.update.excessive_color(data.status, $up_item, bg_clolor);
        }

        // 查找看有没有表格区域字段需要更新
        var $grid_up_item = $("td[id="+f_param.dom+"]");
        if($grid_up_item.length >0 && $grid_up_item.hasClass("is-grid-td")){
            Strack.update.excessive_color(data.status, $grid_up_item, bg_clolor);
            switch (f_param.editor){
                case "media":
                    var media_data = data.data;
                    if(media_data["has_media"] === "yes"){
                        var min_size = "origin";
                        var min_w = 99999;
                        var m_w = 0;
                        media_data["param"]["size"].forEach(function (size) {
                            if(size !== "origin"){
                                m_w = size.split("x")[0];
                                if(m_w < min_w){
                                    min_size = size;
                                }
                            }
                        });
                        var thumb_url = media_data["param"]["base_url"]+"/"+media_data["param"]["md5_name"]+"_"+min_size+"."+media_data["param"]["ext"];
                        f_param.dom.find(".athumb")
                            .empty()
                            .append('<img src="'+thumb_url+'">');
                    }
                    break;
                default:
                    // 刷新一行数据
                    setTimeout(function () {
                        var grid_id = $grid_up_item.attr("data-grid");
                        var grid_field = $grid_up_item.attr("field");
                        var $grid = $("#"+grid_id);
                        var grid_index = $grid_up_item.closest(".datagrid-row").attr("datagrid-row-index");
                        var grid_row = $grid.datagrid('getRow', grid_index);
                        grid_row[grid_field] = update.value_show;
                        $grid.datagrid("updateRow", {
                            index: grid_index,
                            row: grid_row
                        });
                    }, 600);
                    break
            }
        }
    },
    // 更新Note
    note : function (data) {
        var $list_class = $('.'+data["param"]["list_class"]+"_"+data["data"]["link_id"]);
        switch (data["operate"]){
            case "add":
                if(data["data"]["stick"] === "yes"){
                    $list_class.find(".note-stick").prepend(Strack.notes_single_item_dom(data["data"], 'add'));
                }else {
                    $list_class.find(".note-no-stick").prepend(Strack.notes_single_item_dom(data["data"], 'add'));
                }

                Strack.init_note_att_event(data["data"]["id"]);
                break;
            case "update":
                // 得判断当前stick和原有stick是否一致
                var $comment_note_item = $(".comment_note_"+data["data"]["id"]);
                var item_dom = Strack.notes_single_item_dom(data["data"], 'modify');
                if($comment_note_item.attr("stick") !== data["data"]["stick"]){
                    $comment_note_item.remove();
                    if(data["data"]["stick"] === "yes"){
                        $list_class.find(".note-stick").prepend(Strack.notes_single_item_dom(data["data"], 'add'));
                    }else {
                        $list_class.find(".note-no-stick").prepend(Strack.notes_single_item_dom(data["data"], 'add'));
                    }
                }else {
                    $comment_note_item.empty().append(item_dom);
                }
                Strack.init_note_att_event(data["data"]["id"]);
                break;
            case "delete":
                $(".comment_note_"+data["data"]["id"]).remove();
                break;
        }
        Strack.update.fix_note_stick_class($list_class);
    },
    // 修正Note固定区域样式
    fix_note_stick_class: function($list_class)
    {
        var $note_stick = $list_class.find(".note-stick");
        if($note_stick.find(".comment").length >0){
            $note_stick.addClass("note-stick-bottom");
        }else {
            $note_stick.removeClass("note-stick-bottom");
        }
    },
    // 更新缩略图
    thumbnail : function (data) {
        var $thumb_list = [];
        var from = '';
        if(data.param.relation_type === "direct"){
            // 直接关联media默认缩略图更新
            $thumb_list = $(".thumb-"+data.param.module_id+"-"+data.param.link_id);

        }else {
            // 水平一对一关联media缩略图更新
            $thumb_list = $("."+data.param.relation_custom_fields+"-"+data.param.module_id+"-"+data.param.link_id);
        }

        var thumb_type = '';
        var $parent = null;
        $thumb_list.each(function () {
            thumb_type = $(this).attr("thumb-type");
            switch (thumb_type){
                case "avatar":
                    $parent = $(this).parent()
                        .html(Strack.build_avatar( data["param"]["link_id"], data["param"]["thumb"], ''));
                    break;
                case "thumb":
                    $parent = $(this).parent();
                    var media_data = data['data'];
                    media_data['link_id'] = data["param"]["link_id"];
                    media_data['module_id'] = data["module_data"]["id"];
                    media_data['param']['icon'] =data["module_data"]["icon"];

                    if($parent.hasClass(".datagrid-cell")){

                    }

                    Strack.thumb_media_widget($parent[0], media_data, {modify_thumb:data["param"]["rule_thumb_modify"], clear_thumb: data["param"]["rule_thumb_clear"]});
                    break;
            }
        });
    },
    // 更新提示背景颜色
    excessive_color : function (status, $up_item, bg_clolor) {
        var process_color = parseInt(status) === 200 ? '#00FF54' : '#FF4739';
        var final_color = bg_clolor? bg_clolor: 'transparent';
        $up_item.css({
            'background-color': process_color,
            'transition': 'background-color 100ms ease-in',
            '-moz-transition': 'background-color 100ms ease-in',
            '-webkit-transition': 'background-color 100ms ease-in',
            '-o-transition': 'background-color 100ms ease-in'
        });
        setTimeout(function () {
            $up_item.css({
                'background-color': final_color,
                'transition': 'background-color 300ms ease-in',
                '-moz-transition': 'background-color 300ms ease-in',
                '-webkit-transition': 'background-color 300ms ease-in',
                '-o-transition': 'background-color 300ms ease-in'
            });
        }, 300);
    }
};

// 全局提示条
Strack.notice = {
    license : function (lic_data) {
        // license 即将过期提示
        var last_notice_date = parseInt(Strack.read_storage("last_notice_date"));
        if(parseInt(lic_data["expiry_days"]) < 30 && last_notice_date !== parseInt(lic_data['last_notice_date'])){
            //当系统小于30天时候提醒续费 一天只显示一次

            Strack.save_storage("last_notice_date", lic_data['last_notice_date']);

            var expire_msg = Strack.notice.dom({
                bg_color : 'notice-color-red',
                count_down : '10 S',
                content : StrackLang["License_Warn_Notice_1"]+' '+lic_data["expiry_date"]+' '+StrackLang["License_Warn_Notice_2"]+' '+StrackLang["License_Warn_Notice_3"],
                content_css : '',
                close : true
            });

            $("body").addClass("has-top-notice-body")
                .before(expire_msg);

            // 10S后自动关闭
            Strack.notice.auto_close(10);
        }
    },
    // 提示是demo项目
    demo_project: function (data) {
        if(!$.isEmptyObject(data)){
            // 判断是否有顶部提示消息
            var time = 1;
            if($(".globel-top-notice").length >0){
                // 10秒后主动关闭提示并替换成 demo 项目提示
                time = 10010;
            }

            setTimeout(function () {
                if ($(".globel-top-notice").length > 0) {
                    Strack.close_notice_message();
                }

                var content = Strack.notice.dom({
                    bg_color : 'notice-color-green',
                    count_down : '',
                    content : StrackLang["Project_Demo"]+'  '+data["name"],
                    content_css : 'text-align-center',
                    close : false
                });

                $("body").addClass("has-top-notice-body")
                    .before(content);

            }, time);
        }
    },
    // 顶部消息提示DOM
    dom: function (param) {
        var dom = '';

        dom += '<header class="globel-top-notice '+param["bg_color"]+'">'+
            '<div class="notice-count aign-left">'+param["count_down"]+'</div>'+
            '<div class="notice-content aign-left '+param["content_css"]+'">'+param["content"]+'</div>';

        if(param["close"]){
            dom +='<a href="javascript:;" class="notice-close aign-right" onclick="Strack.close_notice_message(this)">'+
                '<i class="icon-uniE6DB"></i>'+
                '</a>';
        }

        dom +='</header>';

        return dom;
    },
    // 自动关闭
    auto_close: function (time) {
        var count_warning = setInterval(function () {
            time--;
            $(".notice-count").html(time + ' S');
        }, time*100);

        setTimeout(function () {
            if ($(".globel-top-notice").length > 0) {
                Strack.close_notice_message();
            }
            clearTimeout(count_warning);
        }, time*1000);
    }
};

//公共预加载
$(function () {

    // 初始化所有下来菜单
    Strack.init_dropdown();

    // 页面点击事件绑定
    Strack.body_click_event();

    // 初始化浏览器桌面通知
    Strack.Notify.init();

    // 生成顶部菜单
    Strack.build_top_menu();

    // 顶部菜单信息加载
    Strack.top_header();

    //初始化后台菜单
    if (Strack.G.MenuName) {
        var $admin_mdom = $('#admin_' + Strack.G.MenuName);
        if ($admin_mdom.length) {
            var last_top = Strack.read_storage('admin_menu_top');


            var $scroll_mdom = $(".admin-page-left");
            $admin_mdom.addClass('admin-menu-active');

            var sh = 0;
            var s_height = document.documentElement.clientHeight;

            //滚动条滚动到指定位置
            if (last_top > 0) {
                sh = last_top;
            } else {
                $scroll_mdom.scrollTop(0);
                var am_offset = $admin_mdom.offset();
                sh = am_offset["top"] - s_height + 82;
            }

            if (sh > 0) {
                $scroll_mdom.scrollTop(sh);
            }
        }
    }

    // 激活个人页面菜单
    if (Strack.G.AccMenu) {
        $('#account-' + Strack.G.AccMenu).addClass('account-menu-active');
    }

    // 初始化页面更新机制
    Strack.update.init();
});