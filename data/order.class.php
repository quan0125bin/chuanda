<?php
require('class/dataClass.class.php');
class order extends dataClass{
    public $err=array('error'=>1,'html'=>'未知错误');
    public $data=array();
    private $dbname='order';
    private $vip=array();
    function __construct(){
        /**检查加密数据**/
        $this->dbname=DbPrefix.$this->dbname;
        $this->data=$this->setData();
		$this->vip=$this->strGetSession('vip');
    }
    public function addOrder(){
	   if(!is_numeric($this->data['id']) || !is_numeric($this->data['pid'])){$this->err['html']='参数信息有误';return false;}
	   $where='where id='.$this->data['id'].' and hid='.$this->vip['vid'];
	   $data=$this->sel($this->dbname,$where,'id,pid',true);
	   if(!$data){$this->err['html']='预约数据不存在';return false;}
	   $pid=explode(',',$data['pid']);$pid=array_filter($pid);
	   if(in_array($this->data['pid'],$pid)){$this->err['html']='该新房已经添加';return false;}
	   $pid=implode(',',$pid);
	   $arr=array('pid'=>($pid?($pid.','):'').$this->data['pid'].',');
	   $res=$this->update($this->dbname,$arr,$where);
		if($res){
			$this->err=array('error'=>0,'html'=>'添加成功');
		}else{
			$this->err['html']='添加失败，请重新预约'.$arr;
		}
    }
    //预约
    public function bookOrder(){
		if(!$this->data['phone']){$this->err['html']='手机号码不能为空';return false;}
		if(!$this->data['code']){$this->err['html']='验证码不能为空';return false;}
		if(!$this->strCheckPhone($this->data['phone'])){$this->err['html']='手机号码有误';return false;}
		//if(!$this->checkPhoneCode($this->data,'order',true)){$this->err['html']='验证码错误';return false;}
	   if(!$this->vip){
		  $vdata=$this->sel(DbPrefix.'vip_basic','where phone=\''.$this->data['phone'].'\'','*',true);
		  if($vdata){
			 $this->setVip($vdata);
			 $this->vip=$this->strGetSession('vip');
		  }
	   }
	   if(!$this->data['id'])$this->data['id']=0;
		$data=$this->sel($this->dbname,'where instr(pid,\''.$this->data['id'].',\') and phone='.$this->data['phone'].' and chk=0','id',true);
		if($data){$this->err['html']='您已经预约了该房';if($this->data['id']=='0')$this->err['html']='您已经预约';return false;}
		$vid=$this->vip?$this->vip['vid']:0;
		$arr=array('pid'=>$this->data['id'].',','vid'=>$vid,'phone'=>$this->data['phone'],'name'=>$this->data['name'],'sex'=>$this->data['sex'],'chk'=>0,'stime'=>time());
		if($this->data['hid']){
		  $hdata=$this->sel(DbPrefix.'viphouse','where id='.$this->data['hid'],'id',true);
		  if(!$hdata){$this->err['html']='房管参数错误';return false;}
		  $arr['hid']=$this->data['hid'];
		}
		$res=$this->insert($this->dbname,$arr);
		if($res){
			$this->err=array('error'=>0,'html'=>'预约成功');
		}else{
			$this->err['html']='预约失败，请重新预约';
		}
    }
    //取消
    public function cancelOrder(){
	   $where='where vid='.$this->vip['id'].' and id='.$this->data['id'];
	   $data=$this->sel($this->dbname,$where,'id,pid,vid,hid,stime,chk',true);
	   if(!$data){$this->err['html']='数据不存在';return false;}
	   if(!in_array($data['chk'],array(0,2))){$this->err['html']='“'.$this->getChkTxt($data['chk']).'”无法取消';return false;}
	   $res=$this->update($this->dbname,array('chk'=>5),$where);
	   if($res){
		  if($this->vip['hchk']){
			 $pid=explode(',',$data['pid']);$pid=$pid?$pid[0]:0;
			 $arr=array('vid'=>$data['vid'],'sid'=>$this->vip['id'],'hchk'=>0,'pid'=>$pid,'chk'=>0,'way'=>'yyqx','stime'=>time());
			 $res=$this->insert(DbPrefix.'vip_mes',$arr);
			 if(!$res){
			 }
		  }
		  $this->err=array('error'=>0,'html'=>'取消成功');
	   }else{
		  $this->err['html']='取消失败，请重新提交';
	   }
    }
    //
    public function evaluateOrder(){
	   $where='where vid='.$this->vip['id'].' and id='.$this->data['id'];
	   $data=$this->sel($this->dbname,$where,'id,pid,vid,hid,stime,chk',true);
	   if(!$data){$this->err['html']='数据不存在';return false;}
	   if(!in_array($data['chk'],array(2,3,4))){$this->err['html']='“'.$this->getChkTxt($data['chk']).'”无法处理';return false;}
	   $arr=array('chk'=>1,'score'=>$this->data['score'],'cont'=>$this->data['cont']);
	   $res=$this->update($this->dbname,$arr,$where);
	   if($res){
		  if(!$this->vip['hchk']){
			 $pid=explode(',',$data['pid']);$pid=$pid?$pid[0]:0;
			 $arr=array('vid'=>$data['hid'],'sid'=>$this->vip['id'],'hchk'=>0,'pid'=>$pid,'chk'=>0,'way'=>'kfover','stime'=>time());
			 $res=$this->insert(DbPrefix.'vip_mes',$arr);
		  }
		  $this->err=array('error'=>0,'html'=>'操作成功');
	   }else{
		  $this->err['html']='操作失败，请重新提交';
	   }
    }
    public function overOrder(){
	   $where='where hid='.$this->vip['id'].' and id='.$this->data['id'];
	   $data=$this->sel($this->dbname,$where,'id,pid,vid,hid,stime,chk',true);
	   if(!$data){$this->err['html']='数据不存在';return false;}
	   if(!in_array($data['chk'],array(2,3))){$this->err['html']='“'.$this->getChkTxt($data['chk']).'”无法处理';return false;}
	   $res=$this->update($this->dbname,array('chk'=>4),$where);
	   if($res){
		  if($this->vip['hchk']){
			 $pid=explode(',',$data['pid']);$pid=$pid?$pid[0]:0;
			 $arr=array('vid'=>$data['vid'],'sid'=>$this->vip['id'],'hchk'=>0,'pid'=>$pid,'chk'=>0,'way'=>'dpj','stime'=>time());
			 $res=$this->insert(DbPrefix.'vip_mes',$arr);
			 if(!$res){
			 }
		  }
		  $this->err=array('error'=>0,'html'=>'操作成功');
	   }else{
		  $this->err['html']='操作失败，请重新提交';
	   }
    }
    public function sureOrder(){
	   $where='where hid='.$this->vip['id'].' and id='.$this->data['id'];
	   $data=$this->sel($this->dbname,$where,'id,pid,vid,hid,stime,chk',true);
	   if(!$data){$this->err['html']='数据不存在';return false;}
	   if(!in_array($data['chk'],array(0))){$this->err['html']='“'.$this->getChkTxt($data['chk']).'”无法处理';return false;}
	   $res=$this->update($this->dbname,array('chk'=>3,'hid'=>$this->vip['id']),$where);
	   if($res){
		  if($this->vip['hchk']){
			 $pid=explode(',',$data['pid']);$pid=$pid?$pid[0]:0;
			 $arr=array('vid'=>$data['vid'],'sid'=>$this->vip['id'],'hchk'=>0,'pid'=>$pid,'chk'=>0,'way'=>'yyqr','stime'=>time());
			 $res=$this->insert(DbPrefix.'vip_mes',$arr);
			 if(!$res){
			 }
		  }
		  $this->err=array('error'=>0,'html'=>'取消成功');
	   }else{
		  $this->err['html']='取消失败，请重新提交';
	   }
    }
    public function listMessageOrder(){
		include_once('class/pagesClass.class.php');
		$where=$swhere='where vid='.$this->vip['vid'];
		if($this->vip['hchk']){
		  $where=$swhere='where (hid='.$this->vip['vid'].' or hid is null)';
		}
		$where.=' and score>0';
		$order=' order by id desc ';
		$data=$this->sel($this->dbname,$where,'count(*)',true);
		$max=$data?$data[0]:0;
		$page=new pagesClass($max,$_POST['page']?$_POST['page']:1);
		$data=$this->sel($this->dbname,$where.$order.$page->limit,'id,pid,vid,hid,stime,chk,cont,score');
		$arr=array();$pid=array();$vid=array();$hid=array();$vdata=array();$hdata=array();$pdata=array();
		foreach($data as $v){
			$npid=explode(',',$v['pid']);$npid=array_filter($npid);$pid[]=implode(',',$npid);$vid[]=$v['vid'];
			if($v['hid'])$hid[]=$v['hid'];
		}
		if($vid)$vdata=$this->sel(DbPrefix.'vip_basic','where vid in('.implode(',',array_unique($vid)).')','vid,name,phone,sex');
		if($hid)$hdata=$this->sel(DbPrefix.'viphouse','where vid in('.implode(',',array_unique($hid)).')','vid,name,phone,sex');
		if($pid)$pdata=$this->sel(DbPrefix.'building','where id in('.implode(',',array_unique($pid)).')','id,pid,name,img,address,fchk,fav');
		
		foreach($data as $v){
			$narr=array('chk'=>$v['chk'],'fchk'=>$v['fchk'],'id'=>$v['id'],'cont'=>$v['cont'],'score'=>$v['score'],'time'=>date('Y-m-d H:i',$v['stime']),'hchk'=>$this->vip['hchk']?$this->vip['hchk']:0,'txt'=>$this->getChkTxt($v['chk']));
			$pid=explode(',',$v['pid']);
			foreach($pdata as $vv){
				if(in_array($vv['id'],$pid)){
				    $narr['pdata']=$narr['pdata']?$narr['pdata']:array();
				    $vv['url']=$this->strGetUrl('/house.html',$vv['pid'],$vv['id']);
				    $narr['pdata'][]=$this->removeNumKey($vv);
				}
			}
			if($this->vip['hchk']){
			    foreach($vdata as $vv){
				    if($vv['vid']==$v['vid'])$narr['vdata']=$this->removeNumKey($vv);
			    }
			}else{
			    if($v['hid']){
				   foreach($hdata as $vv){
					   if($vv['vid']==$v['hid'])$narr['vdata']=$this->getVip($vv,true);
				   }
			    }
			}
			$arr[]=$narr;
		}
		
		$this->err=array('error'=>0,'max'=>$max,'data'=>$arr,'max'=>$max);
    }
    //获取列表
    public function listOrder(){
		include_once('class/pagesClass.class.php');
		$where=$swhere='where vid='.$this->vip['vid'];
		if($this->vip['hchk']){
		  $where=$swhere='where (hid='.$this->vip['vid'].' or hid is null)';
		}
		if(is_numeric($this->data['c'])){
		  if($this->data['c']==2)
		  $where.=' and chk in(2,3)';
		  else
		  $where.=' and chk='.$this->data['c'];
		}
		$order=' order by id desc ';
		$data=$this->sel($this->dbname,$where,'count(*)',true);
		$max=$data?$data[0]:0;
		$page=new pagesClass($max,$_POST['page']?$_POST['page']:1);
		$data=$this->sel($this->dbname,$where.$order.$page->limit,'id,pid,vid,hid,stime,chk');
		$arr=array();$pid=array();$hid=array();$vid=array();$vdata=array();$hdata=array();$pdata=array();
		foreach($data as $v){
			$npid=explode(',',$v['pid']);$npid=array_filter($npid);$pid[]=implode(',',$npid);$vid[]=$v['vid'];
			if($v['hid'])$hid[]=$v['hid'];
		}
		if($vid)$vdata=$this->sel(DbPrefix.'vip_basic','where vid in('.implode(',',array_unique($vid)).')','vid,name,phone,sex');
		if($hid)$hdata=$this->sel(DbPrefix.'viphouse','where vid in('.implode(',',array_unique($hid)).')','vid,name,phone,sex');
		if($pid)$pdata=$this->sel(DbPrefix.'building','where id in('.implode(',',array_unique($pid)).')','id,pid,name,img,address,fchk,fav');
		
		foreach($data as $v){
			$narr=array('chk'=>$v['chk'],'fchk'=>$v['fchk'],'id'=>$v['id'],'time'=>date('Y-m-d H:i',$v['stime']),'hchk'=>$this->vip['hchk']?$this->vip['hchk']:0,'txt'=>$this->getChkTxt($v['chk']));
			 $pid=explode(',',$v['pid']);
			 $narr['pdata']=array();
			foreach($pdata as $vv){
				if(in_array($vv['id'],$pid)){
				    $nparr=$this->removeNumKey($vv);
				    if($vv['fav'])$nparr['fav']=$this->strJsonToArr($this->strHandleRestore($vv['fav']));
				    $nparr['address']=explode(',',$nparr['address']);
				    $img=$this->strJsonToArr($nparr['img']);
				    $nparr['img']=$this->strImgShow($img);
				    $nparr['url']=$this->strGetUrl('/house.html',$vv['pid'],$vv['id']);
				    $narr['pdata'][]=$nparr;
				}
			}
			foreach($vdata as $vv){
				if($vv['vid']==$v['vid'])$narr['vdata']=$this->removeNumKey($vv);
			}
			if($v['hid']){
			    foreach($hdata as $vv){
				    if($vv['vid']==$v['hid'])$narr['hdata']=$this->removeNumKey($vv,true);
			    }
			}
			$arr[]=$narr;
		}
		$num=array();
		$ndata=$this->sel($this->dbname,$swhere.' and chk=0','count(*)',true);$num[]=$ndata?$ndata[0]:0;
		$ndata=$this->sel($this->dbname,$swhere.' and chk=4','count(*)',true);$num[]=$ndata?$ndata[0]:0;
		$ndata=$this->sel($this->dbname,$swhere.' and chk in(2,3)','count(*)',true);$num[]=$ndata?$ndata[0]:0;
		
		$this->err=array('error'=>0,'max'=>$max,'data'=>$arr,'num'=>$num);
    }
}