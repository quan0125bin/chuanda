<?php
require('../header.php');
if($_POST['action']=='getCode'){
    echo $api->outResponse($_SESSION['code'],true);
    exit;
}
if(!$_SESSION['user']){
    header('Ac-Title:'.urlencode('登录'));
    $tpl->display('admin/ajax/login.html');exit;
}
function getBasicMenu($arr,$id){
    foreach($arr as $v){
	   if($v['id']==$id){
		  return $v;
	   }
    }
}
$karr=array('form','action','pid');$rest=true;
function checkStr($str){
  $type='/^[a-zA-z0-9]*$/';//手机
  preg_match_all($type,$str,$rest);
  if(!$rest[0][0]){return false;}
  return true;
}
foreach($_GET as $k=>$v){
    if(in_array($k,$karr)){
	   if($rest)$rest=checkStr($v);
    }
}
if(!$rest){
    $tpl->display('admin/ajax/error.html');exit;
}
$basicMenu=$api->getRoleMenu($basicMenu,'sys');
$tpl->assign('basicMenu',$basicMenu);
/*
数据保存：$tpl->assign('form',true);
数据添加：$tpl->assign('add',array('title'=>'主题','url'=>'a'));
*/
if($_GET['action']=='out'){
    $api->strOutSession(array('user'));
    header('location:./');exit;
}elseif($_GET['action']=='home'){
    $title='系统首页';$tpl->assign('title',$title);
    require('tpl/home.php');exit;
}elseif($_GET['action']=='set'){
    $title='基本信息设置';$tpl->assign('title',$title);
    $tpl->assign('form',true);
    header('Ac-Title:'.urlencode($title));
    require('tpl/basic.php');exit;
}elseif($_GET['action']=='role'){
    $title='管理员权限';$tpl->assign('title',$title);
    $ndata=getBasicMenu($basicMenu[1]['data'],$_GET['action']);
    $tpl->assign('add',array('title'=>'管理员','url'=>$ndata['url'].'&way=insert'));
    header('Ac-Title:'.urlencode($title));
    require('tpl/role.php');exit;
}elseif($_GET['action']=='menu'){
    $title='栏目管理';$tpl->assign('title',$title);
    $ndata=getBasicMenu($basicMenu[1]['data'],$_GET['action']);
    $tpl->assign('add',array('title'=>'栏目','url'=>$ndata['url'].'&way=insert'));
    header('Ac-Title:'.urlencode($title));
    require('tpl/menu.php');exit;
}elseif($_GET['action']=='log'){
    $title='网站日志';$tpl->assign('title',$title);
    $ndata=getBasicMenu($basicMenu[1]['data'],$_GET['action']);
    header('Ac-Title:'.urlencode($title));
    require('tpl/log.php');exit;
}elseif($_GET['action']=='list'){
    require('tpl/list.php');exit;
}elseif($_GET['action']=='filter'){
    require('tpl/filter.php');exit;
}elseif($_GET['action']=='image'){
    require('tpl/image.php');exit;
}elseif($_GET['action']=='vip'){
    require('tpl/vip.php');exit;
}elseif($_GET['action']=='chamberlain'){
    require('tpl/chamberlain.php');exit;
}elseif($_GET['vid']){
    header('Ac-Title:'.urlencode('欢迎使用'));
    $tpl->assign('way',$_GET['way']?$_GET['way']:'menu');
    $tpl->display('admin/ajax/index.html');
}else{
    header('Ac-Title:'.urlencode('重新登录'));
    $tpl->display('admin/ajax/login.html');exit;
}

