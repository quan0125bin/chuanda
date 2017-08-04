<?php
class publicClass{
    public function getNeed($arr){
	   if($arr){
		  return implode(',',$arr);
	   }else{
		  return 'id,stime,'.implode(',',$this->zarr);
	   }
    }
    public function state(){
	   if(!is_numeric($this->data['id'])){
		  $arr=$this->obj->strJsonToArr($this->obj->dedes3($this->data['id'],true));
		  $this->data['id']=$arr?$arr['id']:'';
	   }
	   if(is_numeric($this->data['id'])){
		  $where='where id='.$this->data['id'];
		  $odata=$this->obj->sel($this->dbname,$where,$this->getNeed(),true);
		  if($odata){
			 if(in_array($this->data['state'],array('type','rank')))
			 $arr=array($this->data['state']=>$this->data[$this->data['state']]);
			 else
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
			 $this->err=array('error'=>1,'html'=>'数据异常');
		  }
	   }else{
		  $this->err=array('error'=>1,'html'=>'数据异常');
	   }
	   echo $this->obj->outResponse($this->err,$this->err['error']?0:1);
    }
    public function dels(){
	   $where='where id in('.$this->data['id'].')';
	   $odata=$this->obj->sel($this->dbname,$where,$this->getNeed($this->zarr));
	   if($odata){
		  $res=$this->obj->del($this->dbname,$where);
		  if($res){
			 $cont=$this->obj->sql;
			 if($this->dbarr){
				foreach($this->dbarr as $v){
				    $resv=$this->obj->del($this->dbname.'_'.$v,'where bid in('.$this->data['id'].')');
				    if($resv){
					   $cont.=';'.$this->obj->sql;
				    }
				}
			 }
			 if($this->dbnameBasic){
				$resv=$this->obj->del($this->dbname.$this->dbnameBasic,'where vid in('.$this->data['id'].')');
				if($resv){
				    $cont.=';'.$this->obj->sql;
				}
			 }
			 $log=array('way'=>'批量删除'.$this->tit,'title'=>'','cont'=>$cont,'remark'=>$this->obj->strArrToJson($odata));
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
	   $odata=$this->obj->sel($this->dbname,$where,$this->getNeed($this->zarr),true);
	   if($odata){
		  $res=$this->obj->del($this->dbname,$where);
		  if($res){
			 $cont=$this->obj->sql;
			 if($this->dbarr){
				foreach($this->dbarr as $v){
				    $resv=$this->obj->del($this->dbname.'_'.$v,'where bid='.$this->data['id']);
				    if($resv){
					   $cont.=';'.$this->obj->sql;
				    }
				}
			 }
			 if($this->dbnameBasic){
				$resv=$this->obj->del($this->dbname.$this->dbnameBasic,'where vid='.$this->data['id']);
				if($resv){
				    $cont.=';'.$this->obj->sql;
				}
			 }
			 $title=$odata['uname'].'['.$odata['name'].']';
			 $log=array('way'=>'删除'.$this->tit,'title'=>$title,'cont'=>$cont,'remark'=>$this->obj->strArrToJson($odata));
			 $this->obj->logSql($log);
			 $this->err['html']='删除成功';
		  }else{
			 $this->err=array('error'=>1,'html'=>'删除失败，请重新添加');
		  }
	   }else{
		  $this->err=array('error'=>1,'html'=>'数据不存在');
	   }
	   echo $this->obj->outResponse($this->err,$this->err['error']?0:1);
    }
    public function checkData($arr=false){
	   $data=array();$arr=$arr?$arr:$this->zarr;
	   foreach($this->data as $k=>$v){
		  if(in_array($k,$arr)){
			 $data[$k]=$v;
		  }
	   }
	   return $data;
    }
}