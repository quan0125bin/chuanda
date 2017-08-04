<?php /* Smarty version 2.6.18, created on 2017-08-02 09:02:52
         compiled from admin/ajax/basic.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/ajax/all/path.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="p10">
    <form id="basicForm" way='basic'>
	   <fieldset class="open">
		  <legend class="openClick">基本资料<span class="arrow"></span></legend>
		  <div class="openBox clear">
			 <div class="inp">
				<input type="text" name="title" value="<?php echo $this->_tpl_vars['data']['title']; ?>
" maxlength="80">
				<p class="tit">网站标题</p>
			 </div>
			 <div class="inp">
				<input type="text" name="name" value="<?php echo $this->_tpl_vars['data']['name']; ?>
" maxlength="80">
				<p class="tit">公司名称</p>
			 </div>
			 <div class="inp">
				<input type="text" name="email" value="<?php echo $this->_tpl_vars['data']['email']; ?>
">
				<p class="tit">电子邮箱</p>
			 </div>
			 <div class="inp">
				<input type="text" name="tel" value="<?php echo $this->_tpl_vars['data']['tel']; ?>
">
				<p class="tit">联系电话</p>
			 </div>
			 <div class="inp dn">
				<input type="text" name="fax" value="<?php echo $this->_tpl_vars['data']['fax']; ?>
">
				<p class="tit">电话传真</p>
			 </div>
			 <div class="inp">
				<input type="text" name="address" value="<?php echo $this->_tpl_vars['data']['address']; ?>
" class="formVal mapAddress">
				<input type="hidden" name="addressVal" value="<?php echo $this->_tpl_vars['data']['addressVal']; ?>
" class="formVal mapAddressVal">
				<p class="tit">公司地址</p>
				<div class="faq mapAddressClick">点击定位</div>
			 </div>
			 <div class="inp">
				<input type="text" name="conts" value="<?php echo $this->_tpl_vars['data']['cont']['n1']; ?>
" data-name='n1'>
				<p class="tit">版权信息</p>
			 </div>
			 <div class="inp">
				<input type="text" name="conts" value="<?php echo $this->_tpl_vars['data']['cont']['n9']; ?>
" data-name='n9'>
				<p class="tit">OA 系统</p>
			 </div>
		  </div>
	   </fieldset>
	   <fieldset class="open">
		  <legend class="openClick">SEO<span class="arrow"></span></legend>
		  <div class="openBox clear">
			 <div class="inp">
				<input type="text" name="seoTitle" value="<?php echo $this->_tpl_vars['data']['seoTitle']; ?>
">
				<p class="tit">Title</p>
			 </div>
			 <div class="inp">
				<input type="text" name="seoKeyWord" value="<?php echo $this->_tpl_vars['data']['seoKeyWord']; ?>
">
				<p class="tit">KeyWords</p>
			 </div>
			 <div class="inp">
				<input type="text" name="seoDes" value="<?php echo $this->_tpl_vars['data']['seoDes']; ?>
">
				<p class="tit">Description</p>
			 </div>
			 <textarea name="cont" class="dn"></textarea>
		  </div>
	   </fieldset>
	   <!---备用信息
	   
		  <div class="inp">
			 <input type="text" name="conts" value="<?php echo $this->_tpl_vars['data']['cont']['xxx']; ?>
" data-name='xxx'>
			 <p class="tit">Title</p>
		  </div>
	   -->
	   <div class="inp sub">
		  <a href="javascript:" class="tit efColor">提交保存</a>
		  <input type="submit" class="dn">
	   </div>
    </form>
</div>
<script type="text/javascript">
$('form .inp input,form .inp textarea').each(function(){
    if($(this).val()){
	   $(this).parent().addClass('val');
    }else{
	   $(this).parent().removeClass('val');
    }
})
$('#basicForm').submit(function(){
    var obj=$(this),data={action:'sure'};
    data['way']=obj.attr('way');
    data['title']=obj.find('input[name="title"]').val();
    data['name']=obj.find('input[name="name"]').val();
    data['email']=obj.find('input[name="email"]').val();
    data['seoTitle']=obj.find('input[name="seoTitle"]').val();
    data['seoKeyWord']=obj.find('input[name="seoKeyWord"]').val();
    data['seoDes']=obj.find('input[name="seoDes"]').val();
    data['tel']=obj.find('input[name="tel"]').val();
    data['fax']=obj.find('input[name="fax"]').val();
    data['address']=obj.find('input[name="address"]').val();
    data['addressVal']=obj.find('input[name="addressVal"]').val();
    data['cont']='';
    obj.find('[name="conts"]').each(function(){
	   if(data['cont'])data['cont']+=',';
	   data['cont']+='"'+$(this).attr('data-name')+'":"'+$(this).val()+'"';
    })
    if(data['cont'])data['cont']='{'+data['cont']+'}';
    if(!data['title']){alertLj('请填写网站标题');return false;}
    if(!data['name']){alertLj('请填写公司名称');return false;}
    if(obj.hasClass('lj'))return false;
    $.ajax({
	   type:'post',data:data,url:basic.path+'handle/post/',dataType:'json',beforeSend:function(XMLHttpRequest){
		  basicHeader(XMLHttpRequest,'json');obj.addClass('lj');alertLj('load');
	   },success:function(msg){
		  obj.removeClass('lj');
		  if(msg.error>0){
			 alertLj(msg.html);
		  }else if(msg.error==0){
			 alertLj(msg.html);
		  }else{
			 alertLj(msg.html,{ok:'未知错误，刷新页面',click:"window.location.reload()",cancel:false});
		  }
	   },error:function(error){
		  obj.removeClass('lj')
		  errHandle(error);
	   }
    })
    return false;
})
</script>