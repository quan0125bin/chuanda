<?php
$action=$_GET['action'];
require('./class/'.$action.'.class.php');
$curMenu=$api->getMenu($action,$_GET['pid']);
$tpl->assign('pdata',$curMenu);
$title='内容管理【<span class="cRed">'.$curMenu['name'].'</span>】';$tpl->assign('title',$title);
$tpl->assign('add',array('title'=>'主分类','url'=>'javascript:adFilter()'));


$url='?form='.$_GET['form'].'&action='.$_GET['action'].($_GET['pid']?'&pid='.$_GET['pid']:'');
$data=$api->getData();
$data=$api->getDataList($data['data']);
$data=$api->obj->strArrToJson($data);
$tpl->assign('dataJson',$data);
$tpl->assign('del',true);

$tpl->display('admin/ajax/filter.html');