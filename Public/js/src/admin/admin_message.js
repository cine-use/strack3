$(function () {
    obj = {
        save_message_setting: function () {
            var settings = {};
            $(".open-switch").each(function () {
                settings[$(this).attr("id")] = Strack.get_switch_val(this);
            });

            $.ajax({
                type: 'POST',
                url: MessagePHP['saveMessageSetting'],
                dataType: "json",
                contentType: "application/json",
                data: JSON.stringify(settings),
                beforeSend: function () {
                    $('#active-notice').append(Strack.loading_dom("white", "", "message"));
                },
                success: function (data) {
                    if (parseInt(data['status']) === 200) {
                        Strack.top_message({bg: 'g', msg: data['message']});
                    } else {
                        layer.msg(data["message"], {icon: 7, time: 1200, anim: 6});
                    }
                    $("#st-load_message").remove();
                }
            });

        }
    };

    getReminderSetting();

    /**
     * 获取后台消息提醒设置
     */
    function getReminderSetting() {
        $.ajax({
            type: 'POST',
            url: MessagePHP['getMessageSetting'],
            dataType: "json",
            beforeSend: function () {
                $('#active-notice').append(Strack.loading_dom("white", "", "message"));
            },
            success: function (data) {

                $(".open-switch").each(function () {
                    Strack.init_open_switch({
                        dom: this,
                        value: data[$(this).attr("id")],
                        onText: StrackLang['Switch_ON'],
                        offText: StrackLang['Switch_OFF'],
                        width: 100
                    });
                });


                $("#st-load_message").remove();
            }
        });
    }
});
