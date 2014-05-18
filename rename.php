<?php
	if(!empty($_GET['folder'])) {
		$thefolder = $_GET['folder'];
	}
	if(!empty($_GET['title'])) {
		$thetitle = $_GET['title'];
	}
	if(!empty($_GET['dir'])) {
		$thedir = $_GET['dir'];
	}

require "config.php";
/*
//$files = scandir("$autorip/$thefolder/");
$files = glob("$autorip/$thedir/$thefolder/*.{mkv,srt}", GLOB_BRACE);
foreach($files as $file) {
	$file = substr($file, strrpos($file, "/") + 1);
	//echo $file."<br>";
	$newfile = str_replace("$thefolder","$thetitle",$file);
	//echo $newfile."<br>";
 rename("$autorip/$thedir/$thefolder/$file","$autorip/$thedir/$thefolder/$newfile"); 
 }

rename("$autorip/$thedir/$thefolder/","$autorip/$thedir/$thetitle/");
*/
$newFileName = "$autorip/$thedir/$thefolder/$thetitle.identity";
$newFileHandle = fopen($newFileName, 'w') or die("can't open file");
fclose($newFileHandle);
chmod($newFileName, 0777); 

exit;
?>