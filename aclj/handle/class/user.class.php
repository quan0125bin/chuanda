<?php
class data{
    public $err=array('error'=>0,'html'=>'保存成功');
    public $obj;
    public $dbname='user';//表名
    private $zarr=array('name','uname','passwd','role','chk','rchk','rtime');
    private $tit='【管理员】';
    function __construct($obj){
        /**检查加密数据**/
        $this->obj=$obj;
        $this->dbname=DbPrefix.$this->dbname;
        $this->data=$_POST;
    }
    private function getPasswd($str,$time=false){
	   $time=$time?$time:time();
	   $str=$time.$str.$time;
	   return md5($str);
    }
    private function getNeed(){
	   return 'id,stime,'.implode(',',$this->zarr);
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
    public function state(){
	   $where='where id='.$this->data['id'];
	   $odata=$this->obj->sel($this->dbname,$where,$this->getNeed(),true);
	   if($odata){
		  $arr=array($this->data['state']=>$odata[$this->data['state']]?0:1);
		  $res=$this->obj->update($this->dbname,$arr,$where);
		  if($res){
			 $title=$odata['uname'].'['.$odata['name'].']';
			 $log=array('way'=>'状态更新'.$this->tit,'title'=>$title,'cont'=>$this->obj->sql,'remark'=>$this->obj->strArrToJson($odata));
			 $this->obj->logSql($log);
			 $this->err['rest']=$arr[$this->data['state']];
		  }else{
			 $this->err=array('error'=>1,'html'=>'更新失败，请重新更新');
		  }
	   }else{
		  $this->err=array('error'=>1,'html'=>'用户不存在');
	   }
	   echo $this->obj->outResponse($this->err,$this->err['error']?0:1);
    }
    public function sure($insert=true){
	   $outUser=false;
	   if($this->data['id']){
		  $arr=$this->obj->strJsonToArr($this->obj->dedes3($this->data['id']));
		  if($arr && is_numeric($arr['id'])){//修改用户信息
			 $where='where id='.$arr['id'];
			 $odata=$this->obj->sel($this->dbname,$where,$this->getNeed(),true);
			 if($odata){
				$insert=false;
				$data=$this->checkData();
				$user=$this->obj->strGetSession('user');
				$data['uid']=$user['id'];
				if($data['passwd']){
				    $data['passwd']=$this->getPasswd($data['passwd'],$odata['rtime']);
				}else{
				    unset($data['passwd']);
				}
				if($this->obj->sel($this->dbname,'where name=\''.$data['name'].'\' and id<>'.$arr['id'],'id')){
				    $this->err=array('error'=>1,'html'=>'用户名已存在');
				}else{
				    $res=$this->obj->update($this->dbname,$data,$where);
				    if($res){
					   ////更新自己的资料后需要退出重新登录
					   if($data['uid']==$arr['id']){
						  $this->loginAgin($arr['id']);//$outUser=$this->out();
					   }
					   $title=$odata['uname'].'['.$odata['name'].']';
					   $log=array('way'=>'更新'.$this->tit,'title'=>$title,'cont'=>$this->obj->sql,'remark'=>$this->obj->strArrToJson($odata));
					   $this->obj->logSql($log);
				    }
				}
			 }
		  }
	   }
	   if($insert){
		  $data=$this->checkData();
		  if($this->obj->sel($this->dbname,'where name=\''.$data['name'].'\'','id')){
			 $this->err=array('error'=>1,'html'=>'用户名已存在');
		  }else{
			 $data['rtime']=time();
			 $user=$this->obj->strGetSession('user');
			 $data['aid']=$user['id'];
			 $data['passwd']=$this->getPasswd($data['passwd'],$data['rtime']);
			 $res=$this->obj->insert($this->dbname,$data);
			 if($res){
				$title=$data['uname'].'['.$data['name'].']';
				$log=array('way'=>'添加'.$this->tit,'title'=>$title,'cont'=>$this->obj->sql,'remark'=>'');
				$this->obj->logSql($log);
			 }
		  }
	   }
	   if(!$res && $this->err['error']==0){
		  $this->err=array('error'=>1,'html'=>'保存失败，请重新提交');
	   }
	   if($res && $outUser)$this->err['html']='保存成功，请重新登录获取最新信息';
	   echo $this->obj->outResponse($this->err,$this->err['error']?0:1);
    }
    public function getData($sdata=false){
	   if(!$sdata){
		  $this->data=$_GET;
	   }
	   $where=$this->getWhere($sdata);
	   $data=$this->obj->sel($this->dbname,$where,'count(*)',true);
	   $max=$data?$data[0]:0;
	   require(DIR.'/class/pageClass.class.php');
	   $page=new pageClass($max,$this->data['page']?$this->data['page']:1,$this->data['psize']?$this->data['psize']:20);
	   $data=$this->obj->sel($this->dbname,$where.$page->limit,$this->getNeed());
	   
	   foreach($data as $k=>$v){
		  if($this->data['name']){
			 $data[$k]['uname']=str_replace($this->data['name'],'<span class="cRed">'.$this->data['name'].'</span>',$v['uname']);
			 $data[$k]['name']=str_replace($this->data['name'],'<span class="cRed">'.$this->data['name'].'</span>',$v['name']);
		  }
		  if($v['role'])$data[$k]['role']=$this->obj->strHandleRestore($v['role']);
	   }
	   return array('max'=>$max,'page'=>$page->out(),'data'=>$data);
    }
    private function loginAgin($id){
	   if($_SESSION['user'] && $_SESSION['user']['id']==$id){
		  $data=$this->obj->sel($this->dbname,'where id='.$id,'*',true);
		  $data=$this->obj->removeNumKey($data);
		  if($data['role']){
			 $role_json=$this->obj->strHandleRestore($data['role']);
			 $role=$this->obj->strJsonToArr($role);
			 foreach($role as $rk=>$rv){
				$role[$rk]=explode(',',$rv);
			 }
			 $data['role_json']=$role_json;
			 $data['role']=$role;
		  }
		  $this->obj->strSetSession('user',$data);
	   }
    }
    public function login(){
	   $data=$this->obj->sel($this->dbname,'where name=\''.$this->data['name'].'\'','*',true);
	   if($data){
		  if($data['passwd']==$this->getPasswd($this->data['passwd'],$data['rtime'])){
			 if($data['chk']){
				$data=$this->obj->removeNumKey($data);
				$this->obj->update($this->dbname,array('stime'=>time()),'where id='.$data['id']);
				if($data['role']){
				    $role_json=$this->obj->strHandleRestore($data['role']);
				    $role=$this->obj->strJsonToArr($role);
				    foreach($role as $rk=>$rv){
					   $role[$rk]=explode(',',$rv);
				    }
				    $data['role_json']=$role_json;
				    $data['role']=$role;
				}
				$this->obj->strSetSession('user',$data);
				$title=$title=$data['uname'].'['.$data['name'].']';
				$log=array('way'=>'登录'.$this->tit,'title'=>$title,'cont'=>$this->obj->sql,'remark'=>$this->obj->strArrToJson($data));
				$this->obj->logSql($log);
				$this->err['html']='登录成功';$this->err['data']=$this->obj->endes3($this->obj->strArrToJson(array('vid'=>$data['id'])));
			 }else{
				$this->err=array('error'=>1,'html'=>'该帐号已被限制登录');
			 }
		  }else{
			 $this->err=array('error'=>1,'html'=>'用户名或密码错误');
		  }
	   }else{
		  $this->err=array('error'=>1,'html'=>'用户名或密码错误');
	   }
	   echo $this->obj->outResponse($this->err,$this->err['error']?0:1);
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
	   $this->obj->strOutSession(array('user'));
	   return true;
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