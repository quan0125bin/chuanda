<?php /* Smarty version 2.6.18, created on 2017-06-12 11:30:07
         compiled from admin/ajax/form/news2.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/ajax/all/path.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="p10">
    <form id="newsForm" way='info'>
	   <fieldset class="open">
		  <legend class="openClick">所属/状态<span class="arrow"></span></legend>
		  <div class="openBox clear">
			 <div class="clear">
				<select name="pid" class="sel formVal">
				<?php unset($this->_sections['p']);
$this->_sections['p']['loop'] = is_array($_loop=$this->_tpl_vars['pdata']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['p']['name'] = 'p';
$this->_sections['p']['show'] = true;
$this->_sections['p']['max'] = $this->_sections['p']['loop'];
$this->_sections['p']['step'] = 1;
$this->_sections['p']['start'] = $this->_sections['p']['step'] > 0 ? 0 : $this->_sections['p']['loop']-1;
if ($this->_sections['p']['show']) {
    $this->_sections['p']['total'] = $this->_sections['p']['loop'];
    if ($this->_sections['p']['total'] == 0)
        $this->_sections['p']['show'] = false;
} else
    $this->_sections['p']['total'] = 0;
if ($this->_sections['p']['show']):

            for ($this->_sections['p']['index'] = $this->_sections['p']['start'], $this->_sections['p']['iteration'] = 1;
                 $this->_sections['p']['iteration'] <= $this->_sections['p']['total'];
                 $this->_sections['p']['index'] += $this->_sections['p']['step'], $this->_sections['p']['iteration']++):
$this->_sections['p']['rownum'] = $this->_sections['p']['iteration'];
$this->_sections['p']['index_prev'] = $this->_sections['p']['index'] - $this->_sections['p']['step'];
$this->_sections['p']['index_next'] = $this->_sections['p']['index'] + $this->_sections['p']['step'];
$this->_sections['p']['first']      = ($this->_sections['p']['iteration'] == 1);
$this->_sections['p']['last']       = ($this->_sections['p']['iteration'] == $this->_sections['p']['total']);
?>
				    <option value="<?php echo $this->_tpl_vars['pdata'][$this->_sections['p']['index']]['id']; ?>
" <?php if ($_GET['pid'] && $_GET['pid'] == $this->_tpl_vars['pdata'][$this->_sections['p']['index']]['id']): ?>selected="selected"<?php endif; ?>>所属【<?php echo $this->_tpl_vars['pdata'][$this->_sections['p']['index']]['name']; ?>
】</option>
				    <?php endfor; endif; ?>
				</select>
				<select name="chk" class="sel formVal">
				    <option value="0">前端【隐藏】</option>
				    <option value="1" <?php if (! $this->_tpl_vars['data']['id'] || $this->_tpl_vars['data']['chk']): ?>selected="selected"<?php endif; ?>>前端【显示】</option>
				</select>
				<input type="hidden" name="id" class="formVal" value="<?php echo $this->_tpl_vars['data']['id']; ?>
">
				<input type="hidden" name="db" class="formVal" value="pro">
			 </div>
		  </div>
	   </fieldset>
	   <fieldset class="open">
		  <legend class="openClick">内容<span class="arrow"></span></legend>
		  <div class="openBox clear">
			 <div class="clear">
				<div class="inp notNull">
				    <input type="text" name="name" class="formVal" value="<?php echo $this->_tpl_vars['data']['name']; ?>
" maxlength="100">
				    <p class="tit">招聘职位<span>（必填）</span></p>
				</div>
				<div class="inp">
				    <input type="text" name="num" class="formVal" value="<?php echo $this->_tpl_vars['data']['num']; ?>
" maxlength="20">
				    <p class="tit">招聘人数</p>
				</div>
				<div class="inp">
				    <input type="text" name="address" class="formVal" value="<?php echo $this->_tpl_vars['data']['address']; ?>
">
				    <p class="tit">工作地点</p>
				</div>
				<div class="inp">
				    <input type="text" name="tel" class="formVal" value="<?php echo $this->_tpl_vars['data']['tel']; ?>
" maxlength="20">
				    <p class="tit">联系电话</p>
				</div>
				<div class="inp">
				    <input type="text" name="email" class="formVal" value="<?php echo $this->_tpl_vars['data']['email']; ?>
">
				    <p class="tit">联系邮箱</p>
				</div>
				<div class="inp">
				    <input type="text" name="rank" value="<?php if ($this->_tpl_vars['data']['rank']): ?><?php echo $this->_tpl_vars['data']['rank']; ?>
<?php else: ?>0<?php endif; ?>" maxlength="11" class="formVal">
				    <p class="tit">排序</p>
				    <div class="faq">1、可空。<br>2、要求纯数字。<br>3、顺序为从大到小降序，最大的排列在最前面，同样大小以添加时间为准</div>
				</div>
				<div class="inp">
				    <input type="text" name="stime" value="<?php echo $this->_tpl_vars['data']['stime']; ?>
" onClick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" maxlength="11" class="formVal laydate-icon" >
				    <p class="tit">显示时间</p>
				</div>
			 </div>
		  </div>
	   </fieldset>
	   <fieldset class="open close">
		  <legend class="openClick">职位描述<span class="arrow"></span></legend>
		  <div class="openBox clear dn">
			 <div class="editorBox">
				<script id="editor<?php echo $this->_tpl_vars['sign']; ?>
" type="text/plain" style="width:100%;height:200px;"><?php echo $this->_tpl_vars['data']['ccont']; ?>
</script>
			 </div>
		  </div>
	   </fieldset>
	   <fieldset class="open close">
		  <legend class="openClick">职位要求<span class="arrow"></span></legend>
		  <div class="openBox clear dn">
			 <div class="editorBox">
				<script id="editor<?php echo $this->_tpl_vars['sign']; ?>
2" type="text/plain" style="width:100%;height:200px;"><?php echo $this->_tpl_vars['data']['cont']; ?>
</script>
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
var ue2 = UE.getEditor('editor<?php echo $this->_tpl_vars['sign']; ?>
2');
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
    data['ccont']=ue.getContent();
    data['cont']=ue2.getContent();
    if(!data['name']){alertLj('标题不能为空');return false;}
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
				alertLj(msg.html,{ok:'继续添加',click:"$('.refreshFormClick').addClass('ljSure').click()",cancel:true,cancelClick:"$('.retrunFormClick').addClass('ljSure').click()"});
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