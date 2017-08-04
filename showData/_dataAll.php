<?php
require(DIR.'/class/pagesClass.class.php');
/**数据调用*****************************/
$dbname=DbPrefix.'info';$need='id,pid,name,lname,come,ccont,cont,img,image,stime,view,cchk,url,seoTitle,seoKeyWord,seoDes';$where='where chk=1 and pid='.$dq_menu['id'];$order=' order by rank desc,id desc ';$num=10;
$oneArr=array(30);
if(in_array($dq_menu['type'],$oneArr)){
	$dbname=DbPrefix.'ones';$need='name,stime,img,video,cont,seoTitle,seoKeyWord,seoDes';$where=' where pid='.$dq_menu['id'];
}elseif($dq_menu['type']=='32'){
    $dbname=DbPrefix.'pro';
    $need='id,pid,name,lname,ccont,cont,img,image,stime,view,cchk,url,seoTitle,seoKeyWord,seoDes';
    $need.=',address,num,tel,email';
}
if($_GET['v']){
    $where.=' and instr(name,\''.$api->strHandle($_GET['v']).'\')';
}
if(is_numeric($_GET['c'])){
    $where.=' and come=\''.$_GET['c'].'\'';
}
include_once(DIR.'/showData/_dataRight.php');
include_once(DIR.'/showData/_dataId.php');
if(in_array($dq_menu['type'],$oneArr)){
	$data=$api->sel($dbname,$where,$need,true);
	if($data && $data['cont']){
		$data['cont']=$api->strHandleRestore($data['cont']);
	}
	$tpl->assign('data',$data);
}elseif($dq_menu['type']==99){
    $data=$api->sel(DbPrefix.'menu','where pid='.$dq_menu['id'].' and chk=1 order by rank,id',$menuNeed);
    foreach($data as $k=>$v){
	   $data[$k]['url']=$api->strGetUrl($filename,$v['id']).'?p='.$dq_menu['id'];
	   $cont=60;
        if($v['img']){
            $v['img_json']=$api->strJsonToArr($v['img']);
            if(!$v['img_json']){
                $v['img_json']=$api->strJsonToArr($api->strHandleRestore($v['img']));
            }
            $data[$k]['img_json']=$api->strImgShow($v['img_json']);
        }
	   if($v['type']==30){
		  $zdata=$api->sel(DbPrefix.'ones',' where pid='.$v['id'],'id,pid,name,img,cont');$cont=250;
		  $zdata=$api->strTitleSub($zdata,0,$cont,$filename);
	   }else{
		  $zdata=$api->sel(DbPrefix.'info',' where pid='.$v['id'].' and chk=1 order by rank desc,id desc limit 1','id,pid,name,lname,ccont,cont,img');$cont=0;
		  $zdata=$api->strTitleSub($zdata,35,$cont,$filename);
	   }
	   $data[$k]['zdata']=$zdata;
    }
	$tpl->assign('data',$data);
}else{
    include_once(DIR.'/showData/_dataData.php');
}
