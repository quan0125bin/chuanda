<?php
require('publicClass.class.php');
class data extends publicClass{
    public $err=array('error'=>0,'html'=>'保存成功');
    public $obj;
    public $dbname='filter';//表名
    public $zarr=array('name','pid','type','chk','rank','aid','uid');
    public $tit='【分类管理】';
    function __construct($obj){
        /**检查加密数据**/
        $this->obj=$obj;
        $this->dbname=DbPrefix.$this->dbname;
        $this->data=$_POST;
    }
    private function getWhere($sdata){
	   $where='where id>0';
	   if($this->data['name']){
		  $where.=' and instr(name,\''.$this->data['name'].'\')';
	   }
	   if($sdata['id'])$where.=' and id='.$sdata['id'];
	   return $where;
    }
    public function sure($insert=true){
	   $user=$this->obj->strGetSession('user');$oldUrl=false;
	   if($this->data['id']){
		  if(is_numeric($this->data['id'])){
			 $arr=array('id'=>$this->data['id']);
		  }else{
			 $arr=$this->obj->strJsonToArr($this->obj->dedes3($this->data['id']));
		  }
		  if($arr && is_numeric($arr['id'])){//修改信息
			 $where='where id='.$arr['id'];
			 $odata=$this->obj->sel($this->dbname,$where,$this->getNeed(),true);
			 if($odata){
				$insert=false;
				$data=$this->checkData();
				$data['uid']=$user['id'];$oldUrl=$odata['url'];
				$res=$this->obj->update($this->dbname,$data,$where);
				if($res){
				    $this->err['id']=$odata['id'];
				    $title=$odata['name'];
				    $log=array('way'=>'更新'.$this->tit,'title'=>$title,'cont'=>$this->obj->sql,'remark'=>$this->obj->strArrToJson($odata));
				    $this->obj->logSql($log);
				}
			 }
		  }
	   }
	   if($insert){
		  $data=$this->checkData();
		  foreach($data as $k=>$v){
			 if(!$v)unset($data[$k]);
		  }
		  $data['aid']=$user['id'];$data['stime']=time();
		  $res=$this->obj->insert($this->dbname,$data);
		  if($res){
			 $title=$data['name'];$this->err['id']=$this->obj->id;
			 $log=array('way'=>'添加'.$this->tit,'title'=>$title,'cont'=>$this->obj->sql,'remark'=>'');
			 $this->obj->logSql($log);
		  }
	   }
	   if(!$res && $this->err['error']==0){
		  $this->err=array('error'=>1,'html'=>'保存失败，请重新提交');
	   }
	   echo $this->obj->outResponse($this->err,$this->err['error']?0:1);
    }
    //获取数据
    public function getData($sdata=false){
	   if(!$sdata){
		  $this->data=$_GET;
	   }
	   $where=$this->getWhere($sdata);
	   $data=$this->obj->sel($this->dbname,$where.' order by rank ,id ',$this->getNeed());
	   foreach($data as $k=>$v){
		  $data[$k]=$this->obj->removeNumKey($v);
		  $data[$k]['uway']=$this->obj->endes3($this->obj->strArrToJson(array('id'=>$v['id'],'pid'=>$v['pid'],'way'=>'filter')),true);
	   }
	   $data=$this->obj->getRoleMenu($data,'filter');
	   return array('max'=>$max,'data'=>$data);
    }
    //获取带栏目结构数据
    public function getDataMenu(){
	   $arr=array('id'=>'filter','name'=>'分类筛选管理','data'=>array());
	   $arr['data'][]=array('name'=>'筛选分类','pid'=>$arr['id'],'id'=>'choose','url'=>'?form='.$arr['id'].'&action=choose');
	   $data=array($arr);
	   return array('data'=>$data);
    }
    public function getMenu($pid,$id){
	   $data=$this->getDataMenu();$arr=array();
	   foreach($data['data'] as $v){
		  if($v['id']==$pid){
			 foreach($v['data'] as $vv){
				if($vv['id']==$id)$arr=$vv;
			 }
		  }
	   }
	   return $arr;
    }
    //整理栏目结构
    public function getDataList($data=array(),$pid=0,$remove=false){
	   $narr=array();
	   if(!$data){
		  $data=$this->getData();$data=$data['data'];
		  $narr=array('data'=>array());
	   }
	   $arr=array();
	   $arr=$this->obj->strRecursion($data);//递归
	   if($narr){
		  $narr['data']=$arr?$arr:'';
		  return $narr;
	   }else{
		  return $arr?$arr:'';
	   }
    }
}
$api=new data($api);