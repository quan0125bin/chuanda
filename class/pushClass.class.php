<?php
//推送处理类
/*
lplatform（平台）lplatformid（平台id）lplatformids（多个平台id）
lplatform:平台1（安卓）2（IOS）
platform:推送平台android,ios
type:必填 notification-通知，message-消息
title:必填 通知栏提示文字
cont:必填 通知文字描述
where:组播条件version(小于该版本号),time(该时间后不活跃)
    
uni(单播)list(列播)borad(广播)group(组播)
*/
require('class/dataClass.class.php');
class pushClass extends dataClass{
    public $err=array('error'=>0,'html'=>'操作成功');
    private $pushUrl='http://msg.umeng.com/api/send';//请求地址
    private $keyIos='';//iOs key
    private $secretIos='';//iOs secret
    private $keyAndroid='';//Android key
    private $secretAndroid='';//Android secret
    private $production='false';//正式/测试
    //获取签名
    private function getSignPush($data,$secret){
	   $str='POST'.$this->pushUrl.$data.$secret;
	   return md5($str);
    }
    //发起推送
    public function surePush($data,$sig){
	   $url=$this->pushUrl.'?sign='.$sig;
	   $res=$this->curlFunPost($url,$data);
	   if(!$res){
		  $this->err=array('error'=>1,'html'=>'推送给失败');return false;
	   }
	   $result=$this->strJsonToArr($res);
	   if($result){
		  logClass::logInput($this->strArrToJson($result)."\n",'file');
		  logClass::logInput($data,'file');
		  if($result['ret']=='SUCCESS')return true;
		  $this->err=array('error'=>1,'html'=>'推送给失败：'.$result['data']['error_code']);return false;
	   }else{
		  logClass::logInput('推送给失败：','file');
	   }
	   $this->err=array('error'=>1,'html'=>'推送给失败');return false;
    }
    public function sendPush($data){
	   $way=$data['push'].'Push';
	   return $this->$way($data);
    }
    //推送单播
    public function uniPush($arr){
	   if($arr['lplatformids'] && !$arr['lplatformid']){
		  return $this->listPush($arr);
	   }
	   $data=$this->getDataPush($arr,array('type'=>'unicast'));
	   if(!$data)return false;
	   $sig=$this->getSignPush($data[0],$data[1]);
	   return $this->surePush($data[0],$sig);
    }
    //推送列播
    public function listPush($arr){
	   $res=false;$err=array();
	   $platformids=array('android'=>array(),'ios'=>array());
	   $platformid=explode(',',($arr['lplatformids']?$arr['lplatformids']:$arr['lplatformid']));
	   if(!$platformid){
		  return false;
	   }
	   foreach($platformid as $v){
		  $platform=strlen($v);
		  if($platform==44){
			 $platformids['android'][]=$v;
		  }elseif($platform==64){
			 $platformids['ios'][]=$v;
		  }
	   }
	   if($platformids['android']){//推送安卓端信息
		  $arr['lplatformid']=$platformids['android'][0];
		  $dataAnd=$this->getDataPush($arr,array('type'=>'listcast','device_tokens'=>implode(',',$platformids['android'])));
		  if(!$dataAnd)return false;
		  $sig=$this->getSignPush($dataAnd[0],$dataAnd[1]);
		  $res=$this->surePush($dataAnd[0],$sig);
		  if(!$res)$err[]='Android端推送失败';
	   }
	   if($platformids['ios']){//推送iOs端信息
		  $arr['lplatformid']=$platformids['ios'][0];
		  $dataIos=$this->getDataPush($arr,array('type'=>'listcast','device_tokens'=>implode(',',$platformids['ios'])));
		  if(!$dataIos)return false;
		  $sig=$this->getSignPush($dataIos[0],$dataIos[1]);
		  $res=$this->surePush($dataIos[0],$sig);
		  if(!$res)$err[]='iOs端推送失败';
	   }
	   if(!$res){
		  if($this->err['error']>0){
			 $this->err['html'].=$err?implode('，',$err):'推送ID有误';
		  }else{
			 $this->err=array('error'=>1,'html'=>'推送失败：'.($err?implode('，',$err):'推送ID有误'));
		  }
	   }
	   return $res;
    }
    //推送广播
    public function boradPush($arr){
	   $platformids=array();$res=false;
	   if($arr['platforms']){
		  $platformids[$arr['platforms']]=true;
	   }else{
		  $platformids=array('android'=>true,'ios'=>true);
	   }
	   if($platformids['android']){//推送安卓端信息
		  $dataAnd=$this->getDataPush($arr,array('type'=>'broadcast','platform'=>44));
		  if(!$dataAnd)return false;
		  $sig=$this->getSignPush($dataAnd[0],$dataAnd[1]);
		  $res=$this->surePush($dataAnd[0],$sig);
		  if(!$res)$err[]='Android端推送失败';
	   }
	   if($platformids['ios']){//推送iOs端信息
		  $dataIos=$this->getDataPush($arr,array('type'=>'broadcast','platform'=>64));
		  if(!$dataIos)return false;
		  $sig=$this->getSignPush($dataIos[0],$dataIos[1]);
		  $res=$this->surePush($dataIos[0],$sig);
		  if(!$res)$err[]='iOs端推送失败';
	   }
	   if(!$res){
		  $this->err=array('error'=>1,'html'=>'推送失败：'.($err?implode('，',$err):'推送平台有误'));
	   }
	   return $res;
    }
    //推送组播
    public function groupPush($arr){
	   $platformids=array();$res=false;$push=array('type'=>'groupcast');
	   if($arr['where']){
		  $push['filter']=array('where'=>array('and'=>array()));
		  //版本号
		  if($arr['where']['version'])$push['filter']['where']['and'][]=array('app_version'=>'<'.$arr['where']['version']);
		  //时间段后的活跃度
		  if($arr['where']['time'])$push['filter']['where']['and'][]=array('not_launch_from'=>$arr['where']['time']);
	   }
	   if($arr['platforms']){
		  $platformids[$arr['platforms']]=true;
	   }else{
		  $platformids=array('android'=>true,'ios'=>true);
	   }
	   if($platformids['android']){//推送安卓端信息
		  $push['platform']=44;
		  $dataAnd=$this->getDataPush($arr,$push);
		  if(!$dataAnd)return false;
		  $sig=$this->getSignPush($dataAnd[0],$dataAnd[1]);
		  $res=$this->surePush($dataAnd[0],$sig);
		  if(!$res)$err[]='Android端推送失败';
	   }
	   if($platformids['ios']){//推送iOs端信息
		  $push['platform']=64;
		  $dataIos=$this->getDataPush($arr,$push);
		  if(!$dataIos)return false;
		  $sig=$this->getSignPush($dataIos[0],$dataIos[1]);
		  $res=$this->surePush($dataIos[0],$sig);
		  if(!$res)$err[]='iOs端推送失败';
	   }
	   if(!$res){
		  $this->err=array('error'=>1,'html'=>'推送失败：'.($err?implode('，',$err):'推送平台有误'));
	   }
	   return $res;
    }
    //处理推送信息
    private function getDataPush($arr,$push=false){
	   $arr['type']=$arr['type']?$arr['type']:'notification';
	   /*************checkCont*************/
	   if($arr['cont']){
		  if(is_array($arr['cont'])){
			 $arr['cont']='';
		  }else{
			 $acont=$this->strArrToJson($arr['cont']);
			 if($acont)$arr['cont']='';
		  }
	   }
	   /*************checkCont*************/
	   $data=array(
		  'appkey'=>'',
		  'timestamp'=>time(),
		  'type'=>'',
		  'device_tokens'=>$arr['lplatformid'],
		  'payload'=>array(),
		  'policy'=>array('start_time'=>$arr['sendTime']?$arr['sendTime']:''),
		  'production_mode'=>$this->production,//正式/测试模式
		  'description'=>$arr['cont']
	   );
	   if($arr['lplatformid'])$data['device_tokens']=$arr['lplatformid'];
	   if($data['device_tokens']){
		  $platform=strlen($data['device_tokens']);
	   }else{
		  $platform=$push['platform']?$push['platform']:0;
	   }
	   if($platform==44){//Android
		  $secret=$this->secretAndroid;$data['appkey']=$this->keyAndroid;
		  $data['payload']=array('display_type'=>$arr['type'],'body'=>array('ticker'=>$arr['title'],'title'=>$arr['title'],'text'=>$arr['cont'],'after_open'=>$arr['after']?$arr['after']:'go_custom','activity'=>$arr['activity']?$arr['activity']:'','url'=>$arr['url']?$arr['url']:'','custom'=>$arr['custom']?$arr['custom']:''),'extra'=>$arr['extra']);
	   }elseif($platform==64){//IOS
		  $secret=$this->secretIos;$data['appkey']=$this->keyIos;
		  $data['payload']=$arr['other']?$arr['other']:array();
		  $data['payload']['aps']['alert']=array('title'=>$arr['title'],'body'=>$arr['cont']);
	   }else{
		  $this->err=array('error'=>1,'html'=>'当前用户未在APP登录');
		  return false;
	   }
	   if($push){
		  foreach($push as $k=>$v){
			 $data[$k]=$v;
		  }
	   }
	   $data=$this->strArrToJson($data);
	   return array($data,$secret);
    }
}