$(function(){
    var admin_mhide = Strack.read_storage("Admin_Menu_hide");
    if(!admin_mhide){
        admin_mhide ={
            'general':0,
            'systems':0,
            'user':0,
            'project':0,
            'advance':0
        }
    }else {
        admin_mhide = JSON.parse(admin_mhide);
    }

    /*初始化隐藏*/
    $('.sidebar_hide').each(function(){
        var mhide = $(this).data("type");
        if(admin_mhide[mhide]==1){
            show_hide_menu(this,admin_mhide,0);
        }
    }).on("click",function(){
        show_hide_menu(this,admin_mhide,200);
        Strack.save_storage("Admin_Menu_hide",JSON.stringify(admin_mhide));
    });

    /**
     * 隐藏菜单
     * @param i
     * @param admin_mhidem
     * @param time
     */
    function show_hide_menu(i,admin_mhidem,time){
        var $this =$(i),
            hdom = "#sidebar-admin-"+$this.data("hide"),
            tname = $this.data("type");
        if($(hdom).hasClass("nav-show")){
            $(hdom).hide(time)
                .removeClass("nav-show");
            $(i).find("i")
                .removeClass("icon-uniF106")
                .addClass(" icon-uniF107");
            admin_mhide[tname]=1;
        }else{
            $(hdom).show(time)
                .addClass("nav-show");
            $(i).find("i")
                .removeClass("icon-uniF107")
                .addClass(" icon-uniF106");
            admin_mhide[tname]=0;
        }
    }
});