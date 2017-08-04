<?php
$data=$api->sel($dbname,$where,'count(*)',true);
$max=$data?$data[0]:0;
if($_POST['page'])$_GET['page']=$_POST['page'];
$page=new pagesClass($max,$_GET['page']?$_GET['page']:1,$num);
$data=$api->sel($dbname,$where.$order.$page->limit,$need);
$data=$api->strTitleSub($data,35,60,$filename);
foreach($data as $k=>$v){
 unset($v['id'],$v['pid'],$v['img'],$v['pid']);
 $data[$k]=$api->removeNumKey($v);
 if($v['ccont'])$data[$k]['ccont']=$api->strHandleRestore($v['ccont']);
 if($v['cont'])$data[$k]['cont']=$api->strHandleRestore($v['cont']);
 if($v['image_json']){
    foreach($v['image_json'] as $kk=>$vv){
	   $img=explode('.',$vv['img']);
	   if($img[1]=='mp4'){
		  $data[$k]['video']=$vv['img'];
	   }
    }
 }
 if($dq_menu['type']==22 && is_numeric($v['come'])){
    $come=$api->sel(DbPrefix.'image','where pid=\'qk\' and id='.$v['come'].' and chk=1','name',true);
    $data[$k]['comeId']=$v['come'];
    $data[$k]['come']=$come['name'];
 }
}
$tpl->assign('page',$page->out());
$tpl->assign('data',$data);