<?php
require('./class/'.$_GET['action'].'.class.php');
$url='?form='.$_GET['form'].'&action='.$_GET['action'];
if($_GET['way']){
    $way='insert';$tpl->assign('return',array('title'=>'返回','url'=>$url));
    if($_GET['way']=='update' && $_GET['sdata']){
	   $sdata=$api->obj->strJsonToArr($api->obj->dedes3($_GET['sdata']));
	   if($sdata['pid']){
		  $_POST['chk']=0;
		  $pdata=$api->getData();
		  $pdata=$api->getMenuList($pdata['data']);
		  $tpl->assign('pdata',$pdata);
	   }
	   if($sdata['id']){
		  $_POST['id']=$sdata['id'];
		  $data=$api->getData($sdata);
		  if($data['data']){
			 $way='update';
			 $data=$data['data'][0];
			 $data['id_']=$data['id'];
			 $data['id']=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$data['id'])));
			 $tpl->assign('data',$data);
		  }
	   }
	   $tpl->assign('sdata',$sdata);
    }
    $tpl->assign('form',true);
    $tpl->assign('way',$way);
    $tpl->display('admin/ajax/form/menu.html');
    exit;
}
$data=$api->getData();
$data['data']=$api->getMenu($data['data']);
$thead=array(
    array(),
    array('栏目名称',0,true),
    array('排序','8%',false),
    array('类型','12%',false),
    array('地址',0,false),
    array('顶部/底部',0,true),
    array('子栏目',0,true),
    array('操作',0,true)
);
$tpl->assign('url',$url);
/*
$tdata=array();
foreach($data['data'] as $k=>$v){
    $chk=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['id'],'way'=>$_GET['action'],'state'=>'chk','chk'=>$v['chk'])),true);
    $chk='<a href="javascript:" sdata="'.$chk.'" class="state_'.$v['chk'].' stateClick" addClass="state_'.$v['chk'].'"></a>';
    $sdata=$api->obj->endes3($api->obj->strArrToJson(array('pid'=>$v['id'],'way'=>$_GET['action'])),true);
    $add='<a href="'.$url.'&way=update&sdata='.$sdata.'">[添加子栏目]</a>';
    $sdata=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['id'],'way'=>$_GET['action'])),true);
    $html='<a href="'.$url.'&way=update&sdata='.$sdata.'">[修改]</a>';
    $html.='[<a href="javascript:" sdata="'.$sdata.'" class="cRed delClick">删除</a>]';
    $tdata[]=array($sdata,$v['name'],$uname,$v['url'],$chk,$add,$html);
}
*/
$data=$api->obj->strArrToJson($data['data']);
$tpl->assign('dataJson',$data);
$tpl->assign('thead',$thead);
$tpl->assign('del',true);

$tpl->display('admin/ajax/menu.html');