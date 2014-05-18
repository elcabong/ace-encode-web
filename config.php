<?php
// the title displayed on the web interface
$programtitle = "DiskRipper";


//default options to execute automatically after identified

//default encoding for 




// change $path to represent the base directory where the disks are ripped to.
$path = './data/Ripping';
$found = false;
while(!$found){
	if(file_exists($path)){ 
		$found = true;
		$autorip = $path;
	}
	else{ $path= '../'.$path; }
}



//functions
/*











function moveEncodedMovie($thedir,$theorigtitle,$thenewtitle) {
	$files = glob("$autorip/$thedir/$theorigtitle/*.encoded");
	foreach($files as $file) {
		$file = substr($file, strrpos($file, "/") + 1);
		echo $file."<br>";
		//$newfile = str_replace("$thefolder","$thetitle",$file);
		//echo $newfile."<br>";
	 //rename("$autorip/$thedir/$thefolder/$file","$autorip/$thedir/$thefolder/$newfile"); 
	}
}
*/

/*


	rename("$autorip/$thedir/$theorigtitle/$theorigtitle","$autorip/$thedir/$thefolder/$newfile"); 



	move file (renaming to identity) to blackhole directory 
	remove old folder in ripping directory
}
*/


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


















?>