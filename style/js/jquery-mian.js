if(window.location.toString().indexOf('pref=padindex') != -1){
}else{
    if(/AppleWebKit.*Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))){
        if(window.location.href.indexOf("?mobile")<0){
            try{
                if(/Android|Windows Phone|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
                    $("body").css("width","1200px")
                }else if(/iPad/i.test(navigator.userAgent)){
                    $("body").css("width","1200px")
                }else{
                    $("body").css("width","1200px")
                }
            }catch(e){}
        }
    }
}
$(function(){
    var numpic = $('#slides ul li').size()-1;
    var nownow = 0;
    var inout = 0;
    var TT = 0;
    var SPEED = 5000;
    var o = 0;
    var l = 0;
    $('#slides ul li').eq(0).siblings('li').css({'display':'none'});
    var ulstart = '<div id="pagination"><ul>',
        ulcontent = '',
        ulend = '</ul></div>';
    ADDLI();
    var pagination = $('#pagination ul li');
    var left1 = $('#slides > p.left');
    var right1 = $('#slides > p.right');
    var paginationwidth = $('#pagination').width();

    pagination.eq(0).addClass('current')

    function ADDLI(){
        //var lilicount = numpic + 1;
        for(var i = 0; i <= numpic; i++){
            ulcontent += '<li>' + '<a href="#">' + (i+1) + '</a>' + '</li>';
        }

        $('#slides').after(ulstart + ulcontent + ulend);
    }
    pagination.on('click',DOTCHANGE);
    left1.on('click',left);
    right1.on('click',right);
    function right(){
        if(TT)clearInterval(TT);
        var NN = nownow+1;
        if( inout == 1 ){
        } else {
            if(nownow < numpic){
                var t = o++;
                $('#slides ul li').eq(nownow).css('z-index','900');
                $('#slides ul li').eq(NN).css({'z-index':'800'}).fadeIn();
                pagination.eq(NN).addClass('current').siblings('li').removeClass('current');
                $('#slides ul li').eq(nownow).fadeOut(900,function(){$('#slides ul li').eq(NN).fadeIn(1000);});
                nownow += 1;
            }else{
                NN = 0;
                var t = o--;
                $('#slides ul li').eq(nownow).css('z-index','900');
                $('#slides ul li').eq(NN).stop(true,true).css({'z-index':'800'}).fadeIn();
                $('#slides ul li').eq(nownow).fadeOut(900,function(){$('#slides ul li').eq(0).fadeIn(1000);});
                pagination.eq(NN).addClass('current').siblings('li').removeClass('current');
                nownow=0;

            }
        }
        TT = setTimeout(GOGO, SPEED);
    }
    function left(){
        if(TT)clearInterval(TT);
        var NN = nownow+1;
        if( inout == 1 ){
        } else {
            if(nownow < numpic){
                var t = o++;
                $('#slides ul li').eq(nownow).css('z-index','900');
                $('#slides ul li').eq(NN).css({'z-index':'800'}).fadeIn();
                pagination.eq(NN).addClass('current').siblings('li').removeClass('current');
                $('#slides ul li').eq(nownow).fadeOut(900,function(){$('#slides ul li').eq(NN).fadeIn(1000);});
                nownow += 1;
            }else{
                NN = 0;
                var t = o--;
                $('#slides ul li').eq(nownow).css('z-index','900');
                $('#slides ul li').eq(NN).stop(true,true).css({'z-index':'800'}).fadeIn();
                $('#slides ul li').eq(nownow).fadeOut(900,function(){$('#slides ul li').eq(0).fadeIn(1000);});
                pagination.eq(NN).addClass('current').siblings('li').removeClass('current');
                nownow=0;

            }
        }
        TT = setTimeout(GOGO, SPEED);
    }

    function DOTCHANGE(){
        if(TT)clearInterval(TT);
        var changenow = $(this).index();
        $('#slides ul li').eq(nownow).css('z-index','900');
        $('#slides ul li').eq(changenow).css({'z-index':'800'}).fadeIn();
        pagination.eq(changenow).addClass('current').siblings('li').removeClass('current');
        $('#slides ul li').eq(changenow).addClass('on').siblings().removeClass('on');

        $('#slides ul li').eq(nownow).fadeOut(900,function(){$('#slides ul li').eq(changenow).fadeIn(1000);});
        nownow = changenow;
        TT = setTimeout(GOGO, SPEED);
    }

    pagination.mouseenter(function(){
        inout = 1;
    })

    pagination.mouseleave(function(){
        inout = 0;
    })
    function GOGO(){
        var NN = nownow+1;
        if( inout == 1 ){
        } else {
            if(nownow < numpic){
                var t = o++;
                $('#slides ul li').eq(nownow).css('z-index','900');
                $('#slides ul li').eq(NN).css({'z-index':'800'}).fadeIn();
                pagination.eq(NN).addClass('current').siblings('li').removeClass('current');
                $('#slides ul li').eq(nownow).fadeOut(900,function(){$('#slides ul li').eq(NN).fadeIn(1000);});
                nownow += 1;
            }else{
                NN = 0;
                var t = o--;
                $('#slides ul li').eq(nownow).css('z-index','900');
                $('#slides ul li').eq(NN).stop(true,true).css({'z-index':'800'}).fadeIn();
                $('#slides ul li').eq(nownow).fadeOut(900,function(){$('#slides ul li').eq(0).fadeIn(1000);});
                pagination.eq(NN).addClass('current').siblings('li').removeClass('current');
                nownow=0;

            }
        }
        TT = setTimeout(GOGO, SPEED);
        $("#slides ul li").removeClass("on").eq(t).addClass("on");
    }
    GOGO();
})



