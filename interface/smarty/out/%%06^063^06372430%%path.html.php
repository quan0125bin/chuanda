<?php /* Smarty version 2.6.18, created on 2017-06-12 11:23:43
         compiled from admin/ajax/all/path.html */ ?>
<div class="path">
    <span class="t"><?php echo $this->_tpl_vars['title']; ?>
</span>
    <?php if ($this->_tpl_vars['return']): ?>
    <a href="<?php echo $this->_tpl_vars['return']['url']; ?>
" class="aclick retrunFormClick efColor"><?php echo $this->_tpl_vars['return']['title']; ?>
</a>
    <?php elseif ($this->_tpl_vars['add']): ?>
	   <?php if ($this->_tpl_vars['returnUrl']): ?><a href="<?php echo $this->_tpl_vars['return']['returnUrl']; ?>
" class="aclick retrunFormClick efColor"><?php echo $this->_tpl_vars['returnUrl']['title']; ?>
</a><?php endif; ?>
	   <a href="<?php echo $this->_tpl_vars['add']['url']; ?>
" class="aclick addFormClick efColor">新增<?php echo $this->_tpl_vars['add']['title']; ?>
</a>
    <?php endif; ?>
    <a href="<?php if ($_SERVER['QUERY_STRING']): ?>?<?php echo $_SERVER['QUERY_STRING']; ?>
<?php elseif ($_SERVER['REQUEST_URI']): ?><?php echo $_SERVER['REQUEST_URI']; ?>
<?php else: ?>javascript:window.location.reload();<?php endif; ?>" class="aclick refreshFormClick efColor">刷新</a>
    <?php if ($this->_tpl_vars['form']): ?>
    <a href="javascript:" class="aclick subFormClick efColor">提交保存</a>
    <?php endif; ?>
</div>
<script type="text/javascript">
$('.min>.path').remove();
$('.minBox').before($('.path')).css({height:$('.min').height()-$('.path').outerHeight()});
</script>