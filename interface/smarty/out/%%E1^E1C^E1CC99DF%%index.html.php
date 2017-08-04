<?php /* Smarty version 2.6.18, created on 2017-06-12 11:29:50
         compiled from admin/ajax/index.html */ ?>
<link rel="stylesheet" href="./style/css/index.css?a=<?php echo $this->_tpl_vars['sign']; ?>
">
<div class="header clear o">
    <div class="tit fr">
	   <span class="ttime"></span>
	   <span class="user"><a href="javascript:">欢迎使用，<br><?php echo $_SESSION['user']['uname']; ?>
</a></span>
	   <span class="menu"><a href="javascript:">菜单<br>管理</a></span>
	   <span class="userOut"><a href="?action=out">退出<br>系统</a></span>
    </div>
    <a href="javascript:window.location.href=getUrl(true);" class="logo fl">
	   网站管理系统<i>Website management system</i>
    </a>
</div>
<a href="javascript:" class="leftClick efColor"></a>
<div class="left efColor">
    <div class="tit clear" alt="快捷按钮">
	   <a href="/" class="icoQui quiHome rotY" target="_blank" title="前台浏览"></a>
	   <!--
	   <a href="javascript:window.location.href=getUrl(true);" class="icoQui quiCms rotY" title="后台首页"></a>
	   <a href="?form=sys&action=set" class="icoQui quiSet rotY" title="系统设置"></a>
	   <a href="?form=sys&action=menu" class="icoQui quiMenu rotY" title="栏目管理"></a>-->
	   <select class="icoSelect">
		  <option value="?vid=<?php echo $_GET['vid']; ?>
">系统首页</option>
		  <option value="?vid=<?php echo $_GET['vid']; ?>
&way=image" <?php if ($_GET['way'] && $_GET['way'] == 'image'): ?>selected="selected"<?php endif; ?>>其他管理</option>
		  <!--<option value="?vid=<?php echo $_GET['vid']; ?>
&way=image&eq=4" <?php if ($_GET['way'] && $_GET['way'] == 'vip' && $_GET['eq'] == 4): ?>selected="selected"<?php endif; ?>>留言管理</option>
		  <option value="?vid=<?php echo $_GET['vid']; ?>
&way=filter" <?php if ($_GET['way'] && $_GET['way'] == 'filter'): ?>selected="selected"<?php endif; ?>>分类管理</option>
		  <option value="?vid=<?php echo $_GET['vid']; ?>
&way=vip" <?php if ($_GET['way'] && $_GET['way'] == 'vip'): ?>selected="selected"<?php endif; ?>>用户管理</option>
		  -->
	   </select>
    </div>
    <div class="m">
	   <?php unset($this->_sections['b']);
