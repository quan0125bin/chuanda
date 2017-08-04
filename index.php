<?php
require('showData/header.php');

/**banner********************/
$banner=$api->sel(DbPrefix.'image','where pid=\'banner\' and chk=1 order by rank desc,id desc limit 10');
$banner=$api->strTitleSub($banner);
$tpl->assign('banner',$banner);
foreach($pro as $k=>$v){
    $pro[$k]['_name']=explode('|',$v['name']);
}
$tpl->assign('pro',$pro);

$about=$api->sel(DbPrefix.'image','where pid=\'about\' and chk=1 order by rank desc,id desc limit 1');
if($about){
    $about=$api->strTitleSub($about);
    $about=$about[0];$about['_name']=explode('|',$about['name']);
}
$tpl->assign('about',$about);

$new=$api->sel(DbPrefix.'menu','where id=99','id,name,nname,url',true);
if($new){
    $new['url']=$api->strGetUrl($new['url']);
    $news=$api->sel(DbPrefix.'info','where pid in(select id from '.DbPrefix.'menu where pid='.$new['id'].' and chk=1) and chk=1 and hchk=1 order by rank desc,id desc limit 4');
    $news=$api->strTitleSub($news,15,20,$new['url']);
    $tpl->assign('new',$new);
    $tpl->assign('news',$news);
}
$pro=$api->sel(DbPrefix.'menu','where id=101','id,name,nname,url',true);
if($pro){
    $pro['url']=$api->strGetUrl($pro['url']);
    $pros=$api->sel(DbPrefix.'info','where pid in(select id from '.DbPrefix.'menu where pid='.$pro['id'].' and chk=1) and chk=1 and hchk=1 order by rank desc,id desc limit 12');
    $pros=$api->strTitleSub($pros,15,20,$pro['url']);
    $tpl->assign('pro',$pro);
    $tpl->assign('pros',$pros);
}

$tpl->display($webTpl.'index.html');