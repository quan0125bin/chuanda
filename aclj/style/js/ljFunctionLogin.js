$(function(){
    $("#login").submit(function(){
	   var obj=$(this),data={action:'login'};
	   data['name']=obj.find('input[type="text"]').eq(0).val();
	   data['passwd']=obj.find('input[type="password"]').eq(0).val();
	   data['code']=obj.find('input[type="text"]').eq(1).val();
	   data['way']=obj.attr('way');
	   if(!data['name']){alertLj('用户名不能为空');return false;}
	   if(!data['passwd']){alertLj('密码不能为空');return false;}
	   if(!data['code']){alertLj('验证码不能为空');return false;}
	   if(obj.hasClass('lj'))return false;
	   $.ajax({
		  type:'post',data:data,url:basic.path+'handle/post/',dataType:'json',beforeSend:function(XMLHttpRequest){
			 basicHeader(XMLHttpRequest,'json');obj.addClass('lj');alertLj('load');
		  },success:function(msg){
			 obj.removeClass('lj');
			 if(msg.error>0){
				alertLj(msg.html);
			 }else if(msg.error==0){
				window.location.href='?vid='+msg.data;
			 }else{
				alertLj(msg.html,{ok:'未知错误，请重新登录',click:"window.location.reload()",cancel:false});
			 }
		  },error:function(error){
			 obj.removeClass('lj')
			 errHandle(error);
		  }
	   })
	   return false;
    })
    $('.getCode').click(function(){
	   $.ajax({
		  type:'post',url:basic.path+'handle/',data:{action:'getCode'},dataType:'json',
		  beforeSend:function(XMLHttpRequest){
			 basicHeader(XMLHttpRequest,'json');
		  },
		  success:function(msg,status,rest){
			 if(msg.error=='0')
				$('.code input').val(msg.html).focus();
			 else
				alert(msg.html);
		  },
		  error:function(error){
			 errHandle(error);
		  }
	   })
    })
})