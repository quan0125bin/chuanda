<?php
define("DIR",$_SERVER['DOCUMENT_ROOT']);
require(DIR.'/config/index.php');
require(DIR.'/interface/smarty/config.php');
$tpl->display('admin/index.html');
















