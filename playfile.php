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
$FileName = "./$thedir/$thefolder/$thetitle.mkv";
print_r(stat("$FileName"));
?>
<html>
<video width="320" height="240" controls="controls">
<source src="<?=$FileName;?>" type="video/x-matroska">
Your browser does not support the video tag.
</video>
</html>