<?php
require('class/dataClass.class.php');
include_once('class/pagesClass.class.php');
class building extends dataClass{
    public $err=array('error'=>1,'html'=>'未知错误');
    public $data=array();
    private $dbname='building';
    function __construct(){
        /**检查加密数据**/
        $this->dbname=DbPrefix.$this->dbname;
        $this->data=$this->setData();
    }
    public function searchBuilding(){
	   $v=$this->data['v'];$need='id,pid,name,lname,price,fchk,fav,favOld,img,address,addressVal,area,tag,otime';
	   $where='where chk=1 and (instr(name,\''.$v.'\') or instr(tag,\''.$v.'\') or instr(lname,\''.$v.'\'))';
	   $order=' order by fchk desc,rank desc,id desc ';
	   $data=$this->sel($this->dbname,$where,'count(*)',true);
	   $max=$data?$data[0]:0;
	   $page=new pagesClass($max,$_POST['page']?$_POST['page']:1);
	   $data=$this->sel($this->dbname,$where.$order.$page->limit,$need);
	   $data=$this->strTitleSub($data,20,45,'/house.html');
	   foreach($data as $k=>$v){
		  unset($v['img'],$v['id'],$v['pid']);
		  $data[$k]=$this->removeNumKey($v);
		   if($v['address'])$data[$k]['address']=explode(',',$v['address']);
		   if($v['tag'])$data[$k]['tag']=explode(',',$v['tag']);
		   if($v['fav'])$data[$k]['fav']=$this->strJsonToArr($this->strHandleRestore($v['fav']));
		   if($v['favOld'])$data[$k]['favOld']=$this->strJsonToArr($this->strHandleRestore($v['favOld']));
	   }
	   $this->err=array('error'=>0,'data'=>$data,'max'=>$max);
    }
}