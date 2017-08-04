<?php
require('strClass.class.php');
//错误自定义类
class logClass{
     public static $error;
     public static $err=array();
     private static $hr="\n";
     private static $strObj;
     private static $noErr=array(2,8);//普通警告
     function __construct(){
     }
     public static function LOG(){
        self::$strObj=new strClass();
        set_exception_handler(array('logClass',"myErrorHandler"));  
        set_error_handler(array('logClass',"myErrorHandler"));  
        register_shutdown_function(array('logClass',"handleFatalError"));  
    }
    //处理平常错误
    public static function myErrorHandler($errno='', $errstr='', $errfile='', $errline='') {
          self::$err=array('type'=>$errno,'message'=>$errstr,'file'=>$errfile,'line'=>$errline);
          if(in_array($errno,self::$noErr)){//未定义变量
          }else{
               if($errno)self::logError();
          }
     }
     //处理致命错误
     public static function handleFatalError() {
          self::$err = error_get_last();
          if(self::$err['type'])self::logError('',true);
     }
     //错误信息$str（错误描述）$stop（是否终止代码）
     public static function logError($str='',$stop=false){
        $err=self::$err;
        if(!$err)return;
        if(in_array($err['type'],self::$noErr))return;
        $html='程序运行出错：'.$str.self::$hr;
        if($_SERVER['REQUEST_URI'])$html.='请求地址：'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].self::$hr;
        $html.='错误类型：'.$err['type'].self::$hr;
        $html.='错误代码：'.$err['message'].self::$hr;
        $html.='错误地址：'.$err['file'].'(第'.$err['line'].'行)'.self::$hr;
        if($stop){
            $html='#red#【程序终止】#red#'.$html;
            if(Log)self::logExport($html);
            if(LogFile){self::logInput($html,'file');}
            if(LogEmail){self::logInput($html,'email');}
			if(LogUrlGo && !Log){
				header('location:'.LogUrlGo);
			}
            exit;
        }
        if(Log)self::logExport($html);
        if(LogFile){self::logInput($html,'file');}
        if(LogEmail){self::logInput($html,'email');}
     }
     //页面输出处理
     public static function logExport($str){
        echo self::$strObj->strHandleHtml($str);
     }
     //日志记录$str（记录数据）$way（记录形式）$to（指定文件名、发送邮件地址）
     public static function logInput($str,$way='',$to=false){
        $str=self::$strObj->strCheckCode($str);
        $str=date('Y-m-d H:i:s')."\n".$str;
        switch($way){
            case 'file'://文件记录
               if($to){
                    $file=$to;
               }else{
                    $file=$_SERVER['DOCUMENT_ROOT'].'/log/'.date('Ymd').'/';
                    if(!is_dir($file)){
                        $res=mkdir(iconv("UTF-8", "GBK", $file));
                        if(!$res){
                            self::$error='日志目录创建失败';
                        }
                    }
                    $file.=date('H').'.log';
               }
                $html='####'.$str;
                $file=fopen($file,'a');
                fputs($file,$html.self::$hr);
                fclose($file);
                break;
            case 'email'://邮件记录
                include_once('emailClass.class.php');//
                $title='['.Title.']系统错误';$html=self::$strObj->strHandleHtml($str);
                $emailClass->send(LogToEmail,$title,$html);
                break;
            default://未知错误
                echo $way.":".$str;
                break;
        }
     }
     public static function logFile($html,$file=false){
          $file=$file?$file:($_SERVER['DOCUMENT_ROOT'].'/log/'.date('Ymd').'.log');
           $file=fopen($file,'a');
           fputs($file,$html.self::$hr);
           fclose($file);
     }
}
//logClass::logInput($html,'file');
logClass::LOG();//调用错误自定义函数