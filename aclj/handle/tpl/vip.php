<?php
$action=$_GET['action'];
if($_GET['pid'])$action=$_GET['pid'];
require('./class/'.$action.'.class.php');
$title='用户管理';$add=false;

if($action=='viphouse'){
    $title='房管家管理';
    $add=array('title'=>'房管家','url'=>'?form='.$_GET['form'].'&action='.$_GET['action'].'&pid='.$_GET['pid'].'&way=insert');
}elseif($action=='order'){
    $title='看房记录';
}
$tpl->assign('title',$title);$tpl->assign('add',$add);

if($_GET['lid']){
    $larr=$api->obj->strJsonToArr($api->obj->dedes3($_GET['lid']));
    if($larr)$_GET['larr']=$larr;
}

$url='?form='.$_GET['form'].'&action='.$_GET['action'].($_GET['pid']?'&pid='.$_GET['pid']:'');
require('vipRenew.php');//新添数据、更新数据

$data=$api->getData();
$tpl->assign('data',$data);
$thead=array(
    array(),
    array('姓名','20%',true),
    array('电话','8%',true),
    array('性别',0,true),
    array('注册时间','10%',false),
    array('登录时间','10%',false),
    array('基本信息','10%',false),
    array('看房记录','10%',false),
    array('状态',0,true),
    array('操作',0,true)
);
if($action=='order'){
    $thead=array(
	   array(),
	   array('新房','20%',true),
	   array('用户','8%',true),
	   array('房管家',0,true),
	   array('时间','10%',false),
	   array('看房状态',0,true),
	   array('操作',0,true)
    );
    $getChkAll=$api->obj->getChkAll();
}
$tdata=array();$carr=array('way'=>$action);
foreach($data['data'] as $k=>$v){
    $carr['id']=$v['id'];
    /*操作********************************************************************/
    $sdata=$api->obj->endes3($api->obj->strArrToJson($carr),true);
    $html='[<a href="javascript:" sdata="'.$sdata.'" class="cRed delClick" title="删除"></a>]';
    if($action=='order'){
    /**********************************/
	   $hxt=$api->obj->sel($api->dbname.'_info','where bid='.$v['id'],'count(*)',true);
	   $chkw=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['id'],'pkey'=>'bid')),true);
	   $des='<a href="?form=list1&action=list&pid='.$v['pid'].'&lid='.$chkw.'">户型图管理（<span class="cRed">'.($hxt?$hxt[0]:0).'</span>）</a>';
	   
    /**********************************/
	   $chkw=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['pid'],'pkey'=>'id')),true);
	   $pid=explode(',',$v['pid']);$pid=array_filter($pid);
	   $pdata=$api->obj->sel(DbPrefix.'building','where id in('.implode(',',$pid).')','name,id,pid');
	   $pmax=count($pdata);
	   $pname='';
	   foreach($pdata as $kk=>$vv){
		  $pname.='<a href="?form=list&action=list&pid='.$vv['pid'].'&id='.$vv['id'].'" class="click cRed">'.$vv['name'].'</a>';
	   }
	   if(!$pname){
		  $pname='未选择新房';
	   }else{
		  $pname='['.$pmax.']'.$pname;
	   }
	   $chkw=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['vid'],'pkey'=>'vid')),true);
	   $vname='<a href="?form='.$_GET['form'].'&action=vip&pid=vip&lid='.$chkw.'">'.($v['vname']?$v['vname']:($v['vuname']?$v['vuname']:$v['vphone'])).'</a>';
	   $chk='';$cname='未选择';
	   foreach($getChkAll as $gv){
		  $chk.='<option value="'.$gv['id'].'"'.($v['chk']==$gv['id']?' selected="selected"':'').'>'.$gv['txt'].'</option>';
	   }
	   if($v['hid']){
		  $cname=$api->obj->sel(DbPrefix.'viphouse','where id='.$v['hid'],'id,name,uname,phone',true);
		  $chkw=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['hid'],'pkey'=>'vid')),true);
		  $cname='<a href="?form='.$_GET['form'].'&action=vip&pid=viphouse&lid='.$chkw.'">'.($cname['name']?$cname['name']:($cname['uname']?$cname['uname']:$cname['phone'])).'</a>';
	   }
	   $chk='<select class="sel">'.$chk.'</select>';
	   $tdata[]=array($sdata,$pname,$vname,$cname,date('Y-m-d H:i:s',$v['stime']),$chk,$html);
    }else{
	   /*操作********************************************************************/
	   $carr['id']=$v['vid']?$v['vid']:$v['id'];
	   $sdata=$api->obj->endes3($api->obj->strArrToJson($carr),true);
	   $html='[<a href="javascript:" sdata="'.$sdata.'" class="cRed delClick" title="删除"></a>]';
	   /*状态********************************************************************/
	   $chk=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['id'],'way'=>$action,'state'=>'chk','chk'=>$v['chk'])),true);
	   $chk='<a href="javascript:" sdata="'.$chk.'" class="state_'.$v['chk'].' stateClick" addClass="state_'.$v['chk'].'" title="显示状态"></a>';
	   $name=$v['name']?$v['name']:($v['uname']?$v['uname']:'空');
	   $sex=$v['sex']==1?'男':($v['sex']==2?'女':'空');
	   $cont=$v['qq']?('QQ：'.$v['qq']):'';
	   if($v['income'])$cont.=($cont?'<br>':'').'收入：'.$v['income'];
	   if($v['address'])$cont.=($cont?'<br>':'').'地址：'.$v['address'];
	   if(!$cont){$cont='空';}
	   $order=$api->obj->sel(DbPrefix.'order','where vid='.$v['vid'],'count(*)',true);
	   $chkw=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['vid'],'pkey'=>'vid')),true);
	   if($action=='viphouse'){
		  $sdata=$api->obj->endes3($api->obj->strArrToJson($carr),true);
		  $html='<a href="'.$url.'&way=update&sdata='.$sdata.'" class="b">[修改]</a>'.$html;
		  $order=$api->obj->sel(DbPrefix.'order','where hid='.$v['id'],'count(*)',true);
		  $chkw=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['vid'],'pkey'=>'hid')),true);
	   }
	   $order='<a href="?form=vipvip&action=vip&pid=order&lid='.$chkw.'">查看记录（<span class="cRed">'.($order?$order[0]:0).'</span>）</a>';
	   $tdata[]=array($sdata,$name,$v['phone'],$sex,date('Y-m-d H:i:s',$v['rtime']),date('Y-m-d H:i:s',$v['stime']),$cont,$order,$chk,$html);
    }
}

$tpl->assign('max',$data['max']);
$tpl->assign('page',$data['page']);
$tpl->assign('tdata',$tdata);
$tpl->assign('thead',$thead);
$tpl->assign('del',true);

$tpl->display('admin/ajax/list.html');