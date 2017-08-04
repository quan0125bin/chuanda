<?php /* Smarty version 2.6.18, created on 2017-06-12 11:30:42
         compiled from admin/ajax/list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'admin/ajax/list.html', 39, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/ajax/all/path.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="p10">
    <form id="searchForm" onsubmit="return false">
	   <fieldset class="open <?php if (! $_GET['name']): ?>close<?php endif; ?>">
		  <legend class="openClick">搜索<span class="arrow"></span></legend>
		  <div class="openBox clear <?php if (! $_GET['name']): ?>dn<?php endif; ?>">
			 <input type="hidden" name="form" class="formVal" value="<?php echo $_GET['form']; ?>
">
			 <input type="hidden" name="action" class="formVal" value="<?php echo $_GET['action']; ?>
">
			 <?php if ($_GET['pid']): ?><input type="hidden" name="pid" class="formVal" value="<?php echo $_GET['pid']; ?>
"><?php endif; ?>
			 <input type="hidden" name="page" class="formVal" value="1">
			 <div class="inp">
				<input type="text" name="name" class="formVal" value="<?php echo $_GET['name']; ?>
" maxlength="80">
				<p class="tit">关键词</p>
			 </div>
			 <div class="inp inpSmall">
				<input type="text" name="psize" class="formVal" psize="<?php echo $this->_tpl_vars['page']['psize']; ?>
" value="<?php echo $this->_tpl_vars['page']['psize']; ?>
" maxlength="4">
				<p class="tit">条/页</p>
			 </div>
			 <div class="inp sub search">
				<a href="javascript:" class="tit efColor">搜索</a>
				<input type="submit" class="dn">
			 </div>
		  </div>
	   </fieldset>
    </form>
    <div class="tab">
	   <table>
		  <thead>
			 <tr>
				<th width="20"><input class="check_all" type="checkbox" value=""></th>
				<?php unset($this->_sections['t']);
$this->_sections['t']['loop'] = is_array($_loop=$this->_tpl_vars['thead']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['t']['name'] = 't';
$this->_sections['t']['start'] = (int)'1';
$this->_sections['t']['show'] = true;
$this->_sections['t']['max'] = $this->_sections['t']['loop'];
$this->_sections['t']['step'] = 1;
if ($this->_sections['t']['start'] < 0)
    $this->_sections['t']['start'] = max($this->_sections['t']['step'] > 0 ? 0 : -1, $this->_sections['t']['loop'] + $this->_sections['t']['start']);
else
    $this->_sections['t']['start'] = min($this->_sections['t']['start'], $this->_sections['t']['step'] > 0 ? $this->_sections['t']['loop'] : $this->_sections['t']['loop']-1);
if ($this->_sections['t']['show']) {
    $this->_sections['t']['total'] = min(ceil(($this->_sections['t']['step'] > 0 ? $this->_sections['t']['loop'] - $this->_sections['t']['start'] : $this->_sections['t']['start']+1)/abs($this->_sections['t']['step'])), $this->_sections['t']['max']);
    if ($this->_sections['t']['total'] == 0)
        $this->_sections['t']['show'] = false;
} else
    $this->_sections['t']['total'] = 0;
if ($this->_sections['t']['show']):

            for ($this->_sections['t']['index'] = $this->_sections['t']['start'], $this->_sections['t']['iteration'] = 1;
                 $this->_sections['t']['iteration'] <= $this->_sections['t']['total'];
                 $this->_sections['t']['index'] += $this->_sections['t']['step'], $this->_sections['t']['iteration']++):
$this->_sections['t']['rownum'] = $this->_sections['t']['iteration'];
$this->_sections['t']['index_prev'] = $this->_sections['t']['index'] - $this->_sections['t']['step'];
$this->_sections['t']['index_next'] = $this->_sections['t']['index'] + $this->_sections['t']['step'];
$this->_sections['t']['first']      = ($this->_sections['t']['iteration'] == 1);
$this->_sections['t']['last']       = ($this->_sections['t']['iteration'] == $this->_sections['t']['total']);
?>
				    <th<?php if (! $this->_tpl_vars['thead'][$this->_sections['t']['index']][2]): ?> class="n"<?php endif; ?><?php if ($this->_tpl_vars['thead'][$this->_sections['t']['index']][1]): ?> width="<?php echo $this->_tpl_vars['thead'][$this->_sections['t']['index']][1]; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['thead'][$this->_sections['t']['index']][0]; ?>
</th>
				<?php endfor; endif; ?>
			 </tr>
		  </thead>
		  <tbody>
		  <?php if (! $this->_tpl_vars['tdata']): ?>
		  <tr>
			 <td colspan="<?php echo count($this->_tpl_vars['thead']); ?>
" class="tc">暂无数据</td>
		  </tr>
		  <?php endif; ?>
		  <?php unset($this->_sections['d']);
$this->_sections['d']['loop'] = is_array($_loop=$this->_tpl_vars['tdata']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			 <tr>
				<td><input class="check_list" type="checkbox" value="<?php echo $this->_tpl_vars['tdata'][$this->_sections['d']['index']][0]; ?>
"></td>
				<?php unset($this->_sections['t']);
$this->_sections['t']['loop'] = is_array($_loop=$this->_tpl_vars['tdata'][$this->_sections['d']['index']]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['t']['name'] = 't';
$this->_sections['t']['start'] = (int)'1';
$this->_sections['t']['show'] = true;
$this->_sections['t']['max'] = $this->_sections['t']['loop'];
$this->_sections['t']['step'] = 1;
if ($this->_sections['t']['start'] < 0)
    $this->_sections['t']['start'] = max($this->_sections['t']['step'] > 0 ? 0 : -1, $this->_sections['t']['loop'] + $this->_sections['t']['start']);
else
    $this->_sections['t']['start'] = min($this->_sections['t']['start'], $this->_sections['t']['step'] > 0 ? $this->_sections['t']['loop'] : $this->_sections['t']['loop']-1);
if ($this->_sections['t']['show']) {
    $this->_sections['t']['total'] = min(ceil(($this->_sections['t']['step'] > 0 ? $this->_sections['t']['loop'] - $this->_sections['t']['start'] : $this->_sections['t']['start']+1)/abs($this->_sections['t']['step'])), $this->_sections['t']['max']);
    if ($this->_sections['t']['total'] == 0)
        $this->_sections['t']['show'] = false;
} else
    $this->_sections['t']['total'] = 0;
if ($this->_sections['t']['show']):

            for ($this->_sections['t']['index'] = $this->_sections['t']['start'], $this->_sections['t']['iteration'] = 1;
                 $this->_sections['t']['iteration'] <= $this->_sections['t']['total'];
                 $this->_sections['t']['index'] += $this->_sections['t']['step'], $this->_sections['t']['iteration']++):
$this->_sections['t']['rownum'] = $this->_sections['t']['iteration'];
$this->_sections['t']['index_prev'] = $this->_sections['t']['index'] - $this->_sections['t']['step'];
$this->_sections['t']['index_next'] = $this->_sections['t']['index'] + $this->_sections['t']['step'];
$this->_sections['t']['first']      = ($this->_sections['t']['iteration'] == 1);
$this->_sections['t']['last']       = ($this->_sections['t']['iteration'] == $this->_sections['t']['total']);
?>
				    <td<?php if (! $this->_tpl_vars['thead'][$this->_sections['t']['index']][2]): ?> class="n"<?php endif; ?>><?php echo $this->_tpl_vars['tdata'][$this->_sections['d']['index']][$this->_sections['t']['index']]; ?>
</td>
				<?php endfor; endif; ?>
			 </tr>
		  <?php endfor; endif; ?>
		  </tbody>
		  <tfoot>
			 <tr>
				<td><?php if ($this->_tpl_vars['del']): ?><a href="javascript:" class="delClicks" title="删除选中数据"><?php endif; ?></a></td>
				<td colspan="<?php echo count($this->_tpl_vars['thead']); ?>
">
				<span class="page">
				    <a href="javascript:" title="上一页"><<</a>
				    第 <select name="page" class="cRed b"></select> 页
				    <a href="javascript:" title="下一页" class="pnext">>></a>
				</span>
				共 <span class="cRed b dataMax" page="<?php echo $this->_tpl_vars['page']['page']; ?>
" pages="<?php echo $this->_tpl_vars['page']['pages']; ?>
"><?php echo $this->_tpl_vars['max']; ?>
</span> 条记录
				</td>
			 </tr>
		  </tfoot>
	   </table>
    </div>
</div>
<script type="text/javascript">
var page=$('.dataMax').attr('page'), pages=$('.dataMax').attr('pages');
for(var i=1;i<=pages;i++){
    $('select[name="page"]').append('<option value="'+i+'"'+(i==page?' selected="selected"':'')+'>'+(i<10?'0'+i:i)+'</option>');
}
$('select[name="page"]').change(function(){
    $('#searchForm input[name="page"]').val($(this).val())
    $('#searchForm').submit();
})
$('#searchForm .inp input').each(function(){
    if($(this).val()){
	   $(this).parent().addClass('val');
    }else{
	   $(this).parent().removeClass('val');
    }
})
$('input[name="psize"]').keyup(function(){
    if($(this).val()){
	   var v=parseInt($(this).val());
	   if(!v)v=$(this).attr('psize')
	   $(this).val(v)
    }
})
$('.page a').click(function(){
    var p=$('select[name="page"]').val();
    if(p){
	   if($(this).hasClass('pnext')){
		  p++;
	   }else{
		  p--;
	   }
	   if(p<0)return false;
	   if(p>pages)return false;
	   $('#searchForm input[name="page"]').val(p)
	   $('#searchForm').submit();
    }
    return false;
})
$('#searchForm').submit(function(){
    var url='',surl;
    $(this).find('.formVal').each(function(){
	   surl=$(this).attr('name')+'='+$(this).val();
	   url+=url?('&'+surl):surl;
    })
    $('.refreshFormClick').attr('href','?'+url).click();
    $(this).find('input[name="page"]').val(1)
    return false;
});
</script>