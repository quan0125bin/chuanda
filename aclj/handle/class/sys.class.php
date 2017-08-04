<?php
class data{
    public $err=array('error'=>0,'html'=>'操作成功');
    public $obj;
    function __construct($obj){
        /**检查加密数据**/
        $this->obj=$obj;
    }
    public function getData(){
	   global $basicMenu;
	   $data=$basicMenu;
	   return array('data'=>$data);
    }
}
$api=new data($api);