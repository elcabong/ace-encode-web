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
function clean($string) {
   //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9 _\-]/', '', $string); // Removes special chars.
}
?>