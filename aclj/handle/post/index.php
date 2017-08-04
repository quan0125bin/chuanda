<?php
require('../../header.php');
foreach($_POST as $k=>$v){
    $_POST[$k]=$api->strHandle($v,'sql');//字符串处理//$_POST[$k]=$api->strHandleRestore($v);//还原
}
$wayArr=array('user','basic','chk','menu','sys','info','image','filter','building','search','ones','vip','viphouse','order');
$sigArr=array('del','state','getData');//单条数据处理
$sigsArr=array('dels');//多条数据处理
if(in_array($_POST['action'],$sigArr) && $_POST['sdata']){
    $arr=$api->strJsonToArr($api->dedes3($_POST['sdata'],true));
    foreach($arr as $k=>$v)$_POST[$k]=$v;
}
if(in_array($_POST['action'],$sigsArr) && $_POST['sdata']){
    $exArr=explode(',',$_POST['sdata']);
    $ids=array();
    foreach($exArr as $v){
	   $arr=$api->strJsonToArr($api->dedes3($v,true));
	   $_POST['way']=$arr['way']?$arr['way']:'';
	   if($arr['id']){
		  $_POST['id'].=$_POST['id']?','.$arr['id']:$arr['id'];
	   }
    }
}
if(!in_array($_POST['way'],$wayArr)){
    echo $api->outResponse('缺少参数');exit;
}
if(!$api->checkRole($_POST)){
    $res=array('error'=>1,'html'=>'权限不足');
    echo $api->outResponse($res,$res['error']?0:1);
    exit;
}
require('../class/'.$_POST['way'].'.class.php');
if($_POST['action']){
    $action=$_POST['action'];
    $res=$api->$action();
    if($_POST['out'])echo $api->obj->outResponse($res,true);
}else{
    echo $api->outResponse('参数错误');
}














