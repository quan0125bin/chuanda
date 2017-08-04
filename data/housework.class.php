<?php
require('class/dataClass.class.php');
class housework extends dataClass{
    public $err=array('error'=>1,'html'=>'未知错误');
    public $data=array();
    private $dbname='viphouse';
    function __construct(){
        /**检查加密数据**/
        $this->dbname=DbPrefix.$this->dbname;
        $this->data=$this->setData();
    }
    public function searchHousework(){
	   $v=$this->data['v'];
	   $data=$this->sel(DbPrefix.'building','where chk=1 and (instr(name,\''.$v.'\') or instr(tag,\''.$v.'\') or instr(lname,\''.$v.'\')) order by fchk desc,rank desc,id desc limit 5','id,name');
	   foreach($data as $k=>$v){
		  $data[$k]=$this->removeNumKey($v);
	   }
	   $this->err=array('error'=>0,'data'=>$data);
    }
    //重置密码
    public function firgetPasswdHousework(){
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
    //忘记密码验证
    public function firgetHousework(){
		if(!$this->data['phone']){$this->err['html']='手机号码不能为空';return false;}
		if(!$this->strCheckPhone($this->data['phone'])){$this->err['html']='手机号码有误';return false;}
		if(!$this->checkPhoneCode($this->data,'firget',true)){$this->err['html']='验证码错误';return false;}
		$_SESSION['figet']=$this->data;
		$data=$this->endes3($this->strArrToJson($this->data));
		$this->err=array('error'=>0,'html'=>'验证成功','url'=>'?data='.urlencode($data));
    }
    //登陆
    public function loginHousework(){
		if(!$this->data['phone']){$this->err['html']='手机号码不能为空';return false;}
		if(!$this->data['passwd']){$this->err['html']='密码不能为空';return false;}
		if(!$this->strCheckPhone($this->data['phone'])){$this->err['html']='手机号码有误';return false;}
		$data=$this->sel($this->dbname,'where phone=\''.$this->data['phone'].'\'','id,vid,phone,passwd,chk',true);
		if(!$data){$this->err['html']='手机号码未注册';return false;}
		if($data['passwd']!=$this->getPasswd($this->data['passwd'])){$this->err['html']='手机号或密码错误';return false;}
		if(!$data['chk']){$this->err['html']='该手机号已被限制登陆';return false;}
		if(!$data['vid']){
		  $this->update($this->dbname,array('vid'=>$data['id']),'where id='.$data['id']);
		}
		$vdata=$this->sel($this->dbname,'where id='.$data['id'],'*',true);
		if(!$vdata){$this->err['html']='账号异常，请联系管理员';return false;}
		$vdata['hchk']=1;
		$this->setVip($vdata);
		$res=$this->update($this->dbname,array('stime'=>time()),'where id='.$vdata['id']);
		$this->err=array('error'=>0,'html'=>'登陆成功','url'=>'./');
    }
    //设置缓存用户
    public function setVip($data){
		$data=$this->removeNumKey($data);
		if($data['img']){
		  $img=$this->strImgShow($this->strJsonToArr($data['img']));
		  $data['img']=$this->strImgShow($img[0]['img']);
		}
		if(!$data['img'])$data['img']='/_0.jpg';
		if(!$data['uname']){$data['uname']=$data['name']?$data['name']:$data['phone'];}
		$this->strSetSession('vip',$data);
		return true;
    }
}