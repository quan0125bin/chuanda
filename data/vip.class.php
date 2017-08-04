<?php
require('class/dataClass.class.php');
class vip extends dataClass{
    public $err=array('error'=>1,'html'=>'未知错误');
    public $data=array();
    private $dbname='vip';
    function __construct(){
        /**检查加密数据**/
        $this->dbname=DbPrefix.$this->dbname;
        $this->data=$this->setData();
		$this->vip=$this->strGetSession('vip');
    }
    //重置密码
    public function firgetPasswdVip(){
		$data=$this->strJsonToArr($this->dedes3($this->data['data']));
		if(!$data){
			$data=$this->strJsonToArr($this->dedes3(urldecode($this->data['data'])));
		}
		if(!$data){$this->err=array('error'=>1,'html'=>'数据异常','url'=>'?');return false;}
		
		if(!$this->strCheckPhone($data['phone'])){$this->err['html']='手机号码有误';return false;}
		if(!$this->checkPhoneCode($data,'firget')){$this->err['html']='验证码错误';return false;}
		
		if(!$this->data['passwd']){$this->err['html']='密码不能为空';return false;}
		$data=$this->sel($this->dbname,'where phone=\''.$data['phone'].'\'','id',true);
		if(!$data){$this->err=array('error'=>1,'html'=>'数据异常','url'=>'?');return false;}
		$res=$this->update($this->dbname,array('passwd'=>$this->getPasswd($this->data['passwd'])),'where id='.$data['id']);
		if($res){
			$this->err=array('error'=>0,'html'=>'注册成功','url'=>'firgetSure.html');
		}else{
			$this->err['html']='密码修改失败，请重新提交';
		}
    }
    public function setMinVip(){
	   if(!$this->vip['vid']){$this->err['html']='请先登录';return false;}
	   $where='where vid='.$this->vip['vid'];$db=$this->dbname.'_basic';
	   if($this->vip['hchk'])$db=$this->dbname.'house';
	   $arr=array('name'=>$this->data['name'],'sex'=>$this->data['sex']?$this->data['sex']:0,'bir'=>$this->data['bir'],'income'=>$this->data['income'],'qq'=>$this->data['qq'],'cont'=>$this->data['cont']);
	   if($arr['sex'] && !is_numeric($arr['sex'])){$this->err['html']='性别参数有误';return false;}
	   if(!is_numeric($arr['bir'])){$this->err['html']='年轻请填写数字';return false;}
	   $res=$this->update($db,$arr,$where);
	   if($res){
		  $vdata=$this->sel($db,$where,'*',true);
			 if($this->vip['hchk'])$vdata['hchk']=1;
			 $this->setVip($vdata);
			$this->err=array('error'=>0,'html'=>'注册成功');
	   }else{
	   echo $this->sql;
			$this->err['html']='修改失败，请重新提交';
	   }
    }
    //修改密码
    public function passwdVip(){
	   if(!$this->vip['vid']){$this->err['html']='请先登录';return false;}
	   $where='where id='.$this->vip['vid'];
	   $data=$this->sel($this->dbname,$where,'passwd',true);
	   if($this->getPasswd($this->data['oldPasswd'])!=$data['passwd']){$this->err['html']='旧密码有误';return false;}
	   $res=$this->update($this->dbname,array('passwd'=>$this->getPasswd($this->data['passwd'])),$where);
	   
		if($res){
			$this->err=array('error'=>0,'html'=>'修改成功');
		}else{
			$this->err['html']='密码修改失败，请重新提交';
		}
    }
    //忘记密码验证
    public function firgetVip(){
		if(!$this->data['phone']){$this->err['html']='手机号码不能为空';return false;}
		if(!$this->strCheckPhone($this->data['phone'])){$this->err['html']='手机号码有误';return false;}
		if(!$this->checkPhoneCode($this->data,'firget',true)){$this->err['html']='验证码错误';return false;}
		$_SESSION['figet']=$this->data;
		$data=$this->endes3($this->strArrToJson($this->data));
		$this->err=array('error'=>0,'html'=>'验证成功','url'=>'?data='.urlencode($data));
    }
    //登陆
    public function loginVip(){
		if(!$this->data['phone']){$this->err['html']='手机号码不能为空';return false;}
		if(!$this->data['passwd']){$this->err['html']='密码不能为空';return false;}
		if(!$this->strCheckPhone($this->data['phone'])){$this->err['html']='手机号码有误';return false;}
		$data=$this->sel($this->dbname,'where phone=\''.$this->data['phone'].'\'','id,phone,passwd,chk',true);
		if(!$data){$this->err['html']='手机号码未注册';return false;}
		if($data['passwd']!=$this->getPasswd($this->data['passwd'])){$this->err['html']='手机号或密码错误';return false;}
		if(!$data['chk']){$this->err['html']='该手机号已被限制登陆';return false;}
		$vdata=$this->sel($this->dbname.'_basic','where vid='.$data['id'],'*',true);
		if(!$vdata){$this->err['html']='账号异常，请联系管理员';return false;}
		$this->setVip($vdata);
		$res=$this->update($this->dbname.'_basic',array('stime'=>time()),'where vid='.$data['id']);
		$this->err=array('error'=>0,'html'=>'登陆成功','url'=>'./');
    }
    //注册
    public function regVip(){
		if(!$this->data['phone']){$this->err['html']='手机号码不能为空';return false;}
		if(!$this->data['passwd']){$this->err['html']='密码不能为空';return false;}
		if(!$this->data['code']){$this->err['html']='验证码不能为空';return false;}
		if(!$this->strCheckPhone($this->data['phone'])){$this->err['html']='手机号码有误';return false;}
		if(!$this->checkPhoneCode($this->data,'reg')){$this->err['html']='验证码错误';return false;}
		$data=$this->sel($this->dbname,'where phone=\''.$this->data['phone'].'\'','id,phone,passwd,chk',true);
		if($data){$this->err['html']='手机号码已注册，请直接登陆';return false;}
		$arr=array('phone'=>$this->data['phone'],'passwd'=>$this->getPasswd($this->data['passwd']),'chk'=>1);
		$res=$this->insert($this->dbname,$arr);
		if($res){
			$arr=array('phone'=>$arr['phone'],'vid'=>$this->id,'rtime'=>time());
			$res=$this->insert($this->dbname.'_basic',$arr);
			if(!$res){
				$this->del($this->dbname,'where id='.$arr['id']);
			}
		}
		if($res){
			$vdata=$this->sel($this->dbname.'_basic','where vid='.$arr['vid'],'*',true);
			$this->setVip($vdata);
			$this->err=array('error'=>0,'html'=>'注册成功','url'=>'regSure.html');
		}else{
			$this->err['html']='使用的人太多了，请重新提交';
		}
    }
}