<?php
define("DIR",$_SERVER['DOCUMENT_ROOT']);
require(DIR.'/config/index.php');
require(DIR.'/interface/smarty/config.php');
require(DIR.'/aclj/check.php');//验证请求源
$basicMenu=array(
    array(
	   'id'=>'home','name'=>'系统首页','url'=>'?vid='.$_GET['vid']
    ),
    array(
	   'id'=>'sys','name'=>'系统设置',
	   'data'=>array(
		  array('name'=>'基本信息设置','id'=>'set','url'=>'?form=sys&action=set'),
		  array('name'=>'栏目管理','id'=>'menu','url'=>'?form=sys&action=menu'),
		  array('name'=>'管理员权限管理','id'=>'role','url'=>'?form=sys&action=role'),
		  array('name'=>'网站日志','id'=>'log','url'=>'?form=sys&action=log')
	   )
    )
);
$user=$api->strGetSession('user');
if($user)$_SESSION['user']=$user;












