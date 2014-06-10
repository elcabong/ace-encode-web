<?php
		$foldernames = scandir($autorip);
		
		
		// check if multiple videos exists and place/remove hold
		foreach($foldernames as $thefolder) {
			if($thefolder == "." || $thefolder == ".." || $thefolder == "" || $thefolder == "logs" || $thefolder == "Music") { continue; }
			$folderpath = $autorip . "/$thefolder";
			$subfolders = scandir($folderpath);
			foreach($subfolders as $thesubfolder) {
				if($thesubfolder == "." || $thesubfolder == ".." || $thesubfolder == "") { continue; }
				if(!file_exists("$autorip/$thefolder/$thesubfolder/rip.completed")) {
					if(file_exists("$autorip/$thefolder/$thesubfolder/rip.completed.hold")) {
						$moviecount = "$autorip/$thefolder/$thesubfolder/*.mkv";
						if (count(glob($moviecount)) == 1) { 
							rename("$autorip/$thefolder/$thesubfolder/rip.completed.hold","$autorip/$thefolder/$thesubfolder/rip.completed");
						}
					}
					continue; 
				}
				$moviecount = "$autorip/$thefolder/$thesubfolder/*.mkv";
				if (count(glob($moviecount)) < 2) { continue; }
				rename("$autorip/$thefolder/$thesubfolder/rip.completed","$autorip/$thefolder/$thesubfolder/rip.completed.hold");
			
			}
		}


		
		//
		
		//  this needs to only fire after encoding, or if no.encoding is present
		//  can probably lump move command into this as well since the other functions will be completed by now
		
		// rename known folders and files if done ripping but not currently encoding.
		foreach($foldernames as $thefolder) {
			if($thefolder == "." || $thefolder == ".." || $thefolder == "" || $thefolder == "logs" || $thefolder == "Music") { continue; }
			$folderpath = $autorip . "/$thefolder";
			$subfolders = scandir($folderpath);
			foreach($subfolders as $thesubfolder) {
				if($thesubfolder == "." || $thesubfolder == ".." || $thesubfolder == "") { continue; }
				if(!file_exists("$autorip/$thefolder/$thesubfolder/rip.completed")) { continue; }
				if(file_exists("$autorip/$thefolder/$thesubfolder/encoding")) { continue; }
				$encodedcheck = "$autorip/$thefolder/$thesubfolder/*.encoded";
				if (count(glob($encodedcheck)) == 0 && !file_exists("$autorip/$thefolder/$thesubfolder/no.encoding")) { continue; }
				$identitycheck = "$autorip/$thefolder/$thesubfolder/*.identity";
				if (count(glob($identitycheck)) == 0) { continue; }
				$files = glob($identitycheck);
				foreach($files as $file) {
					$file = substr($file, strrpos($file, "/") + 1);
					//echo $file."<br>";
					$thisnewfile = str_replace(".identity","",$file);
					//echo $thisnewfile."<br>";
				}
				
				
				
				
				
				
				// remove all temp files and if .encoded file exists, remove .mkv and remove .encoded from new file.
				
				
				
				
				
				
				// rename files and folder
				$files = glob("$autorip/$thefolder/$thesubfolder/*.{mkv,srt}", GLOB_BRACE);
				$filenum = 0;
				foreach($files as $file) {
					$filenum++;
					$file = substr($file, strrpos($file, "/") + 1);
					//echo $file."<br>";
					$newfile = str_replace("$thesubfolder","$thisnewfile",$file);
					//echo $newfile."<br>";
					if("$autorip/$thefolder/$thesubfolder/$file" != "$autorip/$thefolder/$thesubfolder/$newfile") {
						rename("$autorip/$thefolder/$thesubfolder/$file","$autorip/$thefolder/$thesubfolder/$newfile"); 
					}
				}
				 
				if("$thisnewfile" != "$thesubfolder") {
					rename("$autorip/$thefolder/$thesubfolder/","$autorip/$thefolder/$thisnewfile/");
				}

				
				// move to blackhole/move directory
				switch($thefolder) {
					case BR:
						rename("$autorip/$thefolder/$thisnewfile/","$autorip/Blackhole/Movies/$thisnewfile/");
						break;
					case DVD:
						rename("$autorip/$thefolder/$thisnewfile/","$autorip/Blackhole/Movies/$thisnewfile/");
						break;
					case Music:
						rename("$autorip/$thefolder/$thisnewfile/","$autorip/Blackhole/Music/$thisnewfile/");
						break;
					case TV:
						rename("$autorip/$thefolder/$thisnewfile/","$autorip/Blackhole/TV/$thisnewfile/");
						break;			
				}
			}
		}	
?>