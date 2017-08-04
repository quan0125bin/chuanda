<?php
//新添数据、更新数据
if($_GET['way']){
    $way='insert';$tpl->assign('return',array('title'=>'返回','url'=>$url));
    $ddata=$api->obj->sel(DbPrefix.'menu','where id='.$_GET['pid'],'id,type,name',true);
    $mdata=$api->getData(array('id'=>$_GET['lid']));
    if($mdata['data'] && $mdata['data'][0])$tpl->assign('mdata',$mdata['data'][0]);
    $pdata=$api->obj->sel(DbPrefix.'menu','where pid in(select pid from '.DbPrefix.'menu where id='.$_GET['pid'].')');
    $tpl->assign('pdata',$pdata);
    $tpl->assign('pid',$_GET['lid']?$_GET['lid']:$_GET['pid']);
    $tpl->assign('ddata',$ddata);
    if($_GET['way']=='update' && $_GET['sdata']){
	   $sdata=$api->obj->strJsonToArr($api->obj->dedes3($_GET['sdata']));
	   $data=$api->getData($sdata,true);
	   if($data['data']){
		  $way='update';
		  $data=$data['data'][0];
		  $data['id']=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$data['id'])));
		  if($data['ccont'])$data['ccont']=$api->obj->strHandleRestore($data['ccont']);
		  if($data['cont'])$data['cont']=$api->obj->strHandleRestore($data['cont']);
		  if($data['cont_c'])$data['cont_c']=$api->obj->strHandleRestore($data['cont_c']);
		  if($data['cont_y'])$data['cont_y']=$api->obj->strHandleRestore($data['cont_y']);
		  if($data['img'])$data['img']=$api->obj->strHandleRestore($data['img']);
		  $tpl->assign('data',$data);
	   }
    }
    $tpl->assign('way',$way);$tpl->assign('form',true);
    if($ddata['type']==32){
	   $tpl->display('admin/ajax/form/news2.html');
    }else{
        $tpl->display('admin/ajax/form/news.html');
    }
    exit;
}