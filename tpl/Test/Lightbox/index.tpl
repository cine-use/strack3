<extend name="tpl/Base/common.tpl"/>

<block name="head-title"><title>{$Think.lang.Task_Title}</title></block>

<block name="head-js">

</block>
<block name="head-css">
    <script type="text/javascript">
        // 当前页面参数
        Strack.G.MenuName = "test";
    </script>
</block>

<block name="main">




    <div id="lg_comments">
        <div  class="lg-comments" data-width="400">
            <div class="lg-header">
                反馈详情
            </div>
            <div class="lg-comments-main">

            </div>
        </div>
    </div>


    <div id="comment-box">
        <a data-poster="__ROOT__/App/Test/lightbox/video.jpg"  data-html="#video2" >
            <img class="img-responsive" src="__ROOT__/App/Test/lightbox/video.jpg">
        </a>
        <a data-responsive="__ROOT__/App/Test/lightbox/13-375.jpg 375, __ROOT__/App/Test/lightbox/13-480.jpg 480, __ROOT__/App/Test/lightbox/13.jpg 800" data-src="__ROOT__/App/Test/lightbox/13-1600.jpg" >
            <img src="__ROOT__/App/Test/lightbox/thumb-13.jpg" />
        </a>
        <a data-responsive="__ROOT__/App/Test/lightbox/4-375.jpg 375, __ROOT__/App/Test/lightbox/4-480.jpg 480, __ROOT__/App/Test/lightbox/4.jpg 800" data-src="__ROOT__/App/Test/lightbox/4-1600.jpg" >
            <img src="__ROOT__/App/Test/lightbox/thumb-4.jpg" />
        </a>
    </div>

    <div style="display:none;" id="video2">
        <video class="lg-video-object lg-html5" controls preload="none" loop="loop" height="90%">
            <source src="__ROOT__/App/Test/lightbox/video.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
    </div>



    <script>

        //var commentBox = document.getElementById('comment-box');

        lightGallery(document.getElementById('comment-box'), {
            appendSubHtmlTo: '.lg-item',
            addClass: 'lg-comments',
            mode: 'lg-fade',
            enableDrag: false,
            enableSwipe: false
        });


        // 切换事件回调
        commentBox.addEventListener('onAfterSlide', function(event) {
            var items = document.querySelectorAll('.lg-outer .lg-item');
        });


    </script>
</block>