<?php
require('publicClass.class.php');
class data extends publicClass{
    public $err=array('error'=>0,'html'=>'操作成功');
    public $obj;
    public $dbname='info';//表名
    public $zarr=array('pid','aid','uid','bid','name','come','chk','hchk','mchk','cchk','rchk','url','lname','rank','stime','img','image','video','cont','ccont','seoTitle','seoKeyWord','seoDes');
    public $tit='【内容管理】';
    function __construct($obj){
        /**检查加密数据**/
        $this->obj=$obj;
        $this->dbname=DbPrefix.$this->dbname;
        $this->data=$_POST;
	   if($this->data['db']){
		  $this->checkDbData();
	   }
    }
    private function getWhere($sdata){
	   $where='where id>0';
	   if($this->data['name']){
		  $where.=' and (instr(name,\''.$this->data['name'].'\') or instr(lname,\''.$this->data['name'].'\'))';
	   }
	   if($this->data['pid'])$where.=' and pid='.$this->data['pid'];
	   if($sdata['id'])$where.=' and id='.$sdata['id'];
	   return $where;
    }
    private function checkDbData($data=array()){
	   if($this->data['db']=='pro' || $data['db']=='pro'){
		  $this->dbname=DbPrefix.'pro';
		  $this->zarr=array('pid','aid','uid','bid','name','chk','hchk','mchk','cchk','rchk','url','lname','rank','stime','img','image','cont','ccont','seoTitle','seoKeyWord','seoDes');
		  $this->zarr[]='email';
		  $this->zarr[]='tel';
		  $this->zarr[]='num';
		  $this->zarr[]='address';
	   }
    }
    public function sure(){
	   $odata=false;
	   if($this->data['id']){
		  if(!is_numeric($this->data['id'])){
			 $arr=$this->obj->strJsonToArr($this->obj->dedes3($this->data['id'],true));
			 $this->data['id']=$arr?$arr['id']:'';
		  }
		  $id=$this->data['id'];
		  $odata=$this->obj->sel($this->dbname,'where id='.$id,'id',true);
	   }
	   $data=$this->checkData();
	   $user=$this->obj->strGetSession('user');
	   if($odata){
		  $data['uid']=$user['id'];
		  if($data['stime'])$data['stime']=strtotime($data['stime']);
		  $res=$this->obj->update($this->dbname,$data,'where id='.$odata['id']);
		  if($res){
			 $title=$odata['name'];
			 $log=array('way'=>'内容更新'.$this->tit,'title'=>$title,'cont'=>$this->obj->sql,'remark'=>$this->obj->strArrToJson($odata));
			 $this->obj->logSql($log);
			 $this->err['rest']=$arr[$this->data['state']];
		  }else{
			 $this->err=array('error'=>1,'html'=>'更新失败，请检查资料是否填写完整');
		  }
	   }else{
		  $data['aid']=$user['id'];if(!$data['stime'])$data['stime']=time();
		  $res=$this->obj->insert($this->dbname,$data);
		  if($res){
			 $title=$odata['name'];
			 $log=array('way'=>'内容添加'.$this->tit,'title'=>$title,'cont'=>$this->obj->sql,'remark'=>$this->obj->strArrToJson($odata));
			 $this->obj->logSql($log);
			 $this->err['rest']=$arr[$this->data['state']];
		  }else{
			 $this->err=array('error'=>1,'html'=>'保存失败，请检查资料是否填写完整');
		  }
	   }
	   echo $this->obj->outResponse($this->err,$this->err['error']?0:1);
    }
    public function getData($sdata){
	   if(!$sdata){
		  $this->data=$_GET;
	   }
	   $this->checkDbData($sdata);
	   $where=$this->getWhere($sdata);
	   $data=$this->obj->sel($this->dbname,$where,'count(*)',true);
	   $max=$data?$data[0]:0;
	   include_once(DIR.'/class/pageClass.class.php');
	   $page=new pageClass($max,$this->data['page']?$this->data['page']:1,$this->data['psize']?$this->data['psize']:20);
	   $data=$this->obj->sel($this->dbname,$where.' order by rank desc,id desc '.$page->limit,$this->getNeed());
	   
	   foreach($data as $k=>$v){
		  if($this->data['name']){
			 $data[$k]['uname']=str_replace($this->data['name'],'<span class="cRed">'.$this->data['name'].'</span>',$v['uname']);
			 $data[$k]['name']=str_replace($this->data['name'],'<span class="cRed">'.$this->data['name'].'</span>',$v['name']);
		  }
		  $data[$k]['stime']=date('Y-m-d H:i:s',$v['stime']);
		  if($v['role'])$data[$k]['role']=$this->obj->strHandleRestore($v['role']);
	   }
	   return array('max'=>$max,'page'=>$page->out(),'data'=>$data);
    }
}
$api=new data($api);