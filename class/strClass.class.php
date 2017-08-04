<?php
$dir='';
if(DIR && DIR!='DIR')$dir=DIR.'/';
require($dir.'config/config.php');
//字符串处理类
class strClass{
    function __construct(){
    }
    //关键词注释1（需要注释的关键词）2（注释后的词）3（是否可以恢复）
    private $strArr=array(
        array('!--','#gth#',false),
        array('--','#sql_zs#',true),
        array('/*','#zs#',true),
        array('*/','#fzs#',true),
        array('insert','#sql_in#',true),
        array('delete','#sql_del#',true),
        array('select','#sql_sel#',true),
        array('update','#sql_upd#',true),
        array('show','#sql_show#',true),
        array('table','#sql_table#',true),
    );
    //字符串转密码规则
    public function getPasswd($passwd){
		$psswd=$this->endes3($passwd);
		return md5($passwd);
    }
    private $strNoArr=array('LJ','李娇','Li娇');
    public function strGetRand($num=4,$code=false){
		if($code){
			$code='23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
		}else{
			$code='0123456789';
		}
		$str='';
        for($i=0;$i<$num;$i++){
            $char=$code{rand(0,strlen($code)-1)};
            $str.=$char;
            }
        return $str;
    }
    public function getChkAll($res=false){
	   $arr=array(
		  array('id'=>0,'txt'=>'预约中'),
		  array('id'=>1,'txt'=>'已完成'),
		  array('id'=>2,'txt'=>'安排时间'),
		  array('id'=>3,'txt'=>'看房中'),
		  array('id'=>4,'txt'=>'待评价'),
		  array('id'=>5,'txt'=>'已取消')
	   );
	   return $arr;
    }
    //获取状态
    public function getChkTxt($chk){
	   $arr=$this->getChkAll();$txt='';
	   foreach($arr as $k=>$v){
		  if($chk==$v['id']){
			 $txt=$v['txt'];break;
		  }
	   }
	   return $txt;
    }
    //设置session
    public function strSetSession($k,$v){
	   $_SESSION[$k]=$v;
    }
    //注销session
    public function strOutSession($arr){
	   foreach($arr as $v){
		  if(is_array($v)){
			 $this->strOutSession($v);
		  }else{
			 unset($_SESSION[$v]);
		  }
	   }
    }
    //获取session
    public function strGetSession($k=false){
	   $data=$k?$_SESSION[$k]:$_SESSION;
	   return $data;
    }
    //获取随机数
    public function getRandStr($str=false,$num=6){
        $code='0123456789';
        if($str)$code='23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
        $char=$str='';
        for($i=0;$i<$num;$i++){
            $char=$code{rand(0,strlen($code)-1)};//‘｛｝’表示字符串中第几个字符和数组中[]类似
            $str.=$char;
            }
        return $str;
    }
    //验证验证码
    public function checkPhoneCode($arr,$t,$un=false){
		$code=$this->strGetSession('phoneCode');
		if($code && ($code[$t] && $code[$t]['phone']==$arr['phone'])){
			if($code[$t]['code']==$arr['code']){
				if(!$un)unset($_SESSION['phoneCode'][$t]);
				return true;
			}
		}
		return false;
    }
    //验证手机
	public function strCheckPhone($name){
		$phoneType='/\d{11}$/';//手机
		preg_match_all($phoneType,$name,$phone);
		if(!$phone[0][0]){return false;}
		return true;
	}
    //验证邮箱
	public function strCheckEmail($name){
		$emailType='/.*@{1}.{1,6}\..{0,32}$/';//邮箱
		preg_match_all($emailType,$name,$email);
		if(!$email[0][0]){return false;}
		return true;
	}
    //设置缓存用户
    public function setVip($data){
		$data=$this->getVip($data);
		$this->strSetSession('vip',$data);
		return true;
    }
    public function getVip($data,$h=false){
		$data=$this->removeNumKey($data);
		if($data['img']){
		  $img=$this->strImgShow($this->strJsonToArr($data['img']));
		  $data['img']=$this->strImgShow($img[0]['img']);
		}
		if(!$data['img'])$data['img']='/_0.jpg';
		if(!$data['uname']){$data['uname']=$data['name']?$data['name']:$data['phone'];}
		if($h || $data['hchk']){
		  $data['url']='/search/h'.$data['vid'].'.html';
		}
		return $data;
    }
    //响应输出内容
    public function outResponse($str,$err=false,$json=false){
	   if($_SERVER['HTTP_AC_TYPE']=='json' || $json){
		  if(is_array($str)){
			 foreach($str as $k=>$v){
				$this->err[$k]=$v;
			 }
		  }else{
			 $this->err['html']=$str;
		  }
		  $this->err['error']=$err?0:1;
		  $str=$this->strArrToJson($this->err);
	   }
	   return $str;
    }
    //检测屏蔽发布内容关键词
    public function strCheckNoWord($str){
		$res=true;
        foreach($this->strNoArr as $val){
            if(strpos(' '.$str,$val)){
                $res=false;break;
            }
        }
        return $res;
    }
    //字符串处理
    public function strHandle($str,$way=''){
        if(!$str)return $str;
        $str=htmlentities($str);//将字符串中一些字符转换为HTML实体
        //检查是否有屏蔽关键词
        foreach($this->strArr as $val){
            if(strpos($str,$val[0])){
                $str=str_replace($val[0],$val[1],$str);
            }
        }
        if($way=='sql'){
            return addslashes($str);
        }
        return $str;
    }
    //字符串还原
    public function strHandleRestore($str,$html=true){
        //检查是否有注释关键词
        foreach($this->strArr as $val){
            if(strpos($str,$val[1])){
                if(isset($val[2]) && $val[2])$str=str_replace($val[1],$val[0],$str);//判断是否可以恢复
            }
        }
        $str=html_entity_decode($str);
        return stripslashes($str);
    }
    //数据标题截取
    public function strTitleSub($data,$nameLength=0,$contLength=0,$url=false){
	   foreach($data as $k=>$v){
		  if($v){
			 if($v['name'] && $nameLength){
				if($v['lname']){
				    $data[$k]['names']=$this->strSub($this->strHandleRestore($v['lname']),$nameLength);
				}else{
				    $data[$k]['names']=$this->strSub($this->strHandleRestore($v['name']),$nameLength);
				}
			 }
			 if($_GET['v']){
				$data[$k]['names']=str_replace($_GET['v'],'<i>'.$_GET['v'].'</i>',$data[$k]['names']);
			 }
			 if($v['cont'] && $contLength){
			    if($v['cchk']){$v['cont']='';}
				if($v['ccont'])$v['cont']=$v['ccont'];
				$data[$k]['conts']=$this->strSub($this->strHandleRestore($v['cont']),$contLength);
			 }
			 if($v['stime']){
				$data[$k]['_time_d']=date('Y/m/d',$v['stime']);
				$data[$k]['_time_md']=date('m-d',$v['stime']);
				$data[$k]['_time_md_']=date('m.d',$v['stime']);
				$data[$k]['_time_y']=date('Y',$v['stime']);
			 }
			 if($v['img']){
				$img=$this->strJsonToArr($v['img']);
				if(!$img){
				    $img=$this->strJsonToArr($this->strHandleRestore($v['img']));
				}
				$data[$k]['img_json']=$this->strImgShow($img);
			 }
			 if($v['image']){
				$image=$this->strJsonToArr($v['image']);
				if(!$image){
				    $image=$this->strJsonToArr($this->strHandleRestore($v['image']));
				}
				$data[$k]['image_json']=$this->strImgShow($image);
			 }
			 if($url){
				$data[$k]['url']=$this->strGetUrl($url,$v['pid'],$v['id']);
			 }
		  }
	   }
	   return $data;
    }
    //生成请求地址
    public function strGetUrl($url,$pid=0,$id=0,$other=false){
	   $nurl=explode('.',$url);
	   if(count($nurl)==2 || count($nurl)==1){
		  if(substr($nurl[0],0,1)=='/'){
			 $url=$nurl[0];
		  }else{
			 $url='/'.$nurl[0];
		  }
		  if($pid)$url.='/'.$pid;
		  if($id)$url.='/'.$id;
		  $url.='.html';
	   }
	   return $url;
    }
    //图片展示地址处理
    public function strImgShow($arr){
	   foreach($arr as $k=>$v){
		  if($v['img']){
			 if(is_numeric($this->strsub($v['img'],3))){
				$arr[$k]['img']='/_'.$v['img'];
			 }
		  }
	   }
	   return $arr;
    }
    //数组转JSON
    public function strArrToJson($arr){
        $json=$this->strHandleUrl($arr);
        $json=urldecode(json_encode($json,JSON_UNESCAPED_UNICODE));
        return $json;
    }
    //JSON转数组
    public function strJsonToArr($json,$res=false){
	   $json=str_replace("\n",'\n',$json);
        $arr=json_decode($json,true);
        if(!$arr){
		  $json=str_replace("'",'"',$json);  
		  $arr=json_decode($json,true);
        }
        return $arr;
    }
    //字符串处理成url格式
    public function strHandleUrl($data,$decode=false){
		if(!$data)return false;
        foreach($data as $k=>$v){
            if(is_array($v)){
                $data[$k]=$v?$this->strHandleUrl($v):array();
            }else{
                $data[$k]=$decode?urldecode($v):urlencode($v);
            }
        }
        return $data;
    }
    //字符串替换，用于页面输出
    public function strHandleHtml($str){
        $str=preg_replace('/#red#(.+)#red#/Uis','<span style="color:red">$1</span>',$str);
        $str=str_replace("\n",'<br>',$str);
        return $str;
    }
    //编码检测，转换为utf-8
    public function strCheckCode($str){
        $encode = mb_detect_encoding($str, array('ASCII','UTF-8','GB2312','GBK','BIG5')); 
        if ($encode != 'UTF-8'){ 
            $str = iconv($encode,'UTF-8',$str); 
        }
        return $str;
    }
    public function strSub($str,$length){
        $s="";
        $str=$this->prevent($str,'');
        while($i<$length){
            $ord=ord(substr($str,$i,1));
            if($ord>127){
                $s.=substr($str,$i,3);
                $i=$i+3;
                $length+=2;
            }else{
                $s.=substr($str,$i,1);
                $i++;
            }
        }
        return $s;
    }
    //字符串处理,在可能被注入html样式,js事件和sql语句时使用
    public function prevent($str,$way='*'){
        $s=preg_replace("/<\/?(.*)>/Uis",$way,$str);
        return $s;
    }
    //递归函数
    public function strRecursion($data,$pid=0){
	   $arr=array();
	   foreach($data as $k=>$v){
		  $oarr=$v;
		  if($oarr['pid']==$pid){
			 unset($data[$k]);
			 if($data){
				$ndata=$this->strRecursion($data,$oarr['id'],true);
				if($ndata)$v['data']=$ndata;
			 }
			 $arr[]=$v;
		  }
	   }
	   return $arr;
    }
    /*****获取后台管理员用户拥有权限********/
    public function getRoleMenu($basicMenu,$role){
	   $arr=array();
	   foreach($basicMenu as $k=>$v){
		  if($_SESSION['user']['role'][$role] && $_SESSION['user']['role'][$role]=='no'){
			 unset($basicMenu[$k]);
		  }else{
			 if(!$_SESSION['user']['role'][$role] || in_array($v['id'],$_SESSION['user']['role'][$role])){
				$arr[$k]=$v;
				if($v['data']){
				    $arr[$k]['data']=$this->getRoleMenu($v['data'],$role);
				}
			 }else{
				unset($basicMenu[$k]);
			 }
		  }
	   }
	   return $arr;
    }
    /*****检查权限********/
    public function checkRole($data=array()){
	   if($_SESSION['user']['rchk']==1){
		  if(in_array($_POST['action'],array('state','del','dels')))return false;
		  if($_POST['chk'])$_POST['chk']=0;
	   }elseif($_SESSION['user']['rchk']==2){
		  if($_POST['action']=='sure' && $_POST['way']=='user'){
			 if(is_numeric($_POST['id'])){
				if($_POST['id']==$_SESSION['user']['id'])return true;
			 }else{
				$arr=$this->strJsonToArr($this->dedes3($_POST['id'],true));
				if($arr['id']==$_SESSION['user']['id'])return true;
			 }
		  }
		  return false;
	   }
	   return true;
    }
}