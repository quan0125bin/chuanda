<?php
//动态处理类
class api{
    public $err=array('error'=>0,'html'=>'操作成功——api');
    public $obj=false;
    public $outputSig=true;//明文输出
    public $data=array();
    function __construct(){
        $res=$this->checkAction($_GET['action']);
        if($res && $this->obj){
		 $way=$this->obj->data['way'];//拼接方法名
		  if(!$way && $_GET['way'])$way=$_GET['way'];
		  if($way){
			 $way.=ucfirst($_GET['action']);
			 if(method_exists($this->obj,$way)){
				$data=$this->obj->$way();
				if($data && is_array($data)){
				    $this->err['data']=$data;
				}elseif($data){
				    $this->err=$this->obj->err;
				}else{
				    $this->err=$this->obj->err;
				}
			 }else{
			    //if(LogUrl)header('location:'.LogUrl);
				$this->err=array('error'=>1,'html'=>'参数错误：err[402]');//方法不存在
			 }
		  }else{
			 $this->err=array('error'=>1,'html'=>'参数请求错误：err[401]');//类不存在
		  }
        }else{
			//if(LogUrl)header('location:'.LogUrl);
            $this->err=array('error'=>1,'html'=>'参数请求错误：err[400]');//缺少请求参数
        }
        if($_GET['action']=='img' && !$data){
            $this->outputSig=true;
            $this->err=array('error'=>1,'html'=>'图片不存在');//缺少参数
        }
        $this->output();
    }
    //检查类是否存在
    private function checkAction($action){
        $classFile='data/'.$action.'.class.php';
        if(!file_exists($classFile)){
            require('class/dataClass.class.php');
            $this->obj=new dataClass();
            return false;
        }
        require($classFile);
        $this->obj=new $action();
        return true;
    }
    //输出结果
    public function output(){
        if($this->outputSig){
            $result=$this->obj->strArrToJson($this->err);
        }else{
            $result=$this->obj->inputData($this->err);
        }
        echo $result;
    }
}