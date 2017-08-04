<?php
/**顶级栏目*二级栏目*当期栏目******************/
$menuNeed='id,pid,name,nname,seoTitle,seoKeyWord,seoDes,cont,url,type,img,image';$menu=array();$dq_menu=array();
$m_menu=$api->sel(DbPrefix.'menu','where url=\''.$filename.'\' and pid=0',$menuNeed,true);
if($m_menu){
    $m_menu=$api->removeNumKey($m_menu);
    if($m_menu['img']){
	   $m_menu['img_json']=$api->strJsonToArr($m_menu['img']);
	   if(!$m_menu['img_json']){
		  $m_menu['img_json']=$api->strJsonToArr($api->strHandleRestore($m_menu['img']));
	   }
	   $m_menu['img_json']=$api->strImgShow($m_menu['img_json']);
    }
    if($m_menu['image']){
	   $m_menu['image_json']=$api->strJsonToArr($m_menu['image']);
	   if(!$m_menu['image_json']){
		  $m_menu['image_json']=$api->strJsonToArr($api->strHandleRestore($m_menu['image']));
	   }
	   $m_menu['image_json']=$api->strImgShow($m_menu['image_json']);
    }
    $m_menu['url']=$api->strGetUrl($m_menu['url']);
    if($m_menu['name'])$m_menu['_name']=explode('|',$m_menu['name']);
    $tpl->assign('m_menu',$m_menu);
    $menu=$api->sel(DbPrefix.'menu','where pid='.$m_menu['id'].' and chk=1 order by rank,id',$menuNeed);
    foreach($menu as $k=>$v){
	   $menu[$k]=$api->removeNumKey($v);
	   $menu[$k]['url']=$api->strGetUrl($filename,$v['id']);
    }
    if($_GET['pid']){
	   $dq_menu=$api->sel(DbPrefix.'menu','where id='.$_GET['pid'],$menuNeed,true);
    }else{
	   $dq_menu=$menu?$menu[0]:array();
    }
    if($dq_menu)$dq_menu['url']=$api->strGetUrl($filename,$dq_menu['id']);
    if($dq_menu['type']==99){
	   if($dq_menu['img']){
		  $dq_menu['img_json']=$api->strJsonToArr($dq_menu['img']);
		  if(!$dq_menu['img_json']){
			 $dq_menu['img_json']=$api->strJsonToArr($api->strHandleRestore($dq_menu['img']));
		  }
		  $dq_menu['img_json']=$api->strImgShow($dq_menu['img_json']);
	   }
    }
    $tpl->assign('menu',$menu);
    $tpl->assign('dq_menu',$dq_menu);
}