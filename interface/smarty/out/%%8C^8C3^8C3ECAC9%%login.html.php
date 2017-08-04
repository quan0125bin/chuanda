<?php /* Smarty version 2.6.18, created on 2017-08-02 08:59:58
         compiled from admin/ajax/login.html */ ?>
<link rel="stylesheet" href="./style/css/login.css?a=12">
<script type="text/javascript" src="./style/js/ljfunctionLogin.js"></script>
<div class="login">
    <div class="title">
	   管理员登录
    </div>
    <div class="box">
	   <p>如有任何疑问，请咨询 成都爱诚科技</p>
	   <p>
		  <span class="span">电话：<a href="tel:028-85283257">028-85283257</a></span>
		  <span class="span">QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=421182042&site=qq&menu=yes">421182042</a></span>
		  <span class="span">电子邮箱：421182042@qq.com</span>
	   </p>
	   <form id="login" way="user">
	   <div class="inp">
		  <input type="text" maxlength="32">
		  <p class="tit">请输入您的用户名</p>
	   </div>
	   <div class="inp">
		  <input type="password" maxlength="32">
		  <p class="tit">请输入您的登录密码</p>
	   </div>
	   <div class="inp code">
		  <input type="text" name="code" maxlength="6">
		  <p class="tit">请输入验证码</p>
		  <div class="codeImg">
			 <img src="/_code?way=start" dsrc="/_code?way=start" title="看不清楚？点击刷新" class="codeClick"><a class="getCode">偷下懒</a>
		  </div>
	   </div>
	   <a class="sub">登 录</a>
	   <input type="submit" class="dn">
	   <p>如果忘记了账号或密码，请联系网站管理员或成都爱诚科技</p>
	   </form>
    </div>
</div>
<script type="text/javascript">
$('.inp input').bind('keydown keyup focus',function(){
    if($(this).val()){
	   $(this).parent().addClass('focus')
    }else{
	   $(this).parent().removeClass('focus')
    }
})
$(".codeClick").click(function(){
    $('.codeImg img').attr('src',$('.codeImg img').attr('dsrc')+'&t='+Math.floor(Math.random()*100000+1))
})
</script>