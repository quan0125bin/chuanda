<?php
	include_once("Smarty.class.php");
	$tpl=new Smarty;
	$tpl->template_dir=DIR."/tpl";
	$tpl->compile_dir=dirname(__FILE__)."/out";
	$tpl->left_delimiter="<{";
	$tpl->right_delimiter="}>";
	$tpl->assign('menuType',$api->strJsonToArr(MenuType));
	
	/****************设置页面有效性**************************/
	$signRand=$api->strGetSession('signRand')?$api->strGetSession('signRand'):$api->getRandStr(true);
     $api->strSetSession('signRand',$signRand);
	$sign=$api->strArrToJson(array('s'=>rand(0,100),'signRand'=>$signRand,'time'=>time(),'e'=>rand(0,1000)),true);
	$sign=$api->endes3($sign);
	$tpl->assign('sign',$sign);
	/*********************************************************/
?>