<?php
require('publicClass.class.php');
class data extends publicClass{
    public $err=array('error'=>0,'html'=>'保存成功');
    public $obj;
    public $dbname='image';//表名
    public $zarr=array('name','pid','url','img','chk','rank','cont','aid','uid');
    public $tit='【图片管理】';
    function __construct($obj){
        /**检查加密数据**/
        $this->obj=$obj;
        $this->data=$_POST;
        if($this->data['db']){
		  $this->dbname=DbPrefix.$this->data['db'];
		  $this->zarr=array('id','name','chk');
        }else{
		  $this->dbname=DbPrefix.$this->dbname;
        }
    }
    private function getWhere($sdata){
	   $where='where id>0';
	   if($this->data['name']){
		  $where.=' and instr(name,\''.$this->data['name'].'\')';
	   }
	   if($this->data['pid'])$where.=' and pid=\''.$this->data['pid'].'\'';
	   if($sdata['id'])$where.=' and id='.$sdata['id'];
	   return $where;
    }
    public function sure($insert=true){
	   $user=$this->obj->strGetSession('user');$oldUrl=false;
	   if($this->data['id']){
		  $arr=$this->obj->strJsonToArr($this->obj->dedes3($this->data['id']));
		  if($arr && is_numeric($arr['id'])){//修改信息
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
		  $data['aid']=$user['id'];$data['stime']=time();
		  $res=$this->obj->insert($this->dbname,$data);
		  if($res){
			 $title=$data['name'];
			 $log=array('way'=>'添加'.$this->tit,'title'=>$title,'cont'=>$this->obj->sql,'remark'=>'');
			 $this->obj->logSql($log);
		  }
	   }
	   if(!$res && $this->err['error']==0){
		  $this->err=array('error'=>1,'html'=>'保存失败，请重新提交'.$this->obj->sql);
	   }
	   echo $this->obj->outResponse($this->err,$this->err['error']?0:1);
    }
    //获取数据
    public function getData($sdata=false){
	   if(!$sdata){
		  $this->data=$_GET;
	   }
	   $where=$this->getWhere($sdata);
	   $data=$this->obj->sel($this->dbname,$where,'count(*)',true);
	   $max=$data?$data[0]:0;
	   include_once(DIR.'/class/pageClass.class.php');
	   $page=new pageClass($max,$this->data['page']?$this->data['page']:1,$this->data['psize']?$this->data['psize']:20);
	   $data=$this->obj->sel($this->dbname,$where.' order by rank desc,id desc',$this->getNeed());
	   foreach($data as $k=>$v){
		  $data[$k]=$this->obj->removeNumKey($v);
	   }
	   $data=$this->obj->getRoleMenu($data,'menu');
	   return array('max'=>$max,'page'=>$page->out(),'data'=>$data);
    }
    //获取带栏目结构数据
    public function getDataMenu(){
	   $arr=array('id'=>'image','name'=>'其他管理','data'=>array());
	   $arr['data'][]=array('name'=>'首页Banner','pid'=>$arr['id'],'id'=>'banner','size'=>'【1920*580】','url'=>'?form='.$arr['id'].'&action=banner');
	   $arr['data'][]=array('name'=>'首页[关于安泰]','pid'=>$arr['id'],'id'=>'about','size'=>'【256*183px】','url'=>'?form='.$arr['id'].'&action=about');
	   $arr['data'][]=array('name'=>'首页[友情连接]','pid'=>$arr['id'],'id'=>'link','size'=>'','url'=>'?form='.$arr['id'].'&action=link');
	   //$arr['data'][]=array('name'=>'留言管理','pid'=>$arr['id'],'id'=>'mes','size'=>'','url'=>'?form='.$arr['id'].'&action=mes');
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
}
$api=new data($api);