<?php
class fileClass{
    private $imgTypes=array('image/png','image/gif','image/jpg','image/jpeg','image/pjpeg','image/x-png');
    private $otherTypes=array('mp4','mp3','wav','zip','rar');
    public $fileTypeKey=array('255216'=>'jpg','7173'=>'gif','6677'=>'bmp','13780'=>'png','2552169'=>'jpeg','1000'=>'mp4','1001'=>'mp3','1002'=>'wav');
    private $maxImageSize=10240000;//10Mb
    private $maxFileSize=102400000;//100Mb
    private $temps='/upload/';
    private $newName;
    private $path;
    private $fileType;
    private $fileImg;
    public $obj;
    public $pathRand;//临时路径编号
    public $tempPath;//临时路径
    public $err=array('error'=>0,'html'=>'操作成功');
    function __construct($api){
        $this->obj=$api;
    }
    //文件上传
    public function fileHandle($files,$path,$fileImg=false){
		$newsName=array();$this->fileImg=$fileImg;$this->ymd=date('Ymd');
		//$this->setTemp();//建立临时文件夹
		foreach($files as $v){
			$res=$this->file($v,$path);
			if($res){
				$temp=$this->pathRand.$res;
				$res=$res;
				$newsName[]=array('img'=>$this->ymd.'/'.$this->newName,'fileType'=>$this->fileType,'name'=>$this->oname[0]);
			}
		}
		return $newsName;
    }
    //根据编码获取文件类型
    public function getFileType($val,$res=false){
		$type='';
		foreach($this->fileTypeKey as $k=>$v){
			if($res){
				if($v==$val)$type=$k;
			}else{
				if($k==$val)$type=$v;
			}
		}
		return $type;
    }
    public function removeOverDir(){
		$day=0-FileOver;
		$dir=$this->root().$this->temps.date('Ymd',strtotime($day." day"));
		$this->unlinkDir($dir);
    }
    public function file($file,$path){
        $this->path=$path;$html='';
        foreach($file as $key=>$val){
            $this->$key=$val;$html.=$key.'=>'.$val."<br>";
        }
        if($this->error==4){
            $this->err=array('error'=>1,'html'=>'请选择上传的文件');return false;
        }
        if(!$this->checkFile())return false;//检测文件
        if(!$this->checkSize())return false;//检测文件大小
		if(!$this->newName())return false;//重命名文件
		if(!$this->copyFile())return false;//移动文件
		return $this->path;
    }
    //检测大小
    private function checkSize(){
		if(!$this->size){
            $this->err=array('error'=>1,'html'=>'请选择上传的文件');return false;
		}
		if($this->fileImg){//图片
			if($this->size < $this->maxImageSize)return true;
		}else{
			if($this->size < $this->maxFileSize)return true;
		}
		$this->err=array('error'=>1,'html'=>'文件过大');return false;
    }
    //设置新文件名
    private function newName(){
	   $rand=$this->obj->strGetRand();
	   $this->newName=date('His').$rand.'.'.$this->fileType;
        return true;
    }
    //移动文件至指定目录
    private function copyFile($resize){
        $this->checkDir();
        if(rename($this->tmp_name,$this->pathRand.$this->newName)){
            return true;
        }else{
            $this->err=array('error'=>1,'html'=>'移动失败');return false;
        }
    }
    //检查文件路径
    private function checkDir(){
		$npath=$this->root().$this->path.$this->ymd.'/';$res=true;
		if(!file_exists($npath) && !is_writable($npath)){
			$res=mkdir($npath,0777,true);
		}
		$this->pathRand=$npath;
		if(!$res){
            $this->err=array('error'=>1,'html'=>'临时目录创建失败');return false;
		}
		return true;
    }
    
    //检查文件和类型
    public function checkFile(){
		if($this->fileImg){//检测图片
			$file = fopen($this->tmp_name, "rb");
			$bin = fread($file, 2); //只读2字节  
			fclose($file);
			$strInfo = @unpack("C2chars", $bin);  
			$typeCode = intval($strInfo['chars1'].$strInfo['chars2']);  
			$fileType = '';  
			switch ($typeCode){
				case 7790:  
					$fileType = 'exe';break;  
				case 7784:  
					$fileType = 'midi';break;  
				case 8297:  
					$fileType = 'rar';break;          
				case 8075:  
					$fileType = 'zip';break;  
				case 255216:  
					$fileType = 'jpg';break;  
				case 7173:  
					$fileType = 'gif';break;  
				case 6677:  
					$fileType = 'bmp';break;  
				case 13780:  
					$fileType = 'png';break;  
				default:  
					$fileType = $typeCode;  
			}
			//Fix  
			if ($strInfo['chars1']=='-1' AND $strInfo['chars2']=='-40' ) $fileType='jpg';  
			if ($strInfo['chars1']=='-119' AND $strInfo['chars2']=='80' ) $fileType='png';
			if(strpos(implode(',',$this->imgTypes),$fileType)){
				$this->fileType=$fileType;
				$name=explode('.',$this->name);
				$this->oname=$name;
				$this->newPath='img/'.$this->newPath;
				return true;
			}else{
				$this->fileImg=false;
				return $this->checkFile();
			}
		}else{//检测视频、音频
			$type=pathinfo($this->name);$fileType=$type['extension'];
			if(in_array($fileType,$this->otherTypes)){
				$this->fileType=$fileType;
				$this->newPath='video/'.$this->newPath;
				return true;
			}else{
				$this->err=array('error'=>1,'html'=>'格式不符');return false;
			}
		}
    }
    
    
    //移动目录
    private function moveDirFile($odir,$newDir){
		$dir=opendir($odir);$res=true;
		while($file=readdir($dir)){
			$fdir=$odir.'/'.$file;
			if(!in_array($file,array('.','..'))){
				if(strpos($file,'.')>0){
					$res=rename($fdir,$newDir.'/'.$file);
				}else{
					$newDir=$newDir.'/'.$file;
					$this->mkDirs($newDir);//创建正式目录
					$this->moveDirFile($fdir,$newDir);//继续检查目录
				}
			}
		}
		return $res;
    }
    //删除目录
    private function unlinkDir($aimDir) {
        $aimDir = str_replace('', '/', $aimDir);
        $aimDir = substr($aimDir, -1) == '/' ? $aimDir : $aimDir . '/';
        if (!is_dir($aimDir)) {
            return false;
        }
        $dirHandle = opendir($aimDir);
        while (false !== ($file = readdir($dirHandle))) {
			if(in_array($file,array('.','..'))){
                continue;
            }
            if (is_dir($aimDir . $file)) {
                $this->unlinkDir($aimDir . $file);
            }else{
			//unlink($aimDir . $file);
            }
        }
        closedir($dirHandle);
        return rmdir($aimDir);
    }
    
    //创建缩略图
    private function resize($resize){
        if(!$resize)return true;
        foreach($resize as $v){
            $newname=$this->getHeaderImg($this->newName,$v[0],$v[1]);
            $newname=$this->path.$newname;
            $res=$this->imgResizeStart($this->path.$this->newName,$v[0],$v[1],true,$newname);
        }
        return true;
    }
    //获取网站根目录的物理地址
    public function root($f){
        $all = $_SERVER['PATH_TRANSLATED'];
        $self = $_SERVER['PHP_SELF'];
        $string = trim(str_replace($self, '', str_replace('\\', '/', $all)));
        $path = (!is_null($string) && $string != '') ? $string : $_SERVER['DOCUMENT_ROOT'];
        return $path.$f;
    }
    //身份证图片方向
    public function directionCard($img,$path='../../'){
           $filename=$path.$img;
           $data=getimagesize($filename);
           $res=true;
           if($data[0] && $data[1]){
                if($data[0]<$data[1]){
                     $this->imgResizeWH($filename,$data[0],$data[1]);
                    $res=$this->directionCardRotate($filename,$data['mime']);
                }
                if($res){
                     if($data[0]>700 && $data[1]>500){
                          $this->imgResizeStart($filename,700,500,true,$filename);
                     }
                }
           }
           return $res;
    }
    //处理旋转
    public function rotate($rotate=false){
        if(!$rotate)return true;
        $img=$this->tmp_name;
        $size=getimagesize($img);
        if($size[0]<$size[1]){
            $source=false;
            switch($this->fileType){
                case 'jpg':
                    $source = imagecreatefromjpeg($img);
                    $source = imagerotate($source, $rotate, 0);
                    imagejpeg($source,$img);
                    break;
                case 'png':
                    $source = imagecreatefrompng($img);
                    $source = imagerotate($source, $rotate, 0);
                    imagepng($source,$img);
                    break;
                case 'gif':
                    $source = imagecreatefromgif($img);
                    $source = imagerotate($source, $rotate, 0);
                    imagegif($source,$img);
                    break;
            }
            if($source)imagedestroy($source);
        }
        return true;
    }
    private function imgResizeWH($filename,$width,$height){
           if($width>1200 && $height>1200){
                return $this->imgResizeWH($filename,$width*0.3,$height*0.3);
           }
           $this->imgResizeStart($filename,1200,1200,true,$filename);
    }
    private function directionCardRotate($filename,$type){
         $arr=array('image/png','image/gif','image/jpg','image/jpeg','image/pjpeg','image/x-png');
         
         if($type==$arr[0]){
                //创建图像资源，以jpeg格式为例
              $source = imagecreatefrompng($filename);
              if($source){
                   //使用imagerotate()函数按指定的角度旋转
                   $rotate = @imagerotate($source, 90, 0);
                   //旋转后的图片保存
                   @imagepng($rotate,$filename);
              }
         }elseif($type==$arr[2] || $type==$arr[3]){
                //创建图像资源，以jpeg格式为例
              $source = imagecreatefromjpeg($filename);
              if($source){
                   //使用imagerotate()函数按指定的角度旋转
                   $rotate = @imagerotate($source, 90, 0);
                   //旋转后的图片保存
                   @imagejpeg($rotate,$filename);
              }
         }else{
           $this->err=array('error'=>1,'html'=>$type);
           return false;
         }
         return true;
    }
}
/***************************缩略图处理*************************/
//$resizeimage = new resizeimage("图片源文件地址", "宽", "高", "裁图","缩略图地址");
class imgResize{
    private $type; //图片类型   
    private $width;  //实际宽度   
    private $height;  //实际高度   
    private $resize_width;  //改变后的宽度
    private $resize_height; //改变后的高度   
    private $cut;  //是否裁图
    private $srcimg; //源图象    
    private $dstimg; //目标图象地址    
    private $im; //临时创建的图象

    public function imgResizeStart($img,$wid,$hei,$c,$dstpath){
       $this->srcimg = $img;
       $this->resize_width = $wid;
       $this->resize_height = $hei;
       $this->cut = $c;
       //图片的类型	   
       $this->type = strtolower(substr(strrchr($this->srcimg,"."),1));
       //初始化图象
       $this->initi_img();
       //目标图象地址
       $this -> dst_img($dstpath);
       //--
       $this->width = imagesx($this->im);
       $this->height = imagesy($this->im);
       //生成图象
       $this->newimg();
       //释放内存
       imagedestroy($this->im);
    }
    private function newimg(){
       //改变后的图象的比例
       $resize_ratio = ($this->resize_width)/($this->resize_height);
       //实际图象的比例
       $ratio = ($this->width)/($this->height);
       /*******************************/
       $x=($this->width-$this->resize_width)/2;
       $y=($this->height-$this->resize_height)/2;
       if($x<0)$x=0;
       if($y>0)$y=0;
       /*******************************/
       if($this->cut=='1'){//裁图
          if($ratio>=$resize_ratio){//高度优先
             $newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
             imagecopyresampled($newimg, $this->im, 0, 0, 0, $y, $this->resize_width,$this->resize_height, (($this->height)*$resize_ratio), $this->height);
             imagejpeg($newimg,$this->dstimg, 100);
          }elseif($ratio<$resize_ratio){//宽度优先
             $newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
             imagecopyresampled($newimg, $this->im, 0,0, 0, $y, $this->resize_width, $this->resize_height, $this->width, (($this->width)/$resize_ratio));
             imagejpeg($newimg,$this->dstimg, 100);
          }
       }else{//不裁图
          if($ratio>=$resize_ratio){
             $newimg = imagecreatetruecolor($this->resize_width,($this->resize_width)/$ratio);
             imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, ($this->resize_width)/$ratio, $this->width, $this->height);
             imagejpeg($newimg,$this->dstimg, 100);
          }elseif($ratio<$resize_ratio){
             $newimg = imagecreatetruecolor(($this->resize_height)*$ratio,$this->resize_height);
             imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, ($this->resize_height)*$ratio, $this->resize_height, $this->width, $this->height);
             imagejpeg($newimg,$this->dstimg, 100);
          }
       }
        if($this->type=="png"){
            imagealphablending($this->dstimg,false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
            imagesavealpha($this->dstimg,true);//这里很重要,意思是不要丢了$thumb图像的透明色;
            imagepng($newimg,$this->dstimg);
        }
    }
    //初始化图象
    private function initi_img() {
       if($this->type=="jpg" || $this->type=="jpeg"){
          $this->im = imagecreatefromjpeg($this->srcimg);
       }elseif($this->type=="gif"){
          $this->im = imagecreatefromgif($this->srcimg);
       }elseif($this->type=="png"){
          $this->im = imagecreatefrompng($this->srcimg);
       }
    }
    //图象目标地址
    private function dst_img($dstpath){
       $full_length = strlen($this->srcimg);
       $type_length = strlen($this->type);
       $name_length = $full_length-$type_length;
       $name = substr($this->srcimg,0,$name_length-1);
       $this->dstimg = $dstpath;
    }
    /***************************水印处理*************************/
    /*
    * 功能：PHP图片水印 (水印支持图片或文字)
    * 参数：
    *$groundImage 背景图片，即需要加水印的图片，暂只支持GIF,JPG,PNG格式；
    *$waterPos水印位置，有10种状态，0为随机位置；
    *1为顶端居左，2为顶端居中，3为顶端居右；
    *4为中部居左，5为中部居中，6为中部居右；
    *7为底端居左，8为底端居中，9为底端居右；
    *$waterImage图片水印，即作为水印的图片，暂只支持GIF,JPG,PNG格式；
    *$waterText文字水印，即把文字作为为水印，支持ASCII码，不支持中文；
    *$textFont文字大小，值为1、2、3、4或5，默认为5；
    *$textColor文字颜色，值为十六进制颜色值，默认为#FF0000(红色)；
    *
    * 注意：Support GD 2.0，Support FreeType、GIF Read、GIF Create、JPG 、PNG
    *$waterImage 和 $waterText 最好不要同时使用，选其中之一即可，优先使用 $waterImage。
    *当$waterImage有效时，参数$waterString、$stringFont、$stringColor均不生效。
    *加水印后的图片的文件名和 $groundImage 一样。
    * 作者：longware @ 2004-11-3 14:15:13
    */
    public function imageWaterMark($groundImage,$waterPos=9,$waterImage='',$waterText='',$textFont=5,$textColor='#FF0000'){
        $isWaterImage = FALSE;
        $formatMsg = "暂不支持该文件格式，请用图片处理软件将图片转换为GIF、JPG、PNG格式。";
        //读取水印文件
        $waterImage=$_SERVER['DOCUMENT_ROOT'].$waterImage;
        if(!empty($waterImage) && file_exists($waterImage)){
            $isWaterImage = TRUE;
            $water_info = getimagesize($waterImage);
            $water_w = $water_info[0];//取得水印图片的宽
            $water_h = $water_info[1];//取得水印图片的高 
            //取得水印图片的格式
            $imgTypeCheck=true;
            switch($water_info[2]){
                case 1:$water_im = imagecreatefromgif($waterImage);break;
                case 2:$water_im = imagecreatefromjpeg($waterImage);break;
                case 3:$water_im = imagecreatefrompng($waterImage);break;
                default:$imgTypeCheck=false;
            }
            if(!$imgTypeCheck)$this->error=array('error'=>1,'html'=>$formatMsg);return false;
        }
        //读取背景图片
        if(!empty($groundImage) && file_exists($groundImage)){
            $ground_info = getimagesize($groundImage);
            $ground_w = $ground_info[0];//取得背景图片的
            $ground_h = $ground_info[1];//取得背景图片的高
            //取得背景图片的格式
            $imgTypeCheck=true;
            switch($ground_info[2]){
                case 1:$ground_im = imagecreatefromgif($groundImage);break;
                case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
                case 3:$ground_im = imagecreatefrompng($groundImage);break;
                default:$imgTypeCheck=false;
            }
            if(!$imgTypeCheck)$this->error=array('error'=>1,'html'=>$formatMsg);return false;
        }else{
            $this->error=array('error'=>1,'html'=>'需要加水印的图片不存在！');return false;
        }
        //水印位置
        if($isWaterImage){//图片水印
            $w = $water_w;$h = $water_h;$label = "图片的";
        }else{//文字水印
            $temp = imagettfbbox(ceil($textFont*5),0,"./cour.ttf",$waterText);//取得使用 TrueType 字体的文本的范围
            $w = $temp[2] - $temp[6];$h = $temp[3] - $temp[7];
            unset($temp);
            $this->error=array('error'=>1,'html'=>'文字区域');return false;
        }
        if( ($ground_w<$w) || ($ground_h<$h) ){
                $this->error=array('error'=>1,'html'=>'需要加水印的图片的长度或宽度比水印'.$label.'还小，无法生成水印！');return false;
        }
        switch($waterPos){
            case 0://随机
                $posX = rand(0,($ground_w - $w));
                $posY = rand(0,($ground_h - $h));
                break;
            case 1://1为顶端居左
                $posX = 0;$posY = 0;break;
            case 2://2为顶端居中
                $posX = ($ground_w - $w) / 2;$posY = 0;break;
            case 3://3为顶端居右
                $posX = $ground_w - $w;$posY = 0;break;
            case 4://4为中部居左
                $posX = 0;$posY = ($ground_h - $h) / 2;break;
            case 5://5为中部居中
                $posX = ($ground_w - $w) / 2;$posY = ($ground_h - $h) / 2;break;
            case 6://6为中部居右
                $posX = $ground_w - $w;$posY = ($ground_h - $h) / 2;break;
            case 7://7为底端居左
                $posX = 0;$posY = $ground_h - $h;break;
            case 8://8为底端居中
                $posX = ($ground_w - $w) / 2;$posY = $ground_h - $h;break;
            case 9://9为底端居右posX-10 是距离右侧10px 可以自己调节posY-10 是距离底部10px 可以自己调节
                $posX = $ground_w - $w - 10;$posY = $ground_h - $h - 10;break;
            default://随机
                $posX = rand(0,($ground_w - $w));$posY = rand(0,($ground_h - $h));break;
        }
        //设定图像的混色模式
        imagealphablending($ground_im, true);
        //图片水印
        if($isWaterImage){
            imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);//拷贝水印到目标文件 
        }else{////文字水印
            if( !emptyempty($textColor) && (strlen($textColor)==7) ){
                $R = hexdec(substr($textColor,1,2));$G = hexdec(substr($textColor,3,2));$B = hexdec(substr($textColor,5));
            }else{
                $this->error=array('error'=>1,'html'=>'水印文字颜色格式不正确！');return false;
            }
            imagestring ( $ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B)); 
        }
        //生成水印后的图片
        @unlink($groundImage);
        //取得背景图片的格式
        $imgTypeCheck=true;
        switch($ground_info[2]){
            case 1:imagegif($ground_im,$groundImage);break;
            case 2:imagejpeg($ground_im,$groundImage);break;
            case 3:imagepng($ground_im,$groundImage);break;
            default:$imgTypeCheck=false;
        }
        if(!$imgTypeCheck)$this->error=array('error'=>1,'html'=>$errorMsg);return false;
        //释放内存
        if(isset($water_info)) unset($water_info);
        if(isset($water_im)) imagedestroy($water_im);
        unset($ground_info);
        imagedestroy($ground_im);
    }
}
$api=new fileClass($api);