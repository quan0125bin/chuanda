<?php /* Smarty version 2.6.18, created on 2017-08-02 09:03:00
         compiled from admin/ajax/form/ones.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/ajax/all/path.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="p10">
    <form id="newsForm" way='ones'>
	   <fieldset class="fieldsets">
		  <fieldset class="open">
			 <legend class="openClick">状态<span class="arrow"></span></legend>
			 <div class="openBox clear">
				<div class="clear">
				    <select name="pid" class="sel formVal">
					    <option value="<?php echo $this->_tpl_vars['curMenu']['id']; ?>
">所属【<?php echo $this->_tpl_vars['curMenu']['name']; ?>
】</option>
				    </select>
				    <input type="hidden" name="id" class="formVal" value="<?php echo $this->_tpl_vars['data']['id']; ?>
">
				</div>
		  </fieldset>
	   </fieldset>
	   <fieldset class="open">
		  <legend class="openClick">内容<span class="arrow"></span></legend>
		  <div class="openBox clear">
			 <div class="editorBox">
				<script id="editor<?php echo $this->_tpl_vars['sign']; ?>
" type="text/plain" style="width:100%;height:200px;"><?php echo $this->_tpl_vars['data']['cont']; ?>
</script>
			 </div>
		  </div>
	   </fieldset>
	   <fieldset class="open close">
		  <legend class="openClick">SEO<span class="arrow"></span></legend>
		  <div class="openBox clear dn">
			 <div class="inp">
				<input type="text" name="seoTitle" class="formVal" value="<?php echo $this->_tpl_vars['data']['seoTitle']; ?>
">
				<p class="tit">Title</p>
			 </div>
			 <div class="inp">
				<input type="text" name="seoKeyWord" class="formVal" value="<?php echo $this->_tpl_vars['data']['seoKeyWord']; ?>
">
				<p class="tit">KeyWords</p>
			 </div>
			 <div class="inp">
				<input type="text" name="seoDes" class="formVal" value="<?php echo $this->_tpl_vars['data']['seoDes']; ?>
">
				<p class="tit">Description</p>
			 </div>
		  </div>
	   </fieldset>
	   <div class="inp sub">
		  <a href="javascript:" class="tit efColor">提交保存</a>
		  <input type="submit" class="dn">
	   </div>
    </form>
</div>
<script type="text/javascript">
if($('#edui_fixedlayer').size()>0)$('#edui_fixedlayer').remove();
var ue = UE.getEditor('editor<?php echo $this->_tpl_vars['sign']; ?>
');
$('form .inp input').each(function(){
    if($(this).val()){
	   $(this).parent().addClass('val');
    }else{
	   $(this).parent().removeClass('val');
    }
})
$('#newsForm').submit(function(){
    var obj=$(this),data={action:'sure'};
    data['way']=obj.attr('way');
    $(this).find('.formVal').each(function(){
	   data[$(this).attr('name')]=$(this).val();
    })
	data['cont']=ue.getContent();
	if(!data.cont){
		alertLj('请填写内容');return false;
	}
    if(obj.hasClass('lj'))return false;
    $.ajax({
	   type:'post',data:data,url:basic.path+'handle/post/',dataType:'json',beforeSend:function(XMLHttpRequest){
		  basicHeader(XMLHttpRequest,'json');obj.addClass('lj');alertLj('load');
	   },success:function(msg){
		  obj.removeClass('lj');
		  if(msg.error>0){
			 alertLj(msg.html);
		  }else if(msg.error==0){
			 if(data.id)
				alertLj(msg.html);
			 else
				alertLj(msg.html,{ok:'继续添加',click:"$('.refreshFormClick').addClass('ljSure').click()",cancel:true,cancelClick:"$('.refreshFormClick').addClass('ljSure').click()"});
		  }else{
			 alertLj(msg.html,{ok:'未知错误，刷新页面',click:"window.location.reload()",cancel:false});
		  }
		  $('.alertSure').focus();
		  $('.alertSure').select();
	   },error:function(error){
		  obj.removeClass('lj')
		  errHandle(error);
	   }
    })
    return false;
})
</script>