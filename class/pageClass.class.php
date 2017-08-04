<?php
class pageClass{
    public $pages;//总页数
    public $page;//当前页数
    public $psize;//当前页数
    public $limit;//Limit
    function __construct($max,$page=1,$num=10){
     $this->pages=ceil($max/$num);
     $this->psize=$num;
     $this->page=$page;
     $this->limit=' limit '.($page*$num-$num).','.$num;
    }
    public function out(){
	   $data=array('page'=>$this->page,'pages'=>$this->pages,'psize'=>$this->psize);
	   return $data;
    }
}