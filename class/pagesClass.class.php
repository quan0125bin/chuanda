<?php
class pagesClass{
    public $pages;//总页数
    public $page;//当前页数
    public $psize;//当前页数
    public $limit;//Limit
    function __construct($max,$page=false,$num=9){
     $this->pages=ceil($max/$num);
     $this->psize=$num;
     $this->page=$page;
   //  $this->limit=' limit '.($page*$num-$num).','.$num;
     
         $this->total = $max ? $max : 1;  
         $this->pagesize = $num;  
          $this->pagenum = ceil($this->total / $this->pagesize);  
         $this->page = $this->setPage($page);  
         $this->limit = "LIMIT ".($this->page-1)*$this->pagesize.",$this->pagesize";  
         $this->url = $this->setUrl();  
         $this->bothnum = $this->pagenum;  
     
     
    }
    public function out(){
	   $data=array('page'=>$this->page,'pages'=>$this->pages,'psize'=>$this->psize);
	   $data['up']=$this->prev();
	   $data['down']=$this->next();
	   $data['num']=$this->first().$this->pageList().$this->last();
	   return $data;
    }
    
    
    /*
      //拦截器  
      private function __get($_key) {  
         return $this->$_key;  
      }  
    */
      //获取当前页码  
      private function setPage($page) {
		if($page)return $page;
         if (!empty($_GET['page'])) {  
                if ($_GET['page'] > 0) {  
                   if ($_GET['page'] > $this->pagenum) { 
                          return false;
                   } else {  
                          return $_GET['page'];  
                   }  
                } else {  
                   return 1;  
                }  
         } else {  
                return 1;  
         }  
      }   
    
      //获取地址  
      private function setUrl() {  
         $_url = $_SERVER["REQUEST_URI"];  
         /*
         $_par = parse_url($_url);  
         if (isset($_par['query'])) {  
                parse_str($_par['query'],$_query);  
                unset($_query['page']);  
                $_url = $_par['path'].'?'.http_build_query($_query);  
         }  
         if($_url==$_SERVER['PHP_SELF']){$_url.='?';}
         print_r($_SERVER);*/
         $url=preg_replace('/&page=[0-9]+/','',$_url);
         $url=$url?(strpos($url,'?')>0?'':'?').$url:'?';
         return $url;  
      }     //数字目录  
      private function pageList() {  
         for ($i=$this->bothnum;$i>=1;$i--) {  
            $_page = $this->page-$i;  
            if ($_page < 1) continue;  
                $_pagelist .= '<a href="'.$this->url.'&page='.$_page.'">'.$_page.'</a>';  
         }  
         $_pagelist .= '<a href="javascript:" class="on">'.$this->page.'</a>';  
         for ($i=1;$i<=$this->bothnum;$i++) {  
            $_page = $this->page+$i;  
                if ($_page > $this->pagenum) break;  
                $_pagelist .= '<a href="'.$this->url.'&page='.$_page.'">'.$_page.'</a>';  
         }  
         return $_pagelist;  
      }  
    
      //首页  
      private function first() {  
         if ($this->page > $this->bothnum+1) {  
                return '<a href="'.$this->url.'">1</a><a href="javascript:">...</a>';  
         }  
      }  
    
      //上一页  
      private function prev() {  
         if ($this->page == 1) {  
                return '<a href="javascript:" class="lef-d"><</a>';  
         }  
         return '<a href="'.$this->url.'&page='.($this->page-1).'" class="lef-d"><</a>';  
      }  
    
      //下一页  
      private function next() {  
         if ($this->page == $this->pagenum) {  
                return '<a href="javascript:" class="rig-d">></a>';  
         }  
         return '<a href="'.$this->url.'&page='.($this->page+1).'" class="rig-d">></a>';  
      }  
    
      //尾页  
      private function last() { 
         if ($this->pagenum - $this->page > $this->bothnum) {  
                return '<a href="javascript:">...</a><a href="'.$this->url.'&page='.$this->pagenum.'">'.$this->pagenum.'</a>';  
         }  
      }  
    
      //分页信息  
      public function showpage() {  
         $_page .= $this->first();  
         $_page .= $this->pageList();  
         $_page .= $this->last();  
         $_page .= $this->prev();  
         $_page .= $this->next();  
         return $_page;  
      }  
    
}