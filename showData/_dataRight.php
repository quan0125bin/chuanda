<?php
$left=$api->sel(DbPrefix.'image','where pid=\'left\' and chk=1 order by rank desc,id desc');
$left=$api->strTitleSub($left);
$tpl->assign('left',$left);