function goTop(acceleration, time) {
    acceleration = acceleration || 0.1;
    time = time || 16;
    var x1 = 0;
    var y1 = 0;
    var x2 = 0;
    var y2 = 0;
    var x3 = 0;
    var y3 = 0;
    if (document.documentElement) {
        x1 = document.documentElement.scrollLeft || 0;
        y1 = document.documentElement.scrollTop || 0;
    }
    if (document.body) {
        x2 = document.body.scrollLeft || 0;
        y2 = document.body.scrollTop || 0;
    }
    var x3 = window.scrollX || 0;
    var y3 = window.scrollY || 0;
    var x = Math.max(x1, Math.max(x2, x3));
    var y = Math.max(y1, Math.max(y2, y3));
    var speed = 1 + acceleration;
    window.scrollTo(Math.floor(x / speed), Math.floor(y / speed));
    if (x > 0 || y > 0) {
        var invokeFunction = "goTop(" + acceleration + ", " + time + ")";
        window.setTimeout(invokeFunction, time);
    }
    return false;
}



function lo(){
    $(document).ready(function () {
        $(window).scroll(function () {
            var a = $(".Nmerkn").offset().top;
            var lo = ($(window).scrollTop());
            //console.log(lo);
            if (a >= $(window).scrollTop() && a < ($(window).scrollTop() + $(window).height())) {
                $(".Nmerkn").addClass("plg")
            }else{
                $(".Nmerkn").removeClass("plg")
            }
        });
    });

}
$(".glkomr ul li img").hover(function(){
     l= $(this).attr('src');
    $(this).attr('src',$(this).attr("d"))
},function(){
    $(this).attr('src',l)
})

$(".top-cnt ul li span").on('click',function(){
    if($(this).hasClass("on")){
        $(this).removeClass("on");
        $(this).siblings("p").stop(true,true).animate({height:'0'});
    }else{
        $(this).addClass("on");
        $(this).siblings("p").stop(true,true).animate({height:'210px'});
    }
})
$(".top-cnt ul li p em").click(function(){
    var ol = $(this).text();
    $(this).parents("p").stop(true,true).animate({height:'0'});
    $(this).parents("p").siblings("span").removeClass("on");
    $(".top-cnt ul li span").text(ol)
})




















