$this->_sections['b']['loop'] = is_array($_loop=$this->_tpl_vars['basicMenu']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['b']['name'] = 'b';
$this->_sections['b']['show'] = true;
$this->_sections['b']['max'] = $this->_sections['b']['loop'];
$this->_sections['b']['step'] = 1;
$this->_sections['b']['start'] = $this->_sections['b']['step'] > 0 ? 0 : $this->_sections['b']['loop']-1;
if ($this->_sections['b']['show']) {
    $this->_sections['b']['total'] = $this->_sections['b']['loop'];
    if ($this->_sections['b']['total'] == 0)
        $this->_sections['b']['show'] = false;
} else
    $this->_sections['b']['total'] = 0;
if ($this->_sections['b']['show']):

            for ($this->_sections['b']['index'] = $this->_sections['b']['start'], $this->_sections['b']['iteration'] = 1;
                 $this->_sections['b']['iteration'] <= $this->_sections['b']['total'];
                 $this->_sections['b']['index'] += $this->_sections['b']['step'], $this->_sections['b']['iteration']++):
$this->_sections['b']['rownum'] = $this->_sections['b']['iteration'];
$this->_sections['b']['index_prev'] = $this->_sections['b']['index'] - $this->_sections['b']['step'];
$this->_sections['b']['index_next'] = $this->_sections['b']['index'] + $this->_sections['b']['step'];
$this->_sections['b']['first']      = ($this->_sections['b']['iteration'] == 1);
$this->_sections['b']['last']       = ($this->_sections['b']['iteration'] == $this->_sections['b']['total']);
?>
	   <div class="team FORM<?php echo $this->_tpl_vars['basicMenu'][$this->_sections['b']['index']]['id']; ?>
">
		  <div class="t efColor ico<?php if ($this->_tpl_vars['basicMenu'][$this->_sections['b']['index']]['url']): ?>2<?php else: ?>1<?php endif; ?>"><?php echo $this->_tpl_vars['basicMenu'][$this->_sections['b']['index']]['name']; ?>
<?php if ($this->_tpl_vars['basicMenu'][$this->_sections['b']['index']]['data']): ?><i></i><?php elseif ($this->_tpl_vars['basicMenu'][$this->_sections['b']['index']]['url']): ?><a href="<?php echo $this->_tpl_vars['basicMenu'][$this->_sections['b']['index']]['url']; ?>
" class="_url _self"></a><?php endif; ?></div>
		  <?php if ($this->_tpl_vars['basicMenu'][$this->_sections['b']['index']]['data']): ?>
		  <ul>
			 <?php unset($this->_sections['d']);
$this->_sections['d']['loop'] = is_array($_loop=$this->_tpl_vars['basicMenu'][$this->_sections['b']['index']]['data']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['d']['name'] = 'd';
$this->_sections['d']['show'] = true;
$this->_sections['d']['max'] = $this->_sections['d']['loop'];
$this->_sections['d']['step'] = 1;
$this->_sections['d']['start'] = $this->_sections['d']['step'] > 0 ? 0 : $this->_sections['d']['loop']-1;
if ($this->_sections['d']['show']) {
    $this->_sections['d']['total'] = $this->_sections['d']['loop'];
    if ($this->_sections['d']['total'] == 0)
        $this->_sections['d']['show'] = false;
} else
    $this->_sections['d']['total'] = 0;
if ($this->_sections['d']['show']):

            for ($this->_sections['d']['index'] = $this->_sections['d']['start'], $this->_sections['d']['iteration'] = 1;
                 $this->_sections['d']['iteration'] <= $this->_sections['d']['total'];
                 $this->_sections['d']['index'] += $this->_sections['d']['step'], $this->_sections['d']['iteration']++):
$this->_sections['d']['rownum'] = $this->_sections['d']['iteration'];
$this->_sections['d']['index_prev'] = $this->_sections['d']['index'] - $this->_sections['d']['step'];
$this->_sections['d']['index_next'] = $this->_sections['d']['index'] + $this->_sections['d']['step'];
$this->_sections['d']['first']      = ($this->_sections['d']['iteration'] == 1);
$this->_sections['d']['last']       = ($this->_sections['d']['iteration'] == $this->_sections['d']['total']);
?>
			 <li><a href="<?php echo $this->_tpl_vars['basicMenu'][$this->_sections['b']['index']]['data'][$this->_sections['d']['index']]['url']; ?>
" class="efColor DATA<?php echo $this->_tpl_vars['basicMenu'][$this->_sections['b']['index']]['id']; ?>
<?php echo $this->_tpl_vars['basicMenu'][$this->_sections['b']['index']]['data'][$this->_sections['d']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['basicMenu'][$this->_sections['b']['index']]['data'][$this->_sections['d']['index']]['name']; ?>
</a></li>
			 <?php endfor; endif; ?>
		  </ul>
		  <?php endif; ?>
	   </div>
	   <?php endfor; endif; ?>
	   <div id="menuData" sdata="<?php echo $this->_tpl_vars['way']; ?>
" action="getDataMenu" eq="<?php echo $_GET['eq']; ?>
"></div>
	   <div class="hr"></div>
    </div>
</div>
<div class="min pr">
    <div class="minBox">
	   <div class="hr"></div>
    </div>
</div>
<script type="text/javascript" src="./style/js/calendar/laydate.js"></script>
<script type="text/javascript">
$(window).bind('resize',function(){
    if($(window).width()<1000){
	   window.location.reload();
    }else{
	   windowResize(true);
    }
})
function getTime(){
    function p(s) {
	   return s < 10 ? '0' + s: s;
    }
    var myDate = new Date();
    //获取当前年
    var year=myDate.getFullYear();
    //获取当前月
    var month=myDate.getMonth()+1;
    //获取当前日
    var date=myDate.getDate(); 
    var h=myDate.getHours();       //获取当前小时数(0-23)
    var m=myDate.getMinutes();     //获取当前分钟数(0-59)
    var s=myDate.getSeconds();  
    var now=year+'年'+p(month)+'月'+p(date)+'日 '+p(h)+':'+p(m)+':'+p(s);
    $('.ttime').html(now);
}
function windowResize(res){
    $('body').addClass('o');
    var leftHeightNew=$(window).height()-$('.header').height();
    $('.left').height(leftHeightNew);
    var leftHeightNewMin=leftHeightNew-$('.left .m').offset().top+$('.header').height()
    $('.left .m').css({height:leftHeightNewMin});
    var minWidth=$(window).width()-$('.left').outerWidth();
    if($('.left').css('display')=='none'){
	   minWidth=$(window).width();
    }
    $('.min').css({width:minWidth,height:leftHeightNew})
    $('.min>.minBox').css({height:leftHeightNew,'overflow-y':'auto'})
    if(!res){
	   $('.minBox').loadCms(getUrlAfter());
	   menuClickCheck();
    }
}
function menuClickCheck(){
    var u=getUrlAfter().match(/form=([a-z0-9]*)(\&action=([a-zA-Z0-9]*))?(\&pid=([0-9a-z]*))?(\&(.*))?/),obj;
    var c=u?(u[1]?u[1]:''):'';
    if(c){
	   obj=$('.left .team.FORM'+c);
    }else{
	   obj=$('.left .team').eq(0);
    }
    $('.left .team .t').removeClass('current');
    $('.left .team ul').slideUp(500);
    obj.find('.t').addClass('current');
    if(obj.find('ul').size()>0){
	   obj.find('ul').stop(true,true).slideDown(500);
	   if(c)obj.find('.DATA'+c+(u[5]?u[5]:(u[3]?u[3]:''))).addClass('current');
    }else{
	   if($('#menuData').attr('sdata')!='menu' && $('#menuData .team').size()>0){
		 $('#menuData .t').eq(0).click();
		 var eq=$("#menuData").attr('eq')?$("#menuData").attr('eq'):0;
		 if(eq>$('#menuData a').size()-1)eq=$('#menuData a').size()-1;
		 $('#menuData a').eq(eq).click();
	   }
    }
}
function imageBoxShow(id,data){
    if(id && data){
	   $("#"+id).siblings('input[type="hidden"]').val(data.img);
	   $("#"+id).siblings('.inp').find('input[type="text"]').val(data.name).focus();
	   $("#"+id).siblings('img').attr('src','/upload/'+data.img);
    }
}
$('.leftClick').click(function(){
    var u=getUrlAfter();
    if($(this).hasClass('current')){
	   $('.left').animate({width:250},10)
	   var minWidth=$(window).width()-250-1;
	   $('.min').animate({width:minWidth},10)
	   $(this).removeClass('current');
	   u=u.replace(/&left=hide/gm,'')+'&left=show';
    }else{
	   $('.left').animate({width:0},10);
	   var minWidth=$(window).width()-1;
	   $('.min').animate({width:minWidth},10)
	   $(this).addClass('current');
	   u=u.replace(/&left=show/gm,'')+'&left=hide';
    }
    window.location='#'+u
})
setTimeout(function(){
    windowResize();
    if(getUrlAfter().indexOf('left=hide')>0)$('.leftClick').click();
},500);
window.onhashchange=windowResize();//链接发生变化触发

setInterval(getTime,1000);
$('.icoSelect').change(function(){
    window.location.href=$(this).val();
})
$('.team .t').live('click',function(){
    if($(this).find('._self').size()>0){
	   window.location.href='#';$('.minBox').loadCms(getUrlAfter());
    }
    if($(this).hasClass('current')){
	   $(this).removeClass('current').siblings('ul').slideUp(500);
    }else{
	   $('.team .t').removeClass('current').siblings('ul').slideUp(500);
	   $(this).addClass('current').siblings('ul').slideDown(500);
    }
})
$('.header .menu').click(function(){
    if($('.left').hasClass('current')){
	   $('.left').removeClass('current')
    }else{
	   $('.left').addClass('current')
    }
})
$('.left a').live('click',function(){
    if($(this).attr('href') && $(this).attr('href').substr(0,1)=='?'){
	   $('.minBox').loadCms($(this).attr('href'));
	   window.location.href='#'+$(this).attr('href');
	   $('.left a').removeClass('current');$(this).addClass('current');
	   if($(this).parent().hasClass('tit')){
		  menuClickCheck()
	   }
	   $('.header .menu').click();
	   return false;
    }
})
$('.min a').live('click',function(){
    var narr=['','?','/'];
    if($(this).attr('href') && $.inArray($(this).attr('href').substr(0,1),narr)>0){
	   if($(this).attr('target'))return true
	   var url=$(this).attr('href');
	   if($(this).hasClass('returnUrl'))url+='&returnUrl='+encodeURIComponent(getUrlAfter());
	   if($('.subFormClick').size()>0 && !$(this).hasClass('nAlert')){
		  if(!$(this).hasClass('ljSure')){
			 if($(this).attr('aclass'))$(this).removeClass($(this).attr('aclass'));
			 var m='ljSure'+parseInt(Math.random()*1000)+parseInt(Math.random()*1000)+parseInt(Math.random()*1000);
			 $(this).addClass(m);
			 alertLj('正在编辑内容，内容没有保存，确定跳转?',{ok:'继续跳转',click:"$('."+m+"').attr('aclass','"+m+"').addClass('ljSure').click();alertLjClose()",cancel:true});
			 return false;
		  }
	   }
	   $('.minBox').loadCms(url);
	   window.location.href='#'+url;
	   return false;
    }
    return true;
})
$('.check_all').live('change',function(){
    if($(this).is(':checked'))
    $(this).parents('.tab').find('.check_list').attr('checked','checked');
    else
    $(this).parents('.tab').find('.check_list').removeAttr('checked');
})
$('.check_list').live('change',function(){
    var p=false,c=false;;
    if($(this).parent().parent().parent().hasClass('roleBoxs_n')){
	   $(this).parents('.roleBoxs_n').find('.roleBoxs_s .check_list').each(function(){
		  if($(this).attr('checked'))p=true
	   })
	   if(p){
		  $(this).parents('.roleBoxs_n').find('.check_list').eq(0).attr('checked','checked');
	   }else{
		  $(this).parents('.roleBoxs_n').find('.check_list').eq(0).removeAttr('checked');
	   }
    }
    $(this).parents('.tab').find('.check_list').each(function(){
	   if($(this).attr('checked'))c=true
    })
    if(c){
	   $(this).parents('.tab').find('.check_all').attr('checked','checked');
    }else{
	   $(this).parents('.tab').find('.check_all').removeAttr('checked');
    }
    if($(this).parent().siblings('.roleBoxs_s').size()>0){
	   if($(this).attr('checked')){
		  $(this).parent().siblings('.roleBoxs_s').show();
	   }else{
		  $(this).parent().siblings('.roleBoxs_s').hide();
	   }
    }
})
$(".shideAll").live('click',function(){
    var obj=$(this).attr('perentClass')?$(this).parents($(this).attr('perentClass')):$(this).parent();
    if(obj.hasClass('close')){
	   obj.removeClass('close').find($(this).attr('openClass')).stop().show(500);
	   obj.find('.open').removeClass('close');
    }else{
	   obj.addClass('close').find($(this).attr('openClass')).hide(500);
	   obj.find('.open').addClass('close');
    }
})
$(".open .shide").live('click',function(){
    var obj=$(this).attr('perentClass')?$(this).parents($(this).attr('perentClass')):$(this).parent();
    var sibl=$(this).attr('sibl');
    if(obj.hasClass('close')){
	   obj.removeClass('close')
	   if(sibl)
		  $('.'+obj.attr('cls')).show();
	   else
		  obj.find($(this).attr('openClass')).show(500);
    }else{
	   obj.addClass('close')
	   if(sibl)
		  $('.'+obj.attr('cls')).hide();
	   else
		  obj.find($(this).attr('openClass')).hide(500);
    }
})
/******获取侧边栏目*******************************************/
function getMenu(json,obj,pobj){
    $.each(json,function(k,v){
	   var nobj,crole,action=v.pid?(isNaN(v.pid)?v.pid:'list'):(isNaN(v.id)?v.id:'list');
	   if(pobj){
		  nobj=pobj;
	   }else{
		  obj.append('<div class="team FORM'+action+v.id+'"></div>');
		  nobj=obj.find('.team.FORM'+action+v.id);
	   }
	   var way=obj.attr('sdata');
	   if(!pobj){
		  nobj.append('<div class="t efColor ico3">'+v.name+(v.data?'<i></i>':(v.url?('<a href="'+v.url+'" class="_url _self"></a>'):''))+'</div>');
	   }else{
		  if(v.data)
		  nobj.append('<li><a href="javascript:alert(\'请更新子栏目\')" class="efColor DATA'+action+v.pid+v.id+'">'+v.name+'</a></li>');
		  else
		  nobj.append('<li><a href="?form='+action+v.pid+'&action='+action+'&pid='+v.id+'" class="efColor DATA'+action+v.pid+v.id+'">'+v.name+'</a></li>');
	   }
	   if(v.data){
		  nobj.append('<ul></ul>');
		  nobj=nobj.find('ul');
		  getMenu(v.data,obj,nobj);
	   }
    })
}
function adFilter(n,obj,go){
    var html='<div class="filterTeams team'+((n>0)?n+' teamSon':'')+' wackSure clear" way="filter"><div class="clear">';
    html+='<input type="hidden">';
    html+='<div class="inp rank"><input type="text" name="rank" maxlength="20" title="排序"></div>';
    html+='<div class="inp notNull"><input type="text" name="name" maxlength="20"><p class="tit">标题<span>（必填）</span></p></div>';
    html+='<select class="sel"><option value="0">单选</option><option value="1">多选</option></select>';
    if(!n || n<2)html+='<a href="javascript:" onclick="adFilter('+((n>0)?(n+1):1)+',$(this).parent().parent())" class="adClick" title="添加子类"></a>';
    html+='<a href="javascript:" class="icoClick sureClick" title="保存"></a>';
    html+='<a href="javascript:" class="delClick" del="$(this).parent().parent().remove();" title="删除"></a>';
    //if(!n)html+='<span class="shide arrow" title="展开"></span>';
    html+='</div></div>';
    var oobj=obj?obj:$('.filter');
    if(obj && !oobj.attr('pid')){alertLj('请先确认分类');return false;}
    if(n==1){
	   var nobj=obj.find('.filterBoxs')
	   if(nobj.size()>0){
		  oobj=nobj;
	   }else{
		  var width=$('.minBox').width()-obj.find('.clear').width()-45;
		  html='<div class="filterBoxs clear" style="width:'+width+'px">'+html+'</div>';
	   }
    }else if(n>1){
	   var nobj=obj.find('.filterBoxs2')
	   if(nobj.size()>0){
		  oobj=nobj;
	   }else{
		  html='<div class="filterBoxs2">'+html+'</div>';
	   }
    }
    oobj.append(html);
    if(!go)oobj.find('.filterTeams input[type="text"]').focus();
}
setTimeout(function(){
    $('#menuData').each(function(){
	   var obj=$(this),data={'out':1};
	   data['way']=obj.attr('sdata');
	   data['action']=obj.attr('action')?obj.attr('action'):'getData';
	   obj.getMenuData(data,'getMenu','menuClickCheck()');
    })
},500)
/******获取侧边栏目end*******************************************/

/******************/
$("<link>").attr({ rel: "stylesheet",type: "text/css",href: "/interface/uploadify/uploadify.css?a=11a"}).appendTo("head");
$.getScript('/interface/uploadify/jquery.uploadify.min.js');
$.getScript('/style/js/jquery.upload.js');
$.getScript('/interface/ueditor/ueditor.config.js');
$.getScript('/interface/ueditor/ueditor.all.min.js');
/******获取地图信息***********************/
$('.mapAddressClick').live('click',function(){
    if($('#mapFarme').size()>0)$('#mapFarme').remove();
    var map='<div id="mapFarme" class="mapFarme">'
    map+='<iframe width="50%" name="mapFarme" height="50%" src="/interface/map/" frameborder="0" scrolling="auto" allowtransparency="true"></iframe>';
    map+='</div>';
    $('.minBox').append(map);
    obj=$("#mapFarme");
    $obj=$(".minBox");
    $('iframe[name="mapFarme"]').load(function(){
	   $(window.frames["mapFarme"].document).find('#suggestId').focus();
	   $(window.frames["mapFarme"].document).find('.mapCancel').click(function(){
		  obj.remove();
	   })
	   $(window.frames["mapFarme"].document).find('.mapSure').click(function(){
		  var suggestId=$(this).parents('#r-result').find('#suggestId').val();
		  var suggestVal=$(this).parents('#r-result').find('#suggestVal').val();
		  $obj.find(".mapAddressVal").val(suggestVal);
		  $obj.find(".mapAddress").val(suggestId).parent().addClass('val');
		  obj.remove();
	   })
    })
})
$('.mapAddress').live('focus',function(){
    if(!$(this).val()){
	   $(this).siblings('.faq.mapAddressClick').click();
    }
})

$('.bid').live('keyup',function(){
    var v=$.trim($(this).val());
    if(!v)return false;
    var obj=$(this),data={action:'search',way:$(this).parents('form').attr('way'),name:v};
    if(obj.attr('way'))data['way']=obj.attr('way');
    $.ajax({
	   type:'post',data:data,url:basic.path+'handle/post/',dataType:'json',beforeSend:function(XMLHttpRequest){
		  basicHeader(XMLHttpRequest,'json');$('.bidSel').show().html('<option value="">搜索“'+v+'”中</option>');
	   },success:function(msg){
		  if(msg.error>0){
			 $('.bidSel').html('<option value="">搜索无结果</option>');
		  }else{
			 if(msg.data){
				$('.bidSel').html('<option value="">搜索共（'+msg.data.length+'）结果</option>');
				$.each(msg.data,function(k,v){
				    $('.bidSel').append('<option value="'+v.id+'">'+v._name+'</option>');
				})
			 }else{
				$('.bidSel').html('<option value="">搜索无结果</option>');
			 }
		  }
	   },error:function(){
		  
	   }
    })
    $('.bidSel').show();
})
$('.bidSel').live('change',function(){
    $('input[name="bid"]').val($(this).val())
    $('.bid').val($(this).find('option:selected').html());
})

$('.hid').live('keyup',function(){
    var v=$.trim($(this).val());
    if(!v)return false;
    var obj=$(this),data={action:'search',way:$(this).attr('way'),name:v};
    $.ajax({
	   type:'post',data:data,url:basic.path+'handle/post/',dataType:'json',beforeSend:function(XMLHttpRequest){
		  basicHeader(XMLHttpRequest,'json');$('.hidSel').show().html('<option value="">搜索“'+v+'”中</option>');
	   },success:function(msg){
		  if(msg.error>0){
			 $('.hidSel').html('<option value="">搜索无结果</option>');
		  }else{
			 if(msg.data){
				$('.hidSel').html('<option value="">搜索共（'+msg.data.length+'）结果</option>');
				$.each(msg.data,function(k,v){
				    $('.hidSel').append('<option value="'+v.id+'">'+v._name+'</option>');
				})
			 }else{
				$('.hidSel').html('<option value="">搜索无结果</option>');
			 }
		  }
	   },error:function(){
		  
	   }
    })
    $('.hidSel').show();
})
$('.hidSel').live('change',function(){
    var obj=$(this),n=true,num=0;
    if($(this).val()){
	   $(".hidData label").each(function(){
		  if($(this).find('input').val()==obj.val()){
			 n=false;
		  }
		  num++;
	   })
	   if(num>5){
		  alertLj('最多选择5个房管家');return false;
	   }
	   if(n){
		  $('.hidData').append('<label class="checkbox"><input type="checkbox" checked="checked" value="'+$(this).val()+'">'+$(this).find('option:selected').html()+'</label>');
	   }
    }
})
/*****************************/
</script>