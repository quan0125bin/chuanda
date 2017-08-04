<?php
/**调用模版*****************************/
if($dq_menu){
    switch($dq_menu['type']) {
	   case 21:
		if($_POST['page'])
		$tpl->display($webTpl.'proData.html');
		else
		  $tpl->display($webTpl.'pro.html');
	   break;//新闻
	   case 10:
		if($_POST['page'])
		$tpl->display($webTpl.'newsData.html');
		else
		$tpl->display($webTpl.'news.html');
	   break;//新闻
	   case 20:
		if($_POST['page'])
		$tpl->display($webTpl.'imageData.html');
		else
		$tpl->display($webTpl.'image.html');
        break;//新闻
	   case 30:$tpl->display($webTpl.'ones.html');break;//新闻
	   case 31:$tpl->display($webTpl.'contact.html');break;//新闻
	   case 32:
		if($_POST['page'])
		$tpl->display($webTpl.'hiringData.html');
		else
	   $tpl->display($webTpl.'hiring.html');
	   break;//新闻
	   default:echo $dq_menu['type'].'__';;
    }
}else{
    $tpl->display($webTpl.'error.html');
}