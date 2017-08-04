<?php
class data{
    public $err=array('error'=>0,'html'=>'操作成功');
    public $obj;
    public $dbname='basic';//表名
    private $zarr=array('name','title','email','cont','seoTitle','seoKeyWord','seoDes','building','tel','fax','address','addressVal');
    function __construct($obj){
        /**检查加密数据**/
        $this->obj=$obj;
        $this->dbname=DbPrefix.$this->dbname;
        $this->data=$_POST;
    }
    public function sure(){
	   $odata=$this->obj->sel($this->dbname,'','*',true);
	   $data=$this->checkData();
	   if($odata){
		  $res=$this->obj->update($this->dbname,$data,'where name=\''.$odata['name'].'\'');
		  if(!$res){
			 $this->err=array('error'=>1,'html'=>'保存失败，请检查资料是否填写完整');
		  }
	   }else{
		  $res=$this->obj->insert($this->dbname,$data);
		  if(!$res){
			 $this->err=array('error'=>1,'html'=>'保存失败，请检查资料是否填写完整');
		  }
	   }
	   echo $this->obj->outResponse($this->err,$this->err['error']?0:1);
    }
    public function getData(){
	   $data=$this->obj->sel($this->dbname,'','*',true);
	   foreach($data as $k=>$v){
		  $data[$k]=$this->obj->strHandleRestore($v);
	   }
	   if($data && $data['cont'])$data['cont']=$this->obj->strJsonToArr($data['cont']);
	   return $data;
    }
    private function checkData(){
	   $data=array();
	   foreach($this->data as $k=>$v){
		  if(in_array($k,$this->zarr)){
			 $data[$k]=$v;
		  }
	   }
	   return $data;
    }
}
$api=new data($api);