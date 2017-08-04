<?php
class data{
    public $err=array('error'=>0,'html'=>'操作成功');
    public $obj;
    public $dbname='log';//表名
    private $zarr=array('aid','title','way','cont','remark','client');
    function __construct($obj){
        /**检查加密数据**/
        $this->obj=$obj;
        $this->dbname=DbPrefix.$this->dbname;
        $this->data=$_GET;
    }
    private function getNeed(){
	   return 'id,time,'.implode(',',$this->zarr);
    }
    private function getWhere($sdata){
	   $where='where id>0';
	   if($this->data['name']){
		  $where.=' and (instr(title,\''.$this->data['name'].'\') or instr(way,\''.$this->data['name'].'\'))';
	   }
	   if($sdata['id']){
		  $where.=' and id='.$sdata['id'];
	   }
	   return $where;
    }
    public function getData(){
	   $where=$this->getWhere();
	   $data=$this->obj->sel($this->dbname,$where,'count(*)',true);
	   $max=$data?$data[0]:0;
	   require(DIR.'/class/pageClass.class.php');
	   $page=new pageClass($max,$this->data['page']?$this->data['page']:1,$this->data['psize']?$this->data['psize']:20);
	   $data=$this->obj->sel($this->dbname,$where.' order by id desc'.$page->limit,$this->getNeed());
	   if($this->data['name']){
		  foreach($data as $k=>$v){
			 $data[$k]['way']=str_replace($this->data['name'],'<span class="cRed">'.$this->data['name'].'</span>',$v['way']);
			 $data[$k]['title']=str_replace($this->data['name'],'<span class="cRed">'.$this->data['name'].'</span>',$v['title']);
		  }
	   }
	   return array('max'=>$max,'page'=>$page->out(),'data'=>$data);
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