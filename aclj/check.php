<?php
/******************验证请求源******************************/
if($_SERVER['HTTP_AC_FORM']!='ac' || !$_SERVER['HTTP_AC_SIGN']){
    header('HTTP/1.1 810  Not Implemented');//返回错误
    echo $api->outResponse('请求源有误');exit;
}
$sign=$api->strJsonToArr($api->dedes3($_SERVER['HTTP_AC_SIGN']));
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















