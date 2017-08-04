<?php
require('publicClass.class.php');
class data extends publicClass{
    public $err=array('error'=>0,'html'=>'保存成功');
    public $obj;
    public $dbname='menu';//表名
    public $zarr=array('name','nname','pid','url','img','image','type','chk','dchk','rank','cont','seoTitle','seoKeyWord','seoDes');
    public $tit='【栏目】';
    private $sonType=true;
    private $son=0;
    function __construct($obj){
        /**检查加密数据**/
        $this->obj=$obj;
        $this->dbname=DbPrefix.$this->dbname;
        $this->data=$_POST;
    }
    private function checkMenuUrl($url,$oldUrl){
	   $oldUrlArr=explode('.',$oldUrl);
	   $urlArr=explode('.',$url);
	   if(count($oldUrlArr)==2 && $oldUrlArr[1]=='php'){
		  unlink(DIR.'/home/'.$oldUrl);
	   }
	   if(count($urlArr)==2 && $urlArr[1]=='php'){
		  $fstr=file_get_contents(DIR.'/home/demo.php');
		  $file=fopen(DIR.'/home/'.$url,'w');
		  fwrite($file,$fstr);fclose($file);
	   }
    }
    private function getWhere($sdata){
	   $where='where id>0';
	   if($this->data['name']){
		  $where.=' and (instr(name,\''.$this->data['name'].'\') or instr(uname,\''.$this->data['name'].'\'))';
	   }
	   if($sdata['id']){
		  $where.=' and id='.$sdata['id'];
	   }
	   return $where;
    }
    public function sure($insert=true){
	   $user=$this->obj->strGetSession('user');$oldUrl=false;
	   if($this->data['id']){
		  $arr=$this->obj->strJsonToArr($this->obj->dedes3($this->data['id']));
		  if($arr && is_numeric($arr['id'])){//修改用户信息
			 $where='where id='.$arr['id'];
			 $odata=$this->obj->sel($this->dbname,$where,$this->getNeed(),true);
			 if($odata){
				$insert=false;
				$data=$this->checkData();
				$data['uid']=$user['id'];$oldUrl=$odata['url'];
				$res=$this->obj->update($this->dbname,$data,$where);
				if($res){
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
		  $data['aid']=$user['id'];
		  $res=$this->obj->insert($this->dbname,$data);
		  if($res){
			 $title=$data['name'];
			 $log=array('way'=>'添加'.$this->tit,'title'=>$title,'cont'=>$this->obj->sql,'remark'=>'');
			 $this->obj->logSql($log);
		  }
	   }
	   if(!$res && $this->err['error']==0){
		  $this->err=array('error'=>1,'html'=>'保存失败，请重新提交');
	   }
	   if($res && (!$data['pid'] && $data['url'])){
		  $this->checkMenuUrl($data['url'],$oldUrl);
	   }
	   echo $this->obj->outResponse($this->err,$this->err['error']?0:1);
    }
    //获取栏目列表
    public function getData($sdata=false){
	   if(!$sdata){
		  $this->data=$_GET;
	   }
	   $where=$this->getWhere($sdata);
	   $data=$this->obj->sel($this->dbname,$where.' order by rank,id',$this->getNeed());
	   foreach($data as $k=>$v){
		  $data[$k]=$this->obj->removeNumKey($v);
	   }
	   $data=$this->obj->getRoleMenu($data,'menu');
	   return array('max'=>$max,'data'=>$data);
    }
    //整理栏目结构
    public function getMenu($data,$pid=0,$remove=false,$son=MenuSons){
	   $arr=array();
	   if(!$pid)$pid=$this->obj->endes3($this->obj->strArrToJson(array('id'=>$pid,'way'=>'menu')),true);
	   foreach($data as $k=>$v){
		  $oarr=$v;
		  $oarr['pid']=$this->obj->endes3($this->obj->strArrToJson(array('id'=>$v['pid'],'way'=>'menu')),true);
		  $oarr['id']=$this->obj->endes3($this->obj->strArrToJson(array('id'=>$v['id'],'way'=>'menu')),true);
		  if($oarr['pid']==$pid){
			 unset($data[$k]);
			 if($son>0)$v['data']=$this->getMenu($data,$oarr['id'],$remove,$son-1);
			 /***************状态更改****************************/
			 $v['chk_t']=$this->obj->endes3($this->obj->strArrToJson(array('id'=>$v['id'],'state'=>'chk','chk'=>$v['chk'],'way'=>'menu')),true);
			 $v['dchk_t']=$this->obj->endes3($this->obj->strArrToJson(array('id'=>$v['id'],'state'=>'dchk','dchk'=>$v['dchk'],'way'=>'menu')),true);
			 /***************子栏目添加****************************/
			 if($son>0)$v['away']=$this->obj->endes3($this->obj->strArrToJson(array('pid'=>$v['id'],'way'=>'menu')),true);
			 $v['uway']=$this->obj->endes3($this->obj->strArrToJson(array('id'=>$v['id'],'pid'=>$v['pid'],'way'=>'menu')),true);
			 if(!$remove)unset($v['id'],$v['pid']);
			 $arr[]=$v;
		  }
	   }
	   return $arr?$arr:'';
    }
    //获取带栏目结构数据
    public function getDataMenu(){
	   $data=$this->getData();
	   $data=$this->getMenu($data['data'],0,true);
	   return array('data'=>$data);
    }
    //获取对应管理关门列表
    public function getMenuList($data){
	   $data=$this->getMenu($data,0,true,MenuSons-1);
	   //print_R($data);
	   $data=$this->menuList($data);
	   return $data;
    }
    private function menuList($data,$oarr=array()){
	   foreach($data as $k=>$v){
		  if($oarr){
			 $v['name']=$oarr['name'].' 》'.$v['name'];
		  }
		  $barr=$v;
		  if($v['data']){
			 $narr=$this->menuList($v['data'],$v);unset($barr['data']);
		  }
		  $arr[]=$barr;
		  if($narr){
			 foreach($narr as $k=>$v){
				$arr[]=$v;
			 }
		  }
	   }
	   return $arr;
    }
    public function dels(){
	   $where='where id in('.$this->data['id'].')';
	   $odata=$this->obj->sel($this->dbname,$where,$this->getNeed());
	   if($odata){
		  $res=$this->obj->del($this->dbname,$where);
		  if($res){
			 $log=array('way'=>'批量删除'.$this->tit,'title'=>'','cont'=>$this->obj->sql,'remark'=>$this->obj->strArrToJson($odata));
			 $this->obj->logSql($log);
			 $this->err['html']='删除成功';
		  }else{
			 $this->err=array('error'=>1,'html'=>'删除失败，请重新添加');
		  }
	   }else{
		  $this->err=array('error'=>1,'html'=>'用户不存在');
	   }
	   echo $this->obj->outResponse($this->err,$this->err['error']?0:1);
    }
    public function del(){
	   $where='where id='.$this->data['id'];
	   $odata=$this->obj->sel($this->dbname,$where,$this->getNeed(),true);
	   if($odata){
		  $res=$this->obj->del($this->dbname,$where);
		  if($res){
			 $title=$odata['uname'].'['.$odata['name'].']';
			 $log=array('way'=>'删除'.$this->tit,'title'=>$title,'cont'=>$this->obj->sql,'remark'=>$this->obj->strArrToJson($odata));
			 $this->obj->logSql($log);
			 $this->err['html']='删除成功';
		  }else{
			 $this->err=array('error'=>1,'html'=>'删除失败，请重新添加');
		  }
	   }else{
		  $this->err=array('error'=>1,'html'=>'用户不存在');
	   }
	   echo $this->obj->outResponse($this->err,$this->err['error']?0:1);
    }
    public function out(){
	   $api->strOutSession(array('user'));
    }
}
$api=new data($api);