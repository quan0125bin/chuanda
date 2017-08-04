$.getScript("./style/js/basic.js");
$("<link>").attr({rel:"stylesheet",type:"text/css",href:"./style/css/public.css"}).appendTo("head");
$('.sub').live('click',function(){$(this).parents('form').submit();return false;})//表单触发
$('.subFormClick').live('click',function(){$(this).parents('.min').find('form').submit();return false;})//表单触发
$('.inp input,.textarea textarea').live('keydown keyup focus blur',function(e){
    if(e.type=='focusin'){
	   $(this).parent().find('.tit').css('opacity','.3');
    }else if(e.type=='focusout'){
	   $(this).parent().find('.tit').css('opacity','1');
    }
    if($(this).val()){
	   $(this).parent().addClass('focus')
	   if(!$(this).parent().hasClass('val'))$(this).parent().addClass('val');
    }else{
	   $(this).parent().removeClass('focus')
    }
})
/************展开******************************/
$('.openClick').live('click',function(){
    var $p=$(this).parent();
    if($p.hasClass('close')){
	   $p.removeClass('close').find('.openBox').slideDown(500);
    }else{
	   $p.addClass('close').find('.openBox').slideUp(500);
    }
})
/************删除***************************/
$('.delClick').live('click',function(){
    var obj=$(this),data={action:'del'};
    if(!obj.attr('sdata') && obj.attr('del')){
	   eval(obj.attr('del'));return false;
    }
    data['sdata']=obj.attr('sdata');
    delFun(obj,data);
    return false;
})
$('.delClicks').live('click',function(){
    var obj=$(this),data={action:'dels',sdata:''};
    $('.check_list:checked').each(function(){
	   if(data.sdata)data.sdata+=',';
	   data.sdata+=$(this).val();
    })
    if(!data.sdata){
	   alertLj('请选择需要删除的数据');return false;
    }
    delFun(obj,data);
    return false;
})
$('.faq').live('mousemove mouseout',function(e){
    if(e.type=='mouseout'){
	    $('.faqBox').remove();
    }else{
	   if($('.faqBox').size()<1)$('body').append('<div class="faqBox"></div>');
	   var obj=$('.faqBox');
	   var fleft=e.originalEvent.x || e.originalEvent.layerX || 0; 
	   var ftop=e.originalEvent.y || e.originalEvent.layerY || 0; 
	   if($(window).width()-fleft<obj.width() && $(window).width()-fleft<fleft){
		  obj.html($(this).html()).css({right:$(window).width()-fleft,top:ftop+5});
	   }else{
		  if($(window).width()-fleft<obj.width()){
			 obj.css({width:$(window).width()-fleft-30})
		  }
		  obj.html($(this).html()).css({left:fleft+5,top:ftop+5});
	   }
    }
})
function delFun(obj,data){
    if(!obj.hasClass('ljsure')){
	   var ljsure='ljsure'+(parseInt(Math.random()*1000+1));
	   obj.addClass(ljsure);alertLj('确定删除？',{title:'确定删除？',click:"$('."+ljsure+"').addClass('ljsure').attr('addClass','"+ljsure+"').click();",cancel:true});return false;
    }
    obj.removeClass(obj.attr('addClass')+' ljsure');
    if(obj.hasClass('lj'))return false;
	$.ajax({
	   type:'post',data:data,url:basic.path+'handle/post/',dataType:'json',beforeSend:function(XMLHttpRequest){
		  basicHeader(XMLHttpRequest,'json');obj.addClass('lj');alertLj('load');
	   },success:function(msg){
		  obj.removeClass('lj');
		  if(msg.error>0){
			 alertLj(msg.html);
		  }else if(msg.error==0){
			 if(obj.attr('del')){
				eval(obj.attr('del').replace('$(this)','obj'));
				alertLjClose();
			 }else{
				alertLj(msg.html,{click:"alertLjClose($('.refreshFormClick').click())"});
			 }
		  }else{
			 alertLj(msg.html,{ok:'未知错误，刷新页面',click:"window.location.reload()",cancel:false});
		  }
	   },error:function(error){
		  obj.removeClass('lj')
		  errHandle(error);
	   }
    })
}
/************状态******************************/
$('.stateClick').live('click',function(){
    var obj=$(this),data={action:'state'};
    data['sdata']=obj.attr('sdata');
    quiUpdate(data,obj);
    return false;
})
function quiUpdate(data,obj){
    if(obj.hasClass('lj'))return false;
	$.ajax({
	   type:'post',data:data,url:basic.path+'handle/post/',dataType:'json',beforeSend:function(XMLHttpRequest){
		  basicHeader(XMLHttpRequest,'json');obj.addClass('lj');//alertLj('load');
	   },success:function(msg){
		  obj.removeClass('lj');
		  if(msg.error>0){
			 alertLj(msg.html);
		  }else if(msg.error==0){
			 if(obj.attr('addClass'))obj.removeClass(obj.attr('addClass')).addClass('state_'+msg.rest).attr('addClass','state_'+msg.rest);
		  }else{
			 alertLj(msg.html,{ok:'未知错误，刷新页面',click:"window.location.reload()",cancel:false});
		  }
	   },error:function(error){
		  obj.removeClass('lj')
		  errHandle(error);
	   }
    })
}
function basicHeader(request,type){
    request.setRequestHeader('Ac-Form',basic.form);
    request.setRequestHeader('Ac-Www',basic.www);
    request.setRequestHeader('Ac-Email',basic.email);
    var sign=$('meta[name="sign"]').attr('content');
    var vid=$('meta[name="vid"]').attr('content');
    if(sign)request.setRequestHeader('Ac-Sign',sign);
    if(vid)request.setRequestHeader('Ac-Vid',vid);
    if(type)request.setRequestHeader('Ac-Type',type);
}
function alertLj(str,obj,ppobj){
    if($('.alertLjBox').size())$('.alertLjBox').remove();
    if(!obj)obj={};
    if(!obj.title)obj.title='系统提示';
    if(!obj.ok)obj.ok='确认';
    var pobj=ppobj?ppobj:$('body'),pwobj=ppobj?(ppobj.attr('class')?ppobj:$(window)):$(window);
    var load='<img src="'+basic.path+'style/image/load.gif">',html,close='<a class="alertClose" onclick="alertLjClose()">关闭</a>',title='<div class="alertTitle">'+obj.title+'</div>',sure='<a class="alertSure">'+obj.ok+'</a>',cancel='<a class="alertCancel" onclick="alertLjClose()">取消</a>';
    var handle='<div class="alertHandle">'+sure+cancel+'</div>';
    html='<div class="alertBox">'+str+'</div>';
    html='<div class="alertLj">'+close+title+html+handle+'</div>';
    html='<div class="alertLjBox">'+html+'</div>';
    var cssLeft='-'+pwobj.width()+'px',cssTop=0;
    pobj.append(html).find('.alertLj').css({left:cssLeft,top:cssTop});
    if(obj.click){
	   $('.alertLj .alertSure').attr('onclick',obj.click);
    }else{
	   $('.alertLj .alertSure').attr('onclick','alertLjClose()');
    }
    if(obj.noClose)$('.alertLj .alertClose').remove();
    if(!obj.cancel)$('.alertLj .alertCancel').remove();
    if(obj.cancel && obj.cancelClick)$('.alertLj .alertCancel').attr('onclick',obj.cancelClick);
    if(str=='load'){
	   $('.alertLj').addClass('load').find('.alertBox').html(load);
	   $('.alertLj .alertClose').remove();
    }
    cssLeft=(pwobj.width()-$(".alertLj").width())/2;
    cssTop=(pwobj.height()-$(".alertLj").height())/2.5+pwobj.scrollTop();
    $('.alertLj').css({left:cssLeft,top:cssTop},300).fadeIn(300);
    $('.alertLjBox').height($(document).height());
}
function alertLjClose(fun){
    $('.alertLjBox').fadeOut(300,function(){
	   $(this).remove();fun
    });
}
function errHandle(error){
    if(error.status==810){
	   alertLj(error.responseText,{ok:'重新请求',click:'window.location.reload();',cancel:false,noClose:true});
    }else if(error.status==818){
	   alertLj(error.responseText,{ok:'刷新页面',click:'window.location.reload();',cancel:false,noClose:true});
    }else{
	   alertLj('服务器响应失败')
    }
}
function getUrl(res){
    var url=window.location.href.match(/[\?|#](.*)/);
    if(res){url=url?url[0]:'';url=url.split('#');}
    return url?url[0]:'';;
}
function getUrlAfter(){
    var url=window.location.href.match(/#(.*)/);
    url=url?url[0]:'';url=url.split('#');
    return url[1]?url[1]:'?action=home';;
}
/**文件上传显示操作**/
$.fn.upFileHandle=function(){
    var a,obj=$(this),cls=obj.attr('class'),box=obj.siblings('.'+obj.attr('box')),getTeam=function(v){
	   var n=v.img.split('.'),img=v.img;
	   if(n[1]=='mp4')img='video.png';
	   if(n[1]=='rar')img='zip.png';
	   if(n[1]=='zip')img='zip.png';
	   return '<div class="fileSwfBoxTeam"><img src="/upload/'+img+'" title="点击删除"><input type="hidden" value="'+v.img+'"><div class="inp val"><input type="text" value="'+v.name+'" maxlength="11"><p class="tit">alt</p></div></div>';
    },show=function(){
	   if(obj.val()){
		  $.each(eval(obj.val()),function(k,v){
			 box.append(getTeam(v));
		  })
		  click();
	   }
    },add=function(json){
	   box.append(getTeam(json));renew();click();
    },del=function(obj,oval){
	   oval.remove();renew();
    },click=function(){
	   box.find('.fileSwfBoxTeam img').click(function(){
		  if(!$(this).hasClass('delSure')){
			 var rand=Math.floor(Math.random()*100000+1);
			 $(this).addClass('delRand'+rand);
			 alertLj('确认删除?',{ok:'确认',click:"$('.delRand"+rand+"').addClass('delSure').click();alertLjClose()",cancel:true});return false;
		  }
		  del(obj,$(this).parent())
	   })
    },renew=function(){
	   var nval='';
	   box.find('.fileSwfBoxTeam').each(function(){
		  if(nval)nval+=',';
		  nval+="{'img':'"+$(this).find('input[type="hidden"]').val()+"','name':'"+$(this).find('input[type="text"]').val()+"'}";
	   })
	   if(nval)nval='['+nval+']';
	   obj.val(nval);
    }
    
    return {show:show,add:add,renew:renew};
}
$('.fileSwfBox .inp input').live('keyup',function(){
    if($(this).parents('.fileSwfBox').attr('val')){
	   var obj=$(this).parents('.fileSwfBox');
	   obj.siblings('input[name="'+obj.attr('val')+'"]').upFileHandle().renew();
    }
})
//加载栏目数据data（请求数据）fun（数据处理方法）afun（后续执行函数）
$.fn.getMenuData=function(data,fun,afun){
    var obj=$(this);
    if(obj.hasClass('lj'))return false;
    $.ajax({
	   type:'post',data:data,url:basic.path+'handle/post/',dataType:'json',beforeSend:function(XMLHttpRequest){
		  basicHeader(XMLHttpRequest,'json');obj.addClass('lj');
	   },success:function(msg){
		  obj.removeClass('lj');
		  if(msg.error>0){
			 obj.html(msg.html);
		  }else if(msg.error==0){
			 obj.html('')
			 if(fun)eval(fun+'(msg.data,obj)')
			 if(afun)eval(afun)
		  }else{
			 alertLj(msg.html,{ok:'未知错误，刷新页面',click:"window.location.reload()",cancel:false});
		  }
	   },error:function(error){
		  obj.removeClass('lj')
		  errHandle(error);
	   }
    })
}
//加载cms
$.fn.loadCms=function(res){
    var obj=$(this);
    var loadSure=setInterval(function(){
	   if(!basic)return;
	   clearInterval(loadSure);
	   loadFun(obj);
    },100)
    function loadFun(obj){
	   if(obj.hasClass('loading'))return false;
	   var url=basic.path+'handle/'+(res?res:getUrl());
	   $.ajax({
		  type:'post',url:url,
		  beforeSend:function(XMLHttpRequest){
			 basicHeader(XMLHttpRequest);
			 alertLj('load',false,obj);
		  },
		  success:function(msg,status,rest){
			 setTimeout(function(){obj.html(msg);},500)
			 if(rest.getResponseHeader('AC-Title'))$('title').html(decodeURI(rest.getResponseHeader('AC-Title'))+'-'+$('title').attr('cont'));
		  },
		  error:function(error){
			 errHandle(error);
		  }
	   })
    }
}