<?php
require('./class/'.$_GET['action'].'.class.php');
$data=$api->getData();
$tpl->assign('data',$data);
$thead=array(
    array(),
    array('用户',0,true),
    array('对象',0,true),
    array('操作步骤',0,true),
    array('操作',0,true),
    array('时间',0,true)
);
$tdata=array();
foreach($data['data'] as $k=>$v){
    $sdata=$api->obj->endes3($api->obj->strArrToJson(array('id'=>$v['id'],'way'=>'log')),true);
    $aname='帐号删除';
    if($v['aid']){
	   $adata=$api->obj->sel(DbPrefix.'user','where id='.$v['aid'],'uname,name',true);
	   $adata=$adata?('<a href="?form=sys&action=role&name='.($adata['uname']?$adata['uname']:$adata['name']).'" class="cRed">'.($adata['uname']?$adata['uname']:$adata['name']).'</a>'):$aname;
    }else{
	   $adata=$aname;
    }
    $html='';
    if($v['remark']){
	   $remark=$api->obj->strJsonToArr($v['remark']);$rhtml='';
	   foreach($remark as $rk=>$rv){
		  if(!is_numeric($rk))$rhtml.='<br><b>'.$rk.'：</b>'.$rv;
	   }
	   $html='<a href="javascript:alertLj($(\'.remark'.$v['id'].'\').html())" class="cRed">查看旧数据</a><div class="remark'.$v['id'].' dn"><div class="tl">'.$rhtml.'</div></div>';
    }
    $tdata[]=array($sdata,$adata,$v['title'],$v['way'],$html,date('Y-m-d H:i:s',$v['time']));
}
$tpl->assign('max',$data['max']);
$tpl->assign('page',$data['page']);
$tpl->assign('tdata',$tdata);
$tpl->assign('thead',$thead);
$tpl->assign('del',false);

$tpl->display('admin/ajax/list.html');