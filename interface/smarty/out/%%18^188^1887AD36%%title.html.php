<?php /* Smarty version 2.6.18, created on 2017-06-12 11:32:40
         compiled from all/title.html */ ?>
<?php if ($this->_tpl_vars['filename'] == '/index.html'): ?>
<title><?php if ($this->_tpl_vars['web']['seoTitle']): ?><?php echo $this->_tpl_vars['web']['seoTitle']; ?>
<?php else: ?><?php echo $this->_tpl_vars['web']['title']; ?>
<?php endif; ?></title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['web']['seoKeyWord']; ?>
">
<meta name="description" content="<?php echo $this->_tpl_vars['web']['seoDes']; ?>
">
<?php else: ?>
    <?php if ($this->_tpl_vars['data']['seoTitle']): ?>
<title><?php echo $this->_tpl_vars['data']['seoTitle']; ?>
</title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['data']['seoKeyWord']; ?>
">
<meta name="description" content="<?php echo $this->_tpl_vars['data']['seoDes']; ?>
">
    <?php elseif ($_GET['pid'] && $this->_tpl_vars['dq_menu']['seoTitle']): ?>
<title><?php echo $this->_tpl_vars['dq_menu']['seoTitle']; ?>
</title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['dq_menu']['seoKeyWord']; ?>
">
<meta name="description" content="<?php echo $this->_tpl_vars['dq_menu']['seoDes']; ?>
">
    <?php elseif ($this->_tpl_vars['m_menu']['seoTitle']): ?>
<title><?php echo $this->_tpl_vars['m_menu']['seoTitle']; ?>
</title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['m_menu']['seoKeyWord']; ?>
">
<meta name="description" content="<?php echo $this->_tpl_vars['m_menu']['seoDes']; ?>
">
    <?php else: ?>
<title><?php if ($this->_tpl_vars['data']['name']): ?><?php echo $this->_tpl_vars['data']['name']; ?>
-<?php echo $this->_tpl_vars['web']['title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['m_menu']['_name'][0]; ?>
-<?php echo $this->_tpl_vars['web']['title']; ?>
<?php endif; ?></title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['web']['title']; ?>
,<?php echo $this->_tpl_vars['m_menu']['name']; ?>
,<?php echo $this->_tpl_vars['data']['name']; ?>
">
<meta name="description" content="<?php echo $this->_tpl_vars['data']['conts']; ?>
">
    <?php endif; ?>
<?php endif; ?>