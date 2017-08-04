<?php
require('./class/basic.class.php');
$data=$api->getData();
$way='insert';
if($data)$way='update';
$tpl->assign('way',$way);
$tpl->assign('data',$data);

$tpl->display('admin/ajax/basic.html');











