<?php
define("DIR",$_SERVER['DOCUMENT_ROOT']);
require(DIR.'/config/index.php');
$sign=$api->strJsonToArr($api->dedes3($_POST['sig']));
$signRand=$api->strGetSession('signRand');
if(is_array($sign) && $sign['signRand']==$signRand){
    //验证签名是否正确，随机参数是否一直，是否在一小时内
    if($sign['time']<time()-3600*1 || $sign['time']>time()){
	   header('HTTP/1.1 818 Time Out');//返回错误
	   echo $api->outResponse('页面已过期');exit;
    }
}else{
    header('HTTP/1.1 818  Not Sign');//返回错误
    echo $api->outResponse('签名有误');exit;
}

require(DIR.'/class/fileClass.class.php');
$res=$api->fileHandle($_FILES,'/upload/',true);
if($res){
    if($api->obj->err['error']>0){
	   echo $api->obj->outResponse(array('data'=>''),false,true);
    }else{
	   echo $api->obj->outResponse(array('data'=>$res[0]),true,true);
    }
}else{
    echo $api->obj->outResponse($api->err,false,true);
}
?>