<?php
$action=$_GET['action'];
require('./class/'.$action.'.class.php');
$curMenu=$api->getMenu($action,$_GET['pid']);
$tpl->assign('pdata',$curMenu);
$title='内容管理【<span class="cRed">'.$curMenu['name'].'</span>】';$tpl->assign('title',$title);
$tpl->assign('add',array('title'=>'内容','url'=>'?form='.$_GET['form'].'&action='.$_GET['action'].'&pid='.$_GET['pid'].'&way=insert'));
$url='?form='.$_GET['form'].'&action='.$_GET['action'].($_GET['pid']?'&pid='.$_GET['pid']:'');
if($_GET['pid']=='mes'){
    $tpl->assign('add',false);
    $thead=array(
	   array(),
	   array('姓名','20%',true),
	   array('联系方式',0,false),
	   array('留言内容',0,false),
	   array('提交时间','10%',false),
	   array('处理状态',0,true),
	   array('操作',0,true)
    );
    $where='where id>0';
    $data=$api->obj->sel(DbPrefix.'mes',$where,'count(*)',true);
    $max=$data?$data[0]:0;
    include_once(DIR.'/class/pageClass.class.php');
    $page=new pageClass($max,$_GET['page']?$_GET['page']:1,$_GET['psize']?$_GET['psize']:20);
    $data=$api->obj->sel(DbPrefix.'mes',$where.' order by id desc','*');
    $tdata=array();
    $data=array('max'=>$max,'page'=>$page->out(),'data'=>$data);
    foreach($data['data'] as $k=>$v){
	   /*状态********************************************************************/
	   $chk=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['id'],'way'=>$action,'db'=>'mes','state'=>'chk','chk'=>$v['chk'])),true);
	   $chk='<a href="javascript:" sdata="'.$chk.'" class="state_'.$v['chk'].' stateClick" addClass="state_'.$v['chk'].'" title="处理状态"></a>';
	   /*操作********************************************************************/
	   $sdata=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['id'],'way'=>$action,'db'=>'mes')),true);
	   $html='[<a href="javascript:" sdata="'.$sdata.'" class="cRed delClick" title="删除"></a>]';
	   /*********************************************************************/
	   $tel=($v['title']?('电话：'.$v['title']):'');
	   $tel.=($tel?'<br>':'').($v['email']?('邮箱：'.$v['email']):'');
	   $tdata[]=array($sdata,$v['name'],$tel,$v['cont'],date('Y-m-d H:i:s',$v['stime']),$chk,$html);
    }
}else{
    require('imageRenew.php');//新添数据、更新数据
    $data=$api->getData();
    $tpl->assign('data',$data);
    $thead=array(
	   array(),
	   array('标题','20%',true),
	   array('排序','8%',true),
	   array('内容',0,false),
	   array('添加时间','10%',false),
	   array('添加帐号','8%',false),
	   array('更新帐号','8%',false),
	   array('显示',0,true),
	   array('操作',0,true)
    );
    $tdata=array();
    foreach($data['data'] as $k=>$v){
	   /*状态********************************************************************/
	   $chk=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['id'],'way'=>$action,'state'=>'chk','chk'=>$v['chk'])),true);
	   $hchk=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['id'],'way'=>$action,'state'=>'hchk','hchk'=>$v['hchk'])),true);
	   $mchk=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['id'],'way'=>$action,'state'=>'mchk','mchk'=>$v['mchk'])),true);
	   $chk='<a href="javascript:" sdata="'.$chk.'" class="state_'.$v['chk'].' stateClick" addClass="state_'.$v['chk'].'" title="显示状态"></a>';
	   /*操作********************************************************************/
	   $sdata=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['id'],'way'=>$action)),true);
	   $html='<a href="'.$url.'&way=update&sdata='.$sdata.'" class="b">[修改]</a>';
	   $html.='[<a href="javascript:" sdata="'.$sdata.'" class="cRed delClick" title="删除"></a>]';
	   $name='<a href="'.$url.'&way=update&sdata='.$sdata.'">'.$v['name'].'</a>';
	   /*排序********************************************************************/
	   $rank='';
	   $rank='<input type="text" value="'.$v['rank'].'" class="inp tc rankUpdate" sdata="'.$rank.'" maxlength="11">';
	   /*操作内容介绍********************************************************************/
	   if($v['img']){
		  $img=$api->obj->strJsonToArr($v['img'],true);
		  $des='<a href="/upload/'.$img[0]['img'].'" target="_blank"><img src="/upload/thumb.png" width="20"></a>';
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
	   $tdata[]=array($sdata,$name,$rank,$des,date('Y-m-d H:i:s',$v['stime']),$auser,$uuser,$chk,$html);
    }

}
$tpl->assign('max',$data['max']);
$tpl->assign('page',$data['page']);
$tpl->assign('tdata',$tdata);
$tpl->assign('thead',$thead);
$tpl->assign('del',true);

$tpl->display('admin/ajax/list.html');