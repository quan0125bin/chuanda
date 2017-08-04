<?php
define("DIR",$_SERVER['DOCUMENT_ROOT']);
require(DIR.'/config/index.php');
require(DIR.'/interface/smarty/config.php');
if($_POST['action']=='sub'){
    $arr=array('name'=>$_POST['name'],'title'=>$_POST['tel'],'email'=>$_POST['email'],'cont'=>$_POST['cont'],'stime'=>time());
    if(!$arr['name']){
	   echo json_encode(array('error'=>1,'html'=>'请填写您的姓名'));exit;
    }
    if($arr['title'] && !$api->strCheckPhone($arr['title'])){
	   echo json_encode(array('error'=>1,'html'=>'请填写正确的电话号码，座机请加上区号'));exit;
    }
    if($arr['email'] && !$api->strCheckEmail($arr['email'])){
	   echo json_encode(array('error'=>1,'html'=>'请填写正确的Email'));exit;
    }
    if($_COOKIE['mes']){
	   echo json_encode(array('error'=>1,'html'=>'请勿重复提交'));exit;
    }
    $res=$api->insert(DbPrefix.'mes',$arr);
    if($res){
	   setcookie('mes',1,time()+10);
	   echo json_encode(array('error'=>0,'html'=>'提交成功'));exit;
    }else{
	   echo json_encode(array('error'=>1,'html'=>'提交失败，请重新提交'));exit;
    }
    
    exit;
}
/*pcWeb********************************/
$clientData=$_SERVER['HTTP_USER_AGENT'];$webTpl='';
if(stristr($clientData,'MicroMessenger')){//判断是否在微信              显示WAP端   优先级最高
    $webTpl='web/';
}elseif(stristr($clientData,'QQ') && !stristr($clientData,'windows')){//判断是否在QQ                          显示WAP端
    $webTpl='web/';
}elseif(stristr($clientData,'Safari') && stristr($clientData,'iPhone')){//判断是否在Safari                  显示WAP端
    $webTpl='web/';
}elseif(stristr($clientData,'iphone')){//判断是否在苹果手机            显示WAP端
    $webTpl='web/';
}elseif(stristr($clientData,'android')){//判断是否在android手机        显示WAP端
    $webTpl='web/';
}else{//				显示PC端     优先级最低
}
$webTpl='';
/*web********************************/
$web=$api->sel(DbPrefix.'basic','','*',true);
foreach($web as $k=>$v){
    $web[$k]=$api->strHandleRestore($v);
}
if($web && $web['cont'])$web['cont']=$api->strJsonToArr($web['cont']);
if($web && $web['building'])$web['_building']=explode(',',$web['building']);
if($web && $web['addressVal'])$web['_addressVal']=explode(',',$web['addressVal']);
$tpl->assign('web',$web);
/*header********************************/
$header=$api->sel(DbPrefix.'menu','where pid=0 and chk=1 order by rank,id','id,pid,name,url');
foreach($header as $k=>$v){
    $name=explode('|',$v['name']);
    $header[$k]['_name']=$name;
    $nurl=explode('.',$v['url']);
    if(count($nurl)==2 || count($nurl)==1){
    }else{
	   $header[$k]['_target']=true;
    }
    $header[$k]['url']=$api->strGetUrl($v['url']);
    $zi=$api->sel(DbPrefix.'menu','where pid='.$v['id'].' and chk=1 order by rank,id','id,pid,name,url,type');
    foreach($zi as $kk=>$vv){
	   $zi[$kk]['url']=$api->strGetUrl($v['url'],$vv['id']);
    }
    $header[$k]['zi']=$zi;
}
$tpl->assign('header',$header);
/*footer********************************/
$footer=$api->sel(DbPrefix.'menu','where pid=0 and dchk=1 order by rank,id','id,pid,name,url');
foreach($footer as $k=>$v){
    $name=explode('|',$v['name']);
    $footer[$k]['_name']=$name;
    $nurl=explode('.',$v['url']);
    if(count($nurl)==2 || count($nurl)==1){
    }else{
	   $footer[$k]['_target']=true;
    }
    $footer[$k]['url']=$api->strGetUrl($v['url']);
}
$tpl->assign('footer',$footer);
/**links********************/
$link=$api->sel(DbPrefix.'image','where pid=\'link\' and chk=1 order by rank desc,id desc');
$tpl->assign('link',$link);
/**当前链接*********************/
$filename=$_SERVER['PHP_SELF'];
$filename=explode('/',$filename);
$filename=end($filename);
$tpl->assign('fn',$filename);
$tpl->assign('filename',$api->strGetUrl($filename));