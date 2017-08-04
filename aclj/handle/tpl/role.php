<?php
require('./class/user.class.php');
$url='?form='.$_GET['form'].'&action='.$_GET['action'];
if($_GET['way']){
    $way='insert';$tpl->assign('return',array('title'=>'返回','url'=>$url));
    if($_GET['way']=='update' && $_GET['sdata']){
	   $sdata=$api->obj->strJsonToArr($api->obj->dedes3($_GET['sdata']));
	   $_POST['id']=$sdata['id'];
	   $data=$api->getData($sdata);
	   if($data['data']){
		  $way='update';
		  $data=$data['data'][0];
		  $data['id']=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$data['id'])));
		  $tpl->assign('data',$data);
	   }
    }
    $tpl->assign('way',$way);$tpl->assign('form',true);
    $tpl->display('admin/ajax/form/user.html');
    exit;
}
$data=$api->getData();
$tpl->assign('data',$data);
$thead=array(
    array(),
    array('昵称',0,true),
    array('帐号',0,false),
    array('权限',0,false),
    array('注册时间',0,false),
    array('登录时间',0,true),
    array('登录状态',0,true),
    array('操作',0,true)
);
$tdata=array();
foreach($data['data'] as $k=>$v){
    $chk=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['id'],'way'=>'user','state'=>'chk','chk'=>$v['chk'])),true);
    $chk='<a href="javascript:" sdata="'.$chk.'" class="state_'.$v['chk'].' stateClick" addClass="state_'.$v['chk'].'"></a>';
    $sdata=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['id'],'way'=>'user')),true);
    $html='<a href="'.$url.'&way=update&sdata='.$sdata.'">[修改]</a>';
    $html.='[<a href="javascript:" sdata="'.$sdata.'" class="cRed delClick" title="删除"></a>]';
    $uname=$v['uname']?$v['uname']:$v['name'];
    $role='<span class="cRed">超级管理员</span>';
    if($v['role']){
	   $role='普通用户';
    }
    $tdata[]=array($sdata,$uname,$v['name'],$role,date('Y-m-d H:i:s',$v['rtime']),date('Y-m-d H:i:s',$v['stime']),$chk,$html);
}

$tpl->assign('max',$data['max']);
$tpl->assign('page',$data['page']);
$tpl->assign('tdata',$tdata);
$tpl->assign('thead',$thead);
$tpl->assign('del',true);

$tpl->display('admin/ajax/list.html');