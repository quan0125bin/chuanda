<?php
require('class/fileClass.class.php');
class file extends fileClass{
    public $err=array('error'=>0,'html'=>'操作成功');
    function __construct(){
        parent::__construct();
        /**检查加密数据**/
        $this->data=$this->getData($_POST);
    }
    public function startfile(){
	   print_r($this->data);
    }
}