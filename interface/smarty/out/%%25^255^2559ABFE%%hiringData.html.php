<?php /* Smarty version 2.6.18, created on 2017-06-12 11:35:49
         compiled from hiringData.html */ ?>
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
<li data-animated="fadeInUp">
    <h2 class="lh-recruit-h"><em>1</em><span><?php echo $this->_tpl_vars['data'][$this->_sections['d']['index']]['names']; ?>
</span><b><?php echo $this->_tpl_vars['data'][$this->_sections['d']['index']]['num']; ?>
名</b><i class="iconfont icon-xiangxia"></i></h2>
    <div class="lh-recruit-info">
         <h2 style="color:#0053b0; font-size:16px;">职位描述：</h2>
        <?php echo $this->_tpl_vars['data'][$this->_sections['d']['index']]['ccont']; ?>

              <h2 style="color:#0053b0; font-size:16px;">职位要求：</h2>
         <?php echo $this->_tpl_vars['data'][$this->_sections['d']['index']]['cont']; ?>

              <h2 style="color:#0053b0; font-size:16px;">工作地点： <?php echo $this->_tpl_vars['data'][$this->_sections['d']['index']]['address']; ?>
      联系方式： <?php echo $this->_tpl_vars['data']['tel']; ?>
      邮箱： <?php echo $this->_tpl_vars['data'][$this->_sections['d']['index']]['email']; ?>
</h2>
    </div>
</li>
<?php endfor; endif; ?>