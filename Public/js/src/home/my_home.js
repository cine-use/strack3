$(function(){
    obj= {
        //切换左侧导航显示
        switch_tab: function (i) {
            var tab_name = $(i).data("tab");
            switch_tab(tab_name);
        }
    };


    $('.grid-stack').gridstack();



    Strack.js("head_js", MyHomePHP["scheduler_js"]);
    load_my_timelog();


    var pswpElement = document.querySelectorAll('.pswp')[0];

// build items array
    var items = [
        {
            src: 'https://placekitten.com/600/400',
            w: 600,
            h: 400
        },
        {
            src: 'https://placekitten.com/1200/900',
            w: 1200,
            h: 900
        }
    ];

// define options (if needed)
    var options = {
        // optionName: 'option value'
        // for example:
        index: 0 // start at first slide
    };

// Initializes and opens PhotoSwipe
    var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();


    /**
     * 初始化 timelog 面板
     */
    function load_my_timelog() {
        $('#my_timelog').fullCalendar({
            header: {
                left: 'today prev,next',
                center: 'title',
                right: 'basicDay,basicWeek,month,listWeek,'
            },
            contentHeight: Strack.panel_height("#my_timelog",39),
            defaultView: 'month',
            defaultDate: Strack.date_format(new Date(),"yyyy-MM-dd"),
            selectable: true,
            navLinks: true,
            eventLimit: true,
            windowResize:function (view) {
                $(this).fullCalendar('option', 'contentHeight', Strack.panel_height("#my_timelog",39));
            },
            events: function(start, end, timezone, callback) {

            },
            //框选新建个人events
            select:function( start, end, jsEvent, view, resource ){
                var edata ={};
                edata["event_id"] = "";
                edata["desc"] = "";
                edata["duration"] =  Strack.getTime2Time(end.format(), start.format());
                edata["start"] = start.format();
                edata["action"] = "add";
            },
            //编辑个人events
            eventClick:function( event, jsEvent, view ) {

            },
            //Event 伸缩事件
            eventResize:function (event, delta, revertFunc, jsEvent, ui, view ) {

            },
            //Event 拖拽事件
            eventDrop:function ( event, delta, revertFunc, jsEvent, ui, view) {

            },
            eventMouseover:function (event, jsEvent, view) {

            },
            eventMouseout:function (event, jsEvent, view) {

            }
        });
    }

    function switch_tab(tab_name){
        $('.media-m-item').removeClass("media-m-w-active").each(function () {
            if ($(this).data("tab") == tab_name) {
                $(this).addClass("media-m-w-active");
            }
        });

        //激活 显示主窗口
        $('.pitem-wrap')
            .removeClass("active")
            .each(function () {
                if ($(this).data("tab") == tab_name) {
                    $(this).addClass("active");
                }
            });
    }
});

