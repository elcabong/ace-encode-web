<?php
		$foldernames = scandir($autorip);

		//
		// when done encoding remove old .mkv and remove .encoded from final .mkv

		
		//
		// rename known folders and files if done ripping but not currently encoding.
		foreach($foldernames as $thefolder) {
			if($thefolder == "." || $thefolder == ".." || $thefolder == "" || $thefolder == "logs" || $thefolder == "Music") { continue; }
			$folderpath = $autorip . "/$thefolder";
			$subfolders = scandir($folderpath);
			foreach($subfolders as $thesubfolder) {
				if($thesubfolder == "." || $thesubfolder == ".." || $thesubfolder == "") { continue; }
				if(!file_exists("$autorip/$thefolder/$thesubfolder/rip.completed")) { continue; }
				if(file_exists("$autorip/$thefolder/$thesubfolder/encoding")) { continue; }
				$identitycheck = "$autorip/$thefolder/$thesubfolder/*.identity";
				if (count(glob($identitycheck)) == 0) { continue; }
				$files = glob($identitycheck);
				foreach($files as $file) {
					$file = substr($file, strrpos($file, "/") + 1);
					//echo $file."<br>";
					$thisnewfile = str_replace(".identity","",$file);
					//echo $thisnewfile."<br>";
				}
				// rename files and folder
				$files = glob("$autorip/$thefolder/$thesubfolder/*.{mkv,srt}", GLOB_BRACE);
				$filenum = 0;
				foreach($files as $file) {
					$filenum++;
					$file = substr($file, strrpos($file, "/") + 1);
					//echo $file."<br>";
					$newfile = str_replace("$thesubfolder","$thisnewfile",$file);
					//echo $newfile."<br>";
					rename("$autorip/$thefolder/$thesubfolder/$file","$autorip/$thefolder/$thesubfolder/$newfile"); 
				 }
				 if($filenum == 1) {
					if(file_exists("$autorip/$thefolder/$thesubfolder/$file")){
						rename("$autorip/$thefolder/$thesubfolder/$file","$autorip/$thefolder/$thesubfolder/$thisnewfile.mkv"); 
					}
				 }
				 //  if only 1 .mkv then rename file to $thisnewfile
				 
				 
				if($thisnewfile == $thesubfolder) {continue;}
				rename("$autorip/$thefolder/$thesubfolder/","$autorip/$thefolder/$thisnewfile/");
			}
		}
		
		
		
		//
		//  remove temp files and move to blackhole directory
/*		
		foreach($foldernames as $thefolder) {
			if($thefolder == "." || $thefolder == ".." || $thefolder == "" || $thefolder == "logs" || $thefolder == "Music") { continue; }
			$folderpath = $autorip . "/$thefolder";
			$subfolders = scandir($folderpath);
			foreach($subfolders as $thesubfolder) {
				if($thesubfolder == "." || $thesubfolder == ".." || $thesubfolder == "") { continue; }
				if(!file_exists("$autorip/$thefolder/$thesubfolder/rip.completed")) { continue; }
				if(file_exists("$autorip/$thefolder/$thesubfolder/encoding")) { continue; }
				if(!file_exists("$autorip/$thefolder/$thesubfolder/no.encoding")) { continue; }

				//remove temp files and move folder to blackhole
			}
		}
*/				
		
?>