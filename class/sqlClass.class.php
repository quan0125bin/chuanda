<?php
include_once('strClass.class.php');
//数据库链接SQL语句类
class sqlClass extends strClass{
    public $viewDbname='view';//视图名
    private $mysqli=false;
    public $sql='';//SQL执行语句
    public $id=0;//新插入id
    public $nums=0;//影响行数
    function __construct(){
        parent::__construct();
    }
    //直接执行SQL语句
    public function sqlQuery($sql,$way=false,$server=array()){
        $this->connetHandle($server);//数据库连接处理
        $result=$this->sqlExecute($sql);$data=array();
        if(!$result || $way)return $result;
        while($row=$result->fetch_array()){
			foreach($row as $k=>$v){
				$row[$k]=$this->strHandleRestore($v);
			}
			$data[]=$row;
        }
        return $data;
    }
    //查询语句组合$db（表名）$data（条件）$field（查询字段）$one（限制一条）$server（其他数据库连接参数localhost,name,passwd,dbname）
    public function sel($db,$where,$field='*',$one=false,$server=array()){
        $this->connetHandle($server);//数据库连接处理
        $this->sql=$sql='select '.$field.' from '.$db.' '.$where;
        return $this->selQuery($sql,$one);
    }
    private function selQuery($sql,$one=false){
        $result=$this->sqlExecute($sql);$data=array();
        if(!$result)return $result;
        if($one){
		  $row=$result->fetch_array();
		  foreach($row as $k=>$v){
			 $row[$k]=$this->strHandleRestore($v);
		  }
		  return $row;
        }else{
		  while($row=$result->fetch_array()){
			    foreach($row as $k=>$v){
				    $row[$k]=$this->strHandleRestore($v);
			    }
			 $data[]=$row;
		  }
        }
        return $data;
    }
    //修改语句组合$db（表名）$where（条件）$data（修改字段）$server（其他数据库连接参数localhost,name,passwd,dbname）
    public function update($db,$data,$where='',$server=array()){
        $this->connetHandle($server);//数据库连接处理
        $setData=$this->dataHandle($data,false,false,true);//字段拼接（返回字符串）
        $this->sql=$sql='update '.$db.' set '.$setData.' '.$where;
        return $this->sqlExecute($sql);
    }
    //数据插入语句组合$db（表名）$data（插入字段）$server（其他数据库连接参数localhost,name,passwd,dbname）
    public function insert($db,$data,$server=array()){
        $this->connetHandle($server);//数据库连接处理
        $inData=$this->dataHandle($data,true);//字段拼接(返回数组)
        if(!$inData){
            $this->err=array('error'=>1,'html'=>'字段拼接错误：'.$this->strArrToJson($data));
            return false;
        }
        $this->sql=$sql='insert into '.$db.'('.$inData[0].') values('.$inData[1].')';
        return $this->sqlExecute($sql);
    }
    public function inserts($db,$data,$server=array()){
        $this->connetHandle($server);//数据库连接处理
        $inDataKey=array();$inDataValue='';
        foreach($data as $v){
			$inData=$this->dataHandle($v,true);//字段拼接(返回数组)
			$inDataKey=$inData[0];
			if($inDataValue)$inDataValue.=',';
			$inDataValue.='('.$inData[1].')';
        }
        if(!$inDataKey || !$inDataValue){
            $this->err=array('error'=>1,'html'=>'字段拼接错误：'.$this->strArrToJson($data));
            return false;
        }
        $this->sql=$sql='insert into '.$db.'('.$inDataKey.') values '.$inDataValue;
        return $this->sqlExecute($sql);
    }
    //删除语句组合$db（表名）$where（条件）$server（其他数据库连接参数localhost,name,passwd,dbname）
    public function del($db,$where,$from='',$server=array()){
        $this->connetHandle($server);//数据库连接处理
        $this->sql=$sql='delete '.$from.' from '.$db.' '.$where;
        return $this->sqlExecute($sql);
    }
    //数据字段按键值拼接
    public function dataHandle($data=array(),$insrt=false,$update=false,$cs=false){
        $str='';$inArr=array('','');
        foreach((array)$data as $key=>$val){
            if($str){
				if($update)
					$str.=' and ';
				else
					$str.=',';
            }
            if($inArr[0])$inArr[0].=',';if(strlen($inArr[1])>0)$inArr[1].=',';
            $inArr[0].=$key;
            if(is_array($val)){
                $inArr[1].='\''.$this->strHandle(implode(',',$val),'sql').'\'';
                $str.=$key.'=\''.$this->strHandle(implode(',',$val),'sql').'\'';
            }else{
               if($val)
                $inArr[1].='\''.$this->strHandle($val,'sql').'\'';
               elseif($val=='0')
                $inArr[1].='0';
               else
                $inArr[1].='null';
                if($val || $val=='0')
				$str.=$key.'=\''.$this->strHandle($val,'sql').'\'';
                else
				$str.=$key.'=null';
            }
        }
        if($insrt)return $inArr;
        return $str;
    }
    //执行SQL语句
    private function sqlExecute($sql,$way=false){
        $this->sql=$sql;
        $result=$this->mysqli->query($sql);
       if(!$result && $way){
            return $result;
       }
       if(isset($result->num_rows))$this->nums=$result->num_rows;//影响行数
       if(isset($this->mysqli->insert_id))$this->id=$this->mysqli->insert_id;//新插入id
       return $result;
    }
    //数据库连接处理
    private function connetHandle($server=array()){
        if($server){//判断是否连接其他数据库
            $this->connet($server['localhost'],$server['name'],$server['passwd'],$server['dbname']);
        }
        if(!$this->mysqli)$this->connet();
    }
    //连接数据库
    private function connet($localhost=Localhost,$name=LocalhostName,$passwd=LocalhostPasswd,$dbname=LocalhostDbname){
        $this->mysqli=mysqli_connect($localhost,$name,$passwd);
        if(!$this->mysqli){
            exit;
        }
        mysqli_query($this->mysqli,'set names utf8');
        $db=mysqli_select_db($this->mysqli,$dbname);
        if(!$db){
            exit;
        }
    }
    //删除索引键
    public function removeNumKey($data,$knum=false,$html=false){
        if(!$data)return array();
        foreach($data as $k=>$v){
            if(is_array($v)){
                $data[$k]=$this->removeNumKey($v,true);
            }elseif(is_numeric($k) && !$knum){
                unset($data[$k]);
            }else{
				if($v==null || $v=='null'){
					$data[$k]=($v=='0')?0:'';
				}elseif(strpos($v,'"')){
					$data[$k]=$html?$v:htmlspecialchars($v);
				}else{
					$data[$k]=$v;
				}
            }
        }
        return $data;
    }
    /******************************************/
    //操作日志
    public function logSql($arr){
	   $user=$this->strGetSession('user');
	   $arr['aid']=$user['id'];$arr['client']=$_SERVER['REMOTE_ADDR'].'_'.$_SERVER['HTTP_USER_AGENT'];$arr['time']=time();
	   return $this->insert(DbPrefix.'log',$arr);
    }
    /******************************************/
    //检查动态表
    public function checkDbTable($dbname,$table,$view,$need){
		$dbname=$this->checkTable($dbname,$table,$view,$need);//判断动态表是否存在
		if(!$dbname || $dbname==1){
			$this->err=array('error'=>1,'html'=>'动态表创建失败');return false;
		}
		$dbname=$this->checkTableNums($dbname,$view,$need);//判断动态表表记录数量
		if(!$dbname || $dbname==1){
			$this->err=array('error'=>1,'html'=>'动态表创建失败');return false;
		}
		return $dbname;
    }
    //检查表数量
    public function checkTableNums($dbname,$view,$need){
		$max=$this->sel($dbname,'','count(*)');
		$max=$max[0]?$max[0][0]:0;
		if($max<LocalhostTableMax)return $dbname;
		$dbname=$this->getOldDbname($dbname);
		return $this->checkTable($dbname,date('ymdhis'),$view);//超出限制数量，判断新表名是否纯在
    }
    //获取原始表名
    public function getOldDbname($dbname){
		$dbname=preg_replace('/_([0-9]+)/','',$dbname);
		return $dbname;
    }
    //检查表是否存在
    public function checkTable($dbname,$table,$view=false,$need){
		$res=$this->sqlQuery('select distinct table_name from INFORMATION_SCHEMA.COLUMNS where instr(table_name,\''.$dbname.'_'.$table.'\') order by table_name');
		if($res){
			$res=end($res);
			$dbname=$res[0];//表存在，返回表名
		}else{
			$dbname=$this->creatTable($dbname,$table,$view,$need);//表不存在,动态建表
		}
		return $dbname;
    }
    //创建表
    private function creatTable($dbname,$table,$view,$need){
		$data=$this->sqlQuery('SHOW CREATE TABLE '.$dbname);//获取原始表表结构
		if(!$data)return false;
		$sqlStr=$data[0][1];$sqlStr=str_replace($dbname,$dbname.'_'.$table,$sqlStr);//处理心目名称
		if(!$sqlStr)return false;
		$res=$this->sqlQuery($sqlStr,true);//创建动态表
		if($res){
			$dbname=$dbname.'_'.$table;
			$this->creatView($dbname,$view,$need);//有视图要求，则创建视图
		}else{
			return false;
		}
		return $dbname;//返回新表表名
    }
    //创建视图
    private function creatView($dbname,$view,$need){
		$sqlStr='';$dbname=$this->getOldDbname($dbname);//获取需求字段信息和原始表表名
		//获取以原始表为基础的所有动态表
		$data=$this->sqlQuery('select distinct table_name from INFORMATION_SCHEMA.COLUMNS where instr(table_name,\''.$dbname.'\')');
		$tables=array();
		foreach($data as $v){//组合sql语句
			if($sqlStr)$sqlStr.=' UNION ALL ';
			$sqlStr.='select '.$need.' from '.$v[0].$where;
		}
		$sqlStr='create view '.$this->viewDbname.'_'.$view.' as '.$sqlStr;
		$data=$this->sqlQuery('drop view '.$this->viewDbname.'_'.$view,true);//删除原有视图
		$data=$this->sqlQuery($sqlStr,true);//创建新视图
		return $sqlStr;
    }
    /******************************************/
    //数据库连接销毁
    function __destruct(){
        if($this->mysqli)$this->mysqli->close();
    }
}