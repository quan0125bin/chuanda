<?php
require('class/dataClass.class.php');
class mes extends dataClass{
    public $err=array('error'=>1,'html'=>'未知错误');
    public $data=array();
    private $dbname='vip_mes';
    private $vip=array();
    function __construct(){
        /**检查加密数据**/
        $this->dbname=DbPrefix.$this->dbname;
        $this->data=$this->setData();
		$this->vip=$this->strGetSession('vip');
    }
    //删除数据
    public function delDataMes(){
	 if(!is_numeric($this->data['id']))return false;
	 $where='where vid='.$this->vip['vid'].' and id='.$this->data['id'];
	 $data=$this->sel($this->dbname,$where,'id',true);
	 if($data){
	   $res=$this->del($this->dbname,$where);
	   if($res){
		  $this->err=array('error'=>0,'html'=>'删除成功');
	   }
	 }else{
	   $this->err['html']='数据有误';
	 }
    }
    //获取列表
    public function listMes(){
		include_once('class/pagesClass.class.php');
		$where='where vid='.$this->vip['vid'].' and hchk='.($this->vip['hchk']?1:0);
		if($this->data['max'])$where.=' and chk=0';
		$order=' order by chk,id desc ';
		$data=$this->sel($this->dbname,$where,'count(*)',true);
		$max=$data?$data[0]:0;
		if($this->data['max']){
		  $this->err=array('error'=>0,'max'=>$max);
		}else{
		    $page=new pagesClass($max,$_POST['page']?$_POST['page']:1);
		    $data=$this->sel($this->dbname,$where.$order.$page->limit,'id,pid,vid,sid,way,stime,chk');
		    $arr=array();$pid=array();$hid=array();$vid=array();$vdata=array();$hdata=array();$pdata=array();$id=array();$hdata=array();
		    foreach($data as $v){
			 //sc收藏；yy预约；yyqx预约取消；dk带看楼盘；pj评价
			 if(in_array($v['way'],array('sc','yy','yyqx','yyqr','dk','dpj','kfover'))){
				$pid[]=$v['pid'];
			 }
			 $id[]=$v['id'];
			 if(in_array($v['way'],array('dpj','dk'))){
				$hid[]=$v['sid'];
			 }else{
				$vid[]=$v['sid'];
			 }
		    }
		    $this->update($this->dbname,array('chk'=>1),'where id in('.implode(',',$id).')');
		    if($vid)$vdata=$this->sel(DbPrefix.'vip_basic','where vid in('.implode(',',array_unique($vid)).')','vid,uname,name,phone');
		    if($hid)$hdata=$this->sel(DbPrefix.'viphouse','where vid in('.implode(',',array_unique($hid)).')','vid,uname,name,phone');
		    if($pid)$pdata=$this->sel(DbPrefix.'building','where id in('.implode(',',array_unique($pid)).')','id,pid,name');
		    $pdata=$this->strTitleSub($pdata,0,0,'house.html');
		    foreach($data as $k=>$v){
			    foreach($pdata as $vv){
				    if($vv['id']==$v['pid']){
					   $data[$k]['pdata']=$this->removeNumKey($vv);
				    }
			    }
			    if(in_array($v['way'],array('dpj','dk'))){
				   foreach($vdata as $vv){
					   if($vv['vid']==$v['vid'])$data[$k]['vdata']=$this->removeNumKey($vv);
				   }
			    }else{
				   foreach($hdata as $vv){
					   if($vv['vid']==$v['vid'])$data[$k]['vdata']=$this->removeNumKey($vv);
				   }
			    }
			    $arr[]=$this->removeNumKey($data[$k]);
		    }
		    $this->err=array('error'=>0,'max'=>$max,'data'=>$arr);
		}
    }
    public function delMes(){
	   $hchk=$this->vip['hchk']?1:0;
	   $res=$this->del($this->dbname,'where vid='.$this->vip['vid'].' and hchk='.$hchk);
	   if(!$res){$this->err['html']='清除失败，请重新清除';}
	 $this->err=array('error'=>0,'html'=>'清楚成功');
    }
}