<?php
require('class/dataClass.class.php');
class phone extends dataClass{
    public $err=array('error'=>1,'html'=>'未知错误');
    public $data=array();
    private $dbname='vip';
    function __construct(){
        /**检查加密数据**/
        $this->dbname=DbPrefix.$this->dbname;
        $this->data=$this->setData();
    }
    public function sendPhone(){
		if(!$this->strCheckPhone($this->data['phone'])){$this->err['html']='手机号码有误';return false;}
		if(!$this->checkPhoneWay()){return false;}
		$etime=$this->checkPhoneSendTime();
		if($etime){$this->err=array('error'=>0,'html'=>'短信已发送','etime'=>$etime);return false;}
		$code=$this->strGetRand(6);
		$txt=$this->getSendTxt($code);
		$arr=array('phone'=>$this->data['phone'],'t'=>$this->data['t'],'code'=>$code,'txt'=>$txt,'time'=>time());
		return $this->sendMessage($arr);
    }
    public function sendMessage($arr){
		/**短信发送****************************/
		$res=true;
		if(!$res){$this->err=array('error'=>1,'html'=>'短信发送失败');return false;}
		unset($arr['txt']);
		$this->setPhoneCode($arr);
		$this->err=array('error'=>0,'html'=>'发送成功','code'=>$arr['code']);
		return true;
    }
    //检查短信是否发送strOutSession
    private function checkPhoneWay(){
		$data=$this->sel($this->dbname,'where phone=\''.$this->data['phone'].'\'','id',true);
		if($this->data['t']=='reg' && $data){$this->err['html']='手机号码已注册';return false;}
		elseif($this->data['t']=='firget' && !$data){$this->err['html']='手机号码还没有注册';return false;}
		return true;
	}
    private function checkPhoneSendTime(){
		$code=$this->strGetSession('phoneCode');
		if($code && ($code[$this->data['t']] && $code[$this->data['t']]['phone']==$this->data['phone'])){
			$time=$code[$this->data['t']]['time']+CodeTimeOut;
			if($code[$this->data['t']]['time'] && $time>time()){
				return $time-time();
			}
		}
		return false;
    }
    private function setPhoneCode($data){
		$code=$this->strGetSession('phoneCode');$code=$code?$code:array();
		$code[$this->data['t']]=$data;
		$this->strSetSession('phoneCode',$code);
    }
    //设置发送信息内容
    private function getSendTxt($code=false){
		switch($this->data['t']){
			case 'reg':$txt='您使用注册服务，本次验证码：'.$code;break;
			default:$txt='本次验证码：'.$code;
		}
		$txt=$txt.'（如非本人操作，请忽略）【慧买房】';
		return $txt;
    }
}