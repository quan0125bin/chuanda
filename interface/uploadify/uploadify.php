<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/upload/video/'; // Relative to the root
if($_POST['way']=='image'){
    $targetFolder='/upload/';
}
$verifyToken = md5('unique_salt' . $_POST['timestamp']);
//if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	/***/
	$name=explode('.',$_FILES['Filedata']['name']);
	$na=$name[count($name)-1];
	$name=date('ymdhis').rand(100,999).'.'.$na;
	/***/
	$targetFile = rtrim($targetPath,'/') . '/' . $name;
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png','flv','mp4'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		if($_POST['way']=='image'){
            echo $name;
		}else{
            echo $targetFolder.$name;
		}
	} else {
		echo 'Invalid file type.';
	}
}
?>