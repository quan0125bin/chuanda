<?php
if(!is_numeric($_GET['pid'])){
    $title='错误';$tpl->assign('title',$title);
    $tpl->display('admin/ajax/error.html');exit;
}
$curMenu=$api->sel(DbPrefix.'menu','where id='.$_GET['pid'],'id,pid,type,name',true);
if(!$curMenu){
    $title='错误';$tpl->assign('title',$title);
    $tpl->display('admin/ajax/error.html');exit;
}
$tpl->assign('curMenu',$curMenu);
$action='info';
$thead=array(
    array(),
    array('标题','20%',true),
    array('排序','8%',true),
    array('内容',0,false),
    array('添加时间','10%',false),
    array('添加帐号','8%',false),
    array('更新帐号','8%',false),
    array('显示/首页',0,true),
    array('操作',0,true)
);
$add=array('title'=>'内容','url'=>'?form='.$_GET['form'].'&action='.$_GET['action'].'&pid='.$_GET['pid'].'&way=insert');
$title='内容管理【<span class="cRed">'.$curMenu['name'].'</span>】';
$oneArr=array(30);
if(in_array($curMenu['type'],$oneArr)){
	$action='ones';
}elseif($curMenu['type']==33){
	$tpl->display('admin/ajax/home.html');
	echo '<script type="text/javascript">alertLj("固定栏目，无需更新~<br>在线留言请前往\'下拉管理\'")</script>';
	exit;
}elseif($curMenu['type']==32){
    $_GET['db']='pro';
}elseif($curMenu['type']==31){
	$tpl->display('admin/ajax/home.html');
	echo '<script type="text/javascript">alertLj("固定栏目，无需更新")</script>';
	exit;
}
require('./class/'.$action.'.class.php');
$tpl->assign('title',$title);$tpl->assign('add',$add);

if(in_array($curMenu['type'],$oneArr)){
	$action='ones';$tpl->assign('add',false);
	$data=$api->getData();
	$tpl->assign('data',$data['data']);
	$tpl->display('admin/ajax/form/ones.html');exit;
}
$url='?form='.$_GET['form'].'&action='.$_GET['action'].($_GET['pid']?'&pid='.$_GET['pid']:'').($_GET['lid']?'&lid='.$lid:'');
require('listRenew.php');//新添数据、更新数据
$data=$api->getData();
$tpl->assign('data',$data);
$tdata=array();$carr=array('way'=>$action);

if($_GET['returnUrl'])$tpl->assign('returnUrl',array('title'=>'返回','url'=>urldeCode($_GET['returnUrl'])));
if($_GET['lid'])$carr['lid']=$_GET['lid'];
if($_GET['db'])$carr['db']=$_GET['db'];
foreach($data['data'] as $k=>$v){
    /*状态********************************************************************/
    $carr['id']=$v['id'];$carrState=$carr;
    $carrState['state']='chk';$carrState[$chkw['state']]=$v[$carrState['state']];
    $chkw=$api->obj->endes3($api->obj->strArrToJson($carrState),true);
    $chk='<a href="javascript:" sdata="'.$chkw.'" class="state_'.$v['chk'].' stateClick" addClass="state_'.$v['chk'].'" title="显示状态"></a>';
    $carrState['state']='hchk';$carrState[$chkw['state']]=$v[$carrState['state']];
    $chkw=$api->obj->endes3($api->obj->strArrToJson($carrState),true);
    $chk.='<a href="javascript:" sdata="'.$chkw.'" class="state_'.$v['hchk'].' stateClick" addClass="state_'.$v['hchk'].'" title="首页状态"></a>';
    /*操作********************************************************************/
    $sdata=$api->obj->endes3($api->obj->strArrToJson($carr),true);
    $html='<a href="'.$url.'&way=update&sdata='.$sdata.'" class="b">[修改]</a>';
    $html.='[<a href="javascript:" sdata="'.$sdata.'" class="cRed delClick" title="删除"></a>]';
    $name='<a href="'.$url.'&way=update&sdata='.$sdata.'" class="b">'.$v['name'].'</a>';
    /*排序********************************************************************/
    $rank='';
    $rank='<input type="text" value="'.$v['rank'].'" class="inp tc rankUpdate" sdata="'.$rank.'" maxlength="11">';
    /*操作内容介绍********************************************************************/
    if($v['cchk']){
	   $des='<img src="/upload/thumb.png" width="20">';
    }else{
	   $des=$v['ccont']?$api->obj->strSub($api->obj->strHandleRestore($v['ccont']),20):$v['cont']?$api->obj->strSub($api->obj->strHandleRestore($v['cont']),20):'暂无内容';
    }
    
    /*添加更新帐号信息********************************************************************/
    $auser=$uuser='无';
    if($v['aid']){
	   $user=$api->obj->sel(DbPrefix.'user','where id='.$v['aid'],'name,uname',true);
	   if($user){
		  $auser=$user['uname']?$user['uname']:$user['name'];
		  $auser='<a href="?form=sys&action=role&name='.$user['name'].'" class="alink">'.$auser.'</a>';
	   }
    }
    if($v['uid']){
	   $user=$api->obj->sel(DbPrefix.'user','where id='.$v['uid'],'name,uname',true);
	   if($user){
		  $uuser=$user['uname']?$user['uname']:$user['name'];
		  $uuser='<a href="?form=sys&action=role&name='.$user['name'].'" class="alink">'.$uuser.'</a>';
	   }
    }
    /*********************************************************************/
    $tdata[]=array($sdata,$name,$rank,$des,$v['stime'],$auser,$uuser,$chk,$html);
}

$tpl->assign('max',$data['max']);
$tpl->assign('page',$data['page']);
$tpl->assign('tdata',$tdata);
$tpl->assign('thead',$thead);
$tpl->assign('del',true);

$tpl->display('admin/ajax/list.html');