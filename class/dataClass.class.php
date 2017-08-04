<?php
require('desClass.class.php');
class dataClass extends desClass{
    public $url='';
    private $pMerCodeNum='';
    public $err=array('error'=>0,'html'=>'操作成功');
    function __construct($key=false,$iv=false){
        parent::__construct();
        $this->url=ApiUrl;
    }
    public function getVipScore($vid){
	   $data=$this->sel(DbPrefix.'order','where hid='.$vid.' and score>0','sum(score),count(*)',true);
	   $score=$data?$data[0]:0;
	   $max=$data?$data[1]:0;
	   if($score>0 && $max>0){
		  $score=($score/$max).'.0';
	   }
	   return $score;
    }
    public function setData(){
    	/******************验证请求源******************************/
		if($_SERVER['HTTP_AC_FORM']!='ac' || !$_SERVER['HTTP_AC_SIGN']){
			header('HTTP/1.1 810  Not Implemented');//返回错误
			echo $this->outResponse('请求源有误');exit;
		}
		$sign=$this->strJsonToArr($this->dedes3($_SERVER['HTTP_AC_SIGN']));
		$signRand=$this->strGetSession('signRand');
		if(is_array($sign) && $sign['signRand']==$signRand){
		}else{
			header('HTTP/1.1 818  Not Sign');//返回错误
			echo $this->outResponse('签名有误');exit;
		}

		return $_POST;
    }
    //请求API接口
    public function dataGetApi($data=array(),$url='IO',$web=false){
        $data=$this->dataEncode($data);
        $url=$web?($web.$url):($this->url.$url);
        $res=$this->curlFunPost($url,$data);
        $deRes=$this->dataDecode($res,true);
        $arrRes=$this->strJsonToArr($res);
        if($deRes){
            return $deRes;
        }elseif($arrRes){
			return $arrRes;
        }else{
			return $res;
        }
    }
    //请求数据加密
    public function dataEncode($data=array(),$sigRest=false){
        $pParam=$data?$this->endes3($this->strArrToJson($data)):'';
        $pSign=strtolower(md5($pParam.$this->pMerCodeNum));//签名
        $data=array('pParam'=>$pParam,'pSign'=>$pSign);
        if($sigRest)return $data['pParam'];
        return $data;
    }
    //返回结果数据加密
    public function encodeData($data,$res=false){
        if($res){
            if($data['pRows']){
                $data['pRows']=urlencode($this->endes3($this->strArrToJson($data['pRows'])));
            }
            $p3DesJsonPara=$data;
        }else{
            $p3DesJsonPara=$this->endes3($this->strArrToJson($data));
        }
        $str=$this->pMerCode.$p3DesJsonPara.$this->pMerCodeNum;
        $pSign=md5($str);
        $data=array('pParam'=>$p3DesJsonPara,'pSign'=>$pSign);
        return $data;
    }
    //结果数据
    public function errorHandle($arr){
        $err=array('pCode'=>'AC00F','pRows'=>'','pMsg'=>$arr['html']);
        $mrr=array('html','error');
        if($arr['error']>0){
            $err['pCode']='AC00A';
        }else{
            $farr=array();
            foreach((array)$arr as $k=>$v){
                if(!in_array($k,$mrr)){
                    $farr[$k]=$v;
                }
            }
            if($farr)$err['pRows']=$farr;
        }
        return $err;
    }
    //获取输出数据
    public function inputData($data){
        $data=$this->encodeData($this->errorHandle($data),true);
        return $this->strArrToJson($data);
    }
    //解析获取请求数据
    public function getData($data){
		if($data['pParam'] && $data['pSign']){
			$pSign=strtolower(md5($data['pParam'].$this->pMerCodeNum));//签名
			if($_POST['pSign']!=$pSign){
				$err=array('error'=>0,'html'=>'签名错误');
				return false;
			}
			$data=$this->strJsonToArr($this->dedes3($data['pParam']));
			return $data;
		}else{
			return $data;
		}
    }
    //解密
    public function dataDecode($str,$request=false){
		if(!$str){
			$err=array('error'=>0,'html'=>'数据为空');
			return false;
		}
		if($request){
			$str=$this->strJsonToArr($str);
		}
		if(is_array($str) && $request){
			if($str['pParam'] && $str['pParam']['pRows']){
				$str['pParam']['pRows']=$this->dataDecode($str['pParam']['pRows']);
			}
			return $str;
		}else{
			$json=$this->dedes3(urldecode($str),true);
			if(!$json){
				$err=array('error'=>0,'html'=>'数据解析失败');
				return false;
			}
			$data=$this->strJsonToArr($json);
        }
        return $data;
    }
    //跨站请求
    public function curlFunPost($token_url,$cont=false){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$token_url); 
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);  //强制协议为1.0
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect: '));//头部要送出'Expect: '
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );  //强制使用IPV4协议解析域名
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        if($cont){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $cont);
        }
        $result = curl_exec($ch); 
        curl_close($ch);
        return $result;
    }
    public function curlFunGet($token_url,$key){
        $ch = curl_init();
        $header=array(
            "accept: application/json",
            "apix-key: {$key}",
            "content-type: application/json"
          );
        curl_setopt_array($ch, array(
          CURLOPT_URL => $token_url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => $header,
        ));
        $result = curl_exec($ch); 
        curl_close($ch);
        return $result;
    }
    public function curlFunApixPOST($token_url,$key,$cont){
        $ch = curl_init();
        $header=array(
            "accept: application/json",
            "apix-key: {$key}",
            "content-type: application/json"
          );
        curl_setopt_array($ch, array(
          CURLOPT_URL => $token_url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $cont,
          CURLOPT_HTTPHEADER => $header,
        ));
        $result = curl_exec($ch); 
        curl_close($ch);
        return $result;
    }
}