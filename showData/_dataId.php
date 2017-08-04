<?php
if($_GET['id']){
	$data=$api->sel($dbname,$where.' and id='.$_GET['id'],$need,true);
	if(!$data){
		echo '<script type="text/javascript">alert("数据不存在");window.history.go(-1);</script>';exit;
	}
	if($data['url']){
		header('location:'.$data['url']);exit;
	}
	if($_COOKIE['view']){
		$view=explode(',',$_COOKIE['view']);
	}
	if(!$view || !in_array($data['id'],$view)){
		$res=$api->update($dbname,array('view'=>$data['view']+1),$where.' and id='.$data['id']);
		if($res){
			$view=$_COOKIE['view']?','.$data['id']:$data['id'];
			setcookie('view',$view,time()+60,'/');
		}
	}
	if($dq_menu['type']==22 && is_numeric($data['come'])){
	   $come=$api->sel(DbPrefix.'image','where pid=\'qk\' and id='.$data['come'].' and chk=1','name',true);
	   $data['comeId']=$data['come'];
	   $data['come']=$come['name'];
	}
	if($data['cont'])$data['cont']=$api->strHandleRestore($data['cont']);
	if($data['cont_c'])$data['cont_c']=$api->strHandleRestore($data['cont_c']);
	if($data['cont_y'])$data['cont_y']=$api->strHandleRestore($data['cont_y']);
	if($data['video']){$data['video']=$api->strImgShow($api->strJsonToArr($data['video']));}
	if($data['image']){$data['image']=$api->strImgShow($api->strJsonToArr($data['image']));}
	if($data['banner']){$data['banner']=$api->strImgShow($api->strJsonToArr($data['banner']));}
	if($data['stime'])$data['_time']=date('Y-m-d',$data['stime']);
	$tpl->assign('data',$data);
	
	
	/**************************************/
	$up=$api->sel($dbname,'where id>'.$_GET['id'].' and pid='.$data['pid'].' and chk=1 order by rank,id limit 1',$need,true);
	$down=$api->sel($dbname,'where id<'.$_GET['id'].' and pid='.$data['pid'].' and chk=1 order by rank desc,id desc limit 1',$need,true);
	$detailArr=array($up,$down);
	$detailArr=$api->strTitleSub($detailArr,15,0,$filename);
	$tpl->assign('detailArr',$detailArr);
	/**************************************/
	   $tpl->display($webTpl.'detail.html');exit;
	if($dq_menu['type']==20){
	   $right=$api->sel($dbname,'where id<>'.$_GET['id'].' and pid='.$data['pid'].' and chk=1 order by rank desc,id desc  limit 4',$need);
	    $right=$api->strTitleSub($right,15,0,$filename);
	    $tpl->assign('right',$right);
        $dq_p_menu=$api->sel(DbPrefix.'menu','where id in(select pid from '.DbPrefix.'menu where id='.$dq_menu['pid'].')',$menuNeed,true);
	   if($dq_p_menu['img']){
		  $dq_p_menu['img_json']=$api->strJsonToArr($dq_p_menu['img']);
		  if(!$dq_p_menu['img_json']){
			 $dq_p_menu['img_json']=$api->strJsonToArr($api->strHandleRestore($dq_p_menu['img']));
		  }
		  $dq_menu['img_json']=$api->strImgShow($dq_p_menu['img_json']);
	   }
	   $tpl->assign('dq_menu',$dq_menu);
	   $tpl->display($webTpl.'detailPro.html');
	 }else{
	 }
	exit;
}