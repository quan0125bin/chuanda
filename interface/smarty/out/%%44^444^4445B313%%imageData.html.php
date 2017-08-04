<?php /* Smarty version 2.6.18, created on 2017-08-02 09:05:41
         compiled from imageData.html */ ?>
<?php unset($this->_sections['d']);
$this->_sections['d']['loop'] = is_array($_loop=$this->_tpl_vars['data']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<li><a href="<?php echo $this->_tpl_vars['data'][$this->_sections['d']['index']]['url']; ?>
">
     <img class="layer-img" layer-src="<?php echo $this->_tpl_vars['data'][$this->_sections['d']['index']]['img_json'][0]['img']; ?>
" src="<?php echo $this->_tpl_vars['data'][$this->_sections['d']['index']]['img_json'][0]['img']; ?>
" alt="" />
    <h2><?php echo $this->_tpl_vars['data'][$this->_sections['d']['index']]['names']; ?>
</h2>
    <div class="shadow"><i></i></div>
</a></li>
<?php endfor; endif; ?>