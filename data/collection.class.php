<?php
require('class/dataClass.class.php');
class collection extends dataClass{
    public $err=array('error'=>1,'html'=>'未知错误');
    public $data=array();
    private $dbname='collection';
    private $vip=array();
    function __construct(){
        /**检查加密数据**/
        $this->dbname=DbPrefix.$this->dbname;
        $this->data=$this->setData();
		$this->vip=$this->strGetSession('vip');
    }
    public function checkCollection(){
		if(!is_numeric($this->data['id'])){$this->err['html']='参数错误';return false;}
		if(!$this->vip){$this->err=array('error'=>0,'v'=>3);return false;}
		$hchk=$this->vip['hchk']?1:0;
		$data=$this->sel($this->dbname,'where pid='.$this->data['id'].' and vid='.$this->vip['vid'].' and hchk='.$hchk,'vid',true);
		$this->err=array('error'=>0,'v'=>0);
		if($data){$this->err['v']=1;}
    }
    public function sureCollection(){
		if($_COOKIE['collection']>5){$this->err['html']='请勿频繁操作';return false;}
		if(!is_numeric($this->data['id'])){$this->err['html']='参数错误';return false;}
		if(!$this->vip){$this->err['html']='请先登陆';return false;}
		$bdata=$this->sel(DbPrefix.'building','where id='.$this->data['id'],'id,hid',true);
		if(!$bdata){$this->err['html']='参数错误';return false;}
		$hchk=$this->vip['hchk']?1:0;
		$data=$this->sel($this->dbname,'where pid='.$this->data['id'].' and vid='.$this->vip['vid'].' and hchk='.$hchk,'pid,vid',true);
		if($data){
			$res=$this->del($this->dbname,'where pid='.$this->data['id'].' and vid='.$this->vip['vid'].' and hchk='.$hchk);
			if($res)$this->err=array('error'=>0,'v'=>0);
			 $this->customerLogHandle($bdata,true);
		}else{
			$res=$this->insert($this->dbname,array('pid'=>$this->data['id'],'vid'=>$this->vip['id'],'hchk'=>$hchk,'stime'=>time()));
			if($res){
			 $this->err=array('error'=>0,'v'=>1);
			 $this->customerLogHandle($bdata);
			}
		}
		if(!$res){$this->err['html']='收藏失败，请重新收藏';}
		$n=$_COOKIE['collection']?$_COOKIE['collection']+1:1;
		$this->err['n']=$n;
		setcookie('collection',$n,time()+3);
    }
    public function delCollection(){
	   $hchk=$this->vip['hchk']?1:0;
	   $res=$this->del($this->dbname,'where vid='.$this->vip['vid'].' and hchk='.$hchk);
	   if(!$res){$this->err['html']='清除失败，请重新清除';}
	 $this->err=array('error'=>0,'html'=>'清楚成功');
    }
    public function customerLogHandle($bdata,$del=false){
	   if(!$bdata)return false;
	   $hid='';
	   if($bdata['hid']){
		  $hid=str_replace('[','',$bdata['hid']);
		  $hid=str_replace(']','',$hid);
		  $harr=explode(',',$hid);
	   }
	   if(!$this->vip['hchk']){
		  $cclog=$this->sel(DbPrefix.'customer_log','where vid='.$this->vip['id'].' and hid in('.$hid.')');
		  foreach($cclog as $v){
			 foreach($harr as $kk=>$vv){
				if($v['hid']==$vv)unset($harr[$kk]);
			 }
		  }
		  if($harr){
			 foreach($harr as $v){
				$this->insert(DbPrefix.'customer_log',array('vid'=>$this->vip['id'],'hid'=>$v));
			 }
		  }
		  $harr=explode(',',$hid);$arr=array();
		  if($harr){
			 if($del){
				$this->del(DbPrefix.'vip_mes','where sid='.$this->vip['id'].' and vid in('.$hid.')');
			 }else{
				foreach($harr as $v){
				    $arr[]=array('vid'=>$v,'sid'=>$this->vip['id'],'hchk'=>1,'pid'=>$bdata['id'],'chk'=>0,'way'=>'sc','stime'=>time());
				}
				$this->inserts(DbPrefix.'vip_mes',$arr);
			 }
		  }
	   }
    }
}