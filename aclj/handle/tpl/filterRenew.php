<?php
//新添数据、更新数据
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
		  if($data['ccont'])$data['ccont']=$api->obj->strHandleRestore($data['ccont']);
		  if($data['cont'])$data['cont']=$api->obj->strHandleRestore($data['cont']);
		  if($data['img'])$data['img']=$api->obj->strHandleRestore($data['img']);
		  $tpl->assign('data',$data);
	   }
    }
    $tpl->assign('way',$way);$tpl->assign('form',true);
    $tpl->display('admin/ajax/form/filter.html');
    exit;
}