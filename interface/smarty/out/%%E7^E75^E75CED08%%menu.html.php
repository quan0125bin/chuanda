<?php /* Smarty version 2.6.18, created on 2017-06-12 11:32:40
         compiled from all/menu.html */ ?>
    	<dl class="left lh-mob-nav">
        	<dt>
            	<h2><?php echo $this->_tpl_vars['m_menu']['name']; ?>
</h2>
                <h3><?php echo $this->_tpl_vars['m_menu']['nname']; ?>
</h3>
            </dt>
            <?php unset($this->_sections['m']);
$this->_sections['m']['loop'] = is_array($_loop=$this->_tpl_vars['menu']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['m']['name'] = 'm';
$this->_sections['m']['show'] = true;
$this->_sections['m']['max'] = $this->_sections['m']['loop'];
$this->_sections['m']['step'] = 1;
$this->_sections['m']['start'] = $this->_sections['m']['step'] > 0 ? 0 : $this->_sections['m']['loop']-1;
if ($this->_sections['m']['show']) {
    $this->_sections['m']['total'] = $this->_sections['m']['loop'];
    if ($this->_sections['m']['total'] == 0)
        $this->_sections['m']['show'] = false;
} else
    $this->_sections['m']['total'] = 0;
if ($this->_sections['m']['show']):

            for ($this->_sections['m']['index'] = $this->_sections['m']['start'], $this->_sections['m']['iteration'] = 1;
                 $this->_sections['m']['iteration'] <= $this->_sections['m']['total'];
                 $this->_sections['m']['index'] += $this->_sections['m']['step'], $this->_sections['m']['iteration']++):
$this->_sections['m']['rownum'] = $this->_sections['m']['iteration'];
$this->_sections['m']['index_prev'] = $this->_sections['m']['index'] - $this->_sections['m']['step'];
$this->_sections['m']['index_next'] = $this->_sections['m']['index'] + $this->_sections['m']['step'];
$this->_sections['m']['first']      = ($this->_sections['m']['iteration'] == 1);
$this->_sections['m']['last']       = ($this->_sections['m']['iteration'] == $this->_sections['m']['total']);
?>
            <dd <?php if ($this->_tpl_vars['dq_menu']['id'] == $this->_tpl_vars['menu'][$this->_sections['m']['index']]['id']): ?>class="active" <?php endif; ?>data-animated="fadeInUp"><a href="<?php echo $this->_tpl_vars['menu'][$this->_sections['m']['index']]['url']; ?>
"><?php echo $this->_tpl_vars['menu'][$this->_sections['m']['index']]['name']; ?>
</a></dd>
            <?php endfor; endif; ?>
        </dl>