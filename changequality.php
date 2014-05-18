<?php
	if(!empty($_GET['option'])) {
		$option = $_GET['option'];
	}
	if(!empty($_GET['dir'])) {
		$thedir = $_GET['dir'];
	}	
	if(!empty($_GET['title'])) {
		$thetitle = $_GET['title'];
	}

	
	
	
require "config.php";

$encodingcheck = "$autorip/$thedir/$thetitle/*.encoding";
if (count(glob($encodingcheck)) > 0) {
	array_map('unlink', glob( "$autorip/$thedir/$thetitle/*.encoding"));
}

if($option != "default") {
	$newFileName = "$autorip/$thedir/$thetitle/$option.encoding";
	$newFileHandle = fopen($newFileName, 'w') or die("can't open file");
	fclose($newFileHandle);
}
	
	/*
if($option = "none") {
	$newFileName = "$autorip/$title/$title.ready";
	$newFileHandle = fopen($newFileName, 'w') or die("can't open file");
	fclose($newFileHandle);
}
*/
?>