<?php /* Smarty version 2.6.18, created on 2017-08-02 09:04:22
         compiled from detail.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "all/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "all/path.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<section class="lh-mob">
	<div class="container clearfix">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "all/menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div class="lh-mob-info right">
        	<span class="lh-newsRes-time"><?php echo $this->_tpl_vars['data']['_time']; ?>
</span>
        	<h2 class="lh-mob-h2" data-animated="fadeInUp"><i></i><?php echo $this->_tpl_vars['data']['name']; ?>
</h2>
            <div class="lh-newsRes-info">
            <?php if ($this->_tpl_vars['fn'] == 'news.php'): ?>
            	<span class="eye"><i class="iconfont icon-eye"></i><?php echo $this->_tpl_vars['data']['view']; ?>
</span>
            	<?php endif; ?>
                <div class="lh-newsRes-main"><?php echo $this->_tpl_vars['data']['cont']; ?>
</div>
            </div>
            <!--page-->
            <div class="lh-page">
            	<ul>
                	<li><?php if ($this->_tpl_vars['detailArr'][0]['url']): ?><a href="<?php echo $this->_tpl_vars['detailArr'][0]['url']; ?>
">上一篇：<?php echo $this->_tpl_vars['detailArr'][0]['names']; ?>
</a><?php else: ?>上一篇：没有了<?php endif; ?></li>
                    <li><?php if ($this->_tpl_vars['detailArr'][1]['url']): ?><a href="<?php echo $this->_tpl_vars['detailArr'][1]['url']; ?>
">下一篇：<?php echo $this->_tpl_vars['detailArr'][1]['names']; ?>
</a><?php else: ?>下一篇：没有了<?php endif; ?></li>
                </ul>
                <a href="<?php echo $this->_tpl_vars['dq_menu']['url']; ?>
" class="lh-return">返回列表</a>
            </div>
        </div>
    </div>
</section>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "all/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>