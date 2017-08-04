<?php
//定时自动处理类
require('class/dataClass.class.php');
class code extends dataClass{
    public $err=array('error'=>0,'html'=>'操作成功');
    function __construct(){
        parent::__construct();
        /**检查加密数据**/
        $this->data=$this->getData($_POST);
    }
    public function startCode(){
	 //创建图像资源
	   $img=imagecreatetruecolor(120,30);
	 //设置背景色:随机
	   $back=imagecolorallocate($img,rand(225,255),rand(225,255),rand(225,255));
	 //为背景填充颜色
	   imagefill($img,0,0,$back);
	   $this->setGanrao($img);
	   $st=$this->getRandStr(true);
	   $this->strSetSession('code',$st);
	   imagechar($img,rand(5,10),3*(1*3),rand(0,8),$st[0],$this->setFontColor($img));
	   imagechar($img,rand(5,10),3*(2*4),rand(0,8),$st[1],$this->setFontColor($img));
	   imagechar($img,rand(5,10),3*(3*5),rand(0,8),$st[2],$this->setFontColor($img));
	   imagechar($img,rand(5,10),3*(4*6),rand(0,8),$st[3],$this->setFontColor($img));
	   imagechar($img,rand(5,10),3*(5*6),rand(0,8),$st[4],$this->setFontColor($img));
	   imagechar($img,rand(5,10),3*(6*6),rand(0,8),$st[5],$this->setFontColor($img));
	   header("Content-Type:image/gif");
	   imagepng($img);
    }
    //设置字体颜色
    private function setFontColor($img){
	   return imagecolorallocate($img,rand(0,180),rand(0,180),rand(0,180));
    }
    //设置干扰图片
    private function setGanrao($img){
        for($i=0;$i<1000;$i++){
            $dian=imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255));
            imagesetpixel($img,rand(1,120-2),rand(1,120-2),$dian);
        }
        return $img;
    }
}