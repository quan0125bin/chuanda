<?php
/*
config 公共配置文件-
sqlClass 数据库链接SQL语句类-
strClass 字符串处理类-
logClass 错误日志处理类-
emailClass 邮件类-
urlClass URL连接处理类
*/
error_reporting(0);
$dir='';
if(DIR && DIR!='DIR')$dir=DIR.'/';
require($dir.'class/logClass.class.php');//错误日志处理
/*************************
数据请求调用接口*/
if($dir){
    require($dir.'class/dataClass.class.php');//错误日志处理
    $api=new dataClass();
}else{
    require('data/api.class.php');//调用公共类处理
    $api=new api();
}
/**************************/