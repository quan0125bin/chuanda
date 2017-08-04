<?php /* Smarty version 2.6.18, created on 2017-08-02 09:02:39
         compiled from admin/ajax/menu.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'admin/ajax/menu.html', 19, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/ajax/all/path.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="p10">
    <div class="tab menu">
	   <table>
		  <thead>
			 <tr>
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
				    <th class="<?php if (! $this->_tpl_vars['thead'][$this->_sections['t']['index']][2]): ?>n<?php endif; ?><?php if ($this->_sections['t']['iteration'] == 1): ?> open close<?php endif; ?>"<?php if ($this->_tpl_vars['thead'][$this->_sections['t']['index']][1]): ?> width="<?php echo $this->_tpl_vars['thead'][$this->_sections['t']['index']][1]; ?>
"<?php endif; ?>>
					   <?php if ($this->_sections['t']['iteration'] == 1): ?><label><input class="check_all" type="checkbox" value=""><?php echo $this->_tpl_vars['thead'][$this->_sections['t']['index']][0]; ?>
</label><?php else: ?><?php echo $this->_tpl_vars['thead'][$this->_sections['t']['index']][0]; ?>
<?php endif; ?>
					   <?php if ($this->_sections['t']['iteration'] == 1): ?><span class="shideAll arrow"></span><?php endif; ?>
				    </th>
				<?php endfor; endif; ?>
			 </tr>
		  </thead>
		  <tbody></tbody>
		  <tfoot>
			 <tr>
				<td><?php if ($this->_tpl_vars['del']): ?><a href="javascript:" class="delClicks" title="删除选中数据"><?php endif; ?></a></td>
				<td colspan="<?php echo count($this->_tpl_vars['thead']); ?>
"></td>
			 </tr>
		  </tfoot>
	   </table>
    </div>
</div>
<script type="text/javascript">
var json=<?php echo $this->_tpl_vars['dataJson']; ?>
,tr,selectType=<?php echo @MenuType; ?>
,selectVal='';
$.each(selectType,function(k,v){
    selectVal+='<option value="'+v.id+'">'+v.name+'</option>';
})
selectVal='<select class="sel selectType">'+selectVal+'</select>';
menuShow(json,json[0].pid,1);
$('.menu thead tr>th').each(function(){
    if($(this).hasClass('n')){
	   var i=$(this).index();
	   $('.menu tbody tr').each(function(){
		  $(this).find('td').eq(i).addClass('n');
	   })
    }
})
$('.menu_1 .menu_name').append('<span class="shide arrow" perentClass=".menuTr" openClass="cls" sibl="true"></span>').parent().addClass('open');
$('.shideAll').click(function(){
    $('.shide').click();
})
$('.shide').click();
$('.selectType').change(function(){
    var obj=$(this),data={action:'state',state:'type'};
    data['sdata']=obj.attr('sdata');
    data['type']=obj.val();
    quiUpdate(data,obj);
    return false;
})
$('.rankUpdate').change(function(){
    var obj=$(this),data={action:'state',state:'rank'};
    data['sdata']=obj.attr('sdata');
    data['rank']=obj.val();
    quiUpdate(data,obj);
    return false;
})
function menuShow(json,pid,n,cls){
    var nr=true;
    $.each(json,function(k,v){
	   if(v.pid==pid){
		  tr='<td class="menu_name"><span class="bg"></span><label><input class="check_list" type="checkbox" value="'+v.uway+'">'+v.name+'</label></td>';
		  tr+='<td><input type="text" value="'+v.rank+'" class="inp tc rankUpdate" sdata="'+v.uway+'" maxlength="11"></td>';
		  if(n>1){tr+='<td>'+selectVal+'</td>';}else{tr+='<td>'+((v.type>0)?'独立首页':'默认首页')+'</td>';}
		  tr+='<td>'+v.url+'</td>';
		  tr+='<td><a href="javascript:" sdata="'+v.chk_t+'" class="state_'+v.chk+' stateClick" addClass="state_'+v.chk+'"></a>';
		  if(n==1){tr+='<a href="javascript:" sdata="'+v.dchk_t+'" class="state_'+v.dchk+' stateClick" addClass="state_'+v.dchk+'"></a></td>';}else{tr+='</td>';}
		  if(v.away){tr+='<td><a href="<?php echo $this->_tpl_vars['url']; ?>
&way=update&sdata='+v.away+'">[添加]</a></td>';}else{tr+='<td><span class="cGray">[限制]</span></td>';}
		  tr+='<td><a href="<?php echo $this->_tpl_vars['url']; ?>
&way=update&sdata='+v.uway+'">[修改]</a>[<a href="javascript:" sdata="'+v.uway+'" class="cRed delClick" title="删除"></a>]</td>';
		  $('.menu tbody').append('<tr class="menuTr menu_'+n+(cls?(' c'+cls):'')+'">'+tr+'</tr>');
		  var pleft=(n-1)*20;
		  $('.menu tbody .menu_'+n+' .menu_name').css({paddingLeft:(pleft>0?pleft:5)})
		  if(n>1)$('.menu tbody tr .selectType').last().attr('sdata',v.uway).val(v.type)
		  if(v.data){
			 var c=n+1;
			 var ncls=cls?cls:parseInt(Math.random()*(1000+n)+1)
			 $('.menu tbody tr').last().attr('cls','c'+ncls)
			 menuShow(v.data,v.id,c,ncls);
		  }
	   }
    })
}
</script>