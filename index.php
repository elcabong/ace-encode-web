<?php
require "config.php";
require "functions.php";
if(!empty($_GET['automated'])) {
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $programtitle; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="height:device-height, width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, target-densitydpi=medium-dpi, user-scalable=no" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />
  <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
  <script type="text/javascript" src="./js/jquery1.9.1.min.js"></script>
  	<script type="text/javascript" src="./js/ifvisible.js"></script>
  <?php //<script type="text/javascript" src="./js/jquery.confirmon.js"></script>?>
  <script type="text/javascript">
		if (window.navigator.standalone) {
			var a=document.getElementsByTagName("a");
			for(var i=0;i<a.length;i++) {
				if(!a[i].onclick && a[i].getAttribute("target") != "_blank") {
					a[i].onclick=function() {
							window.location=this.getAttribute("href");
							return false; 
					}
				}
			}
		}
	</script>  
</head>
<body>
	<ul class="links" style="float:left;padding: 50px 0 20px;">
	<li class='title'><h2><span class='label'><b><?php echo $programtitle; ?></b></span></h2></li>
	<?php
		$foldernames = scandir($autorip);	

		
		// check if multiple videos exists and place hold
		$heldmovies = 0;
		foreach($foldernames as $thefolder) {
			if($thefolder == "." || $thefolder == ".." || $thefolder == "" || $thefolder == "logs" || $thefolder == "Music") { continue; }
			$folderpath = $autorip . "/$thefolder";
			$subfolders = scandir($folderpath);
			foreach($subfolders as $thesubfolder) {
				if($thesubfolder == "." || $thesubfolder == ".." || $thesubfolder == "") { continue; }
				if(!file_exists("$autorip/$thefolder/$thesubfolder/rip.completed.hold")) { continue; }
				$moviecount = "$autorip/$thefolder/$thesubfolder/*.mkv";
				if (count(glob($moviecount)) < 2) { continue; }
				$heldmovies++;
				if($heldmovies == 1) {
					echo "<li class='title'><span class='label'><b>Multiple Video Files Found:</b></span></li>";
				}		
				$fullpath = "$autorip/$thefolder/$thesubfolder";
				echo "<li><span class='label'>$thefolder/$thesubfolder</span>";
				$files = glob("$fullpath/*.mkv");
				foreach($files as $file) {
					$file = substr($file, strrpos($file, "/") + 1);
				 echo "<a href='$fullpath/$file' target='_blank' class='log-file'>$file</a>";
				 }		
				echo "</li>";

			
			}
		}		
		
		
		
		
		$ripping = 0;
		foreach($foldernames as $thefolder) {
			if($thefolder == "." || $thefolder == ".." || $thefolder == "" || $thefolder == "logs" || $thefolder == "Music" || $thefolder == "Blackhole") { continue; }
			$folderpath = $autorip . "/$thefolder";
			$subfolders = scandir($folderpath);
			foreach($subfolders as $thesubfolder) {
				if($thesubfolder == "." || $thesubfolder == ".." || $thesubfolder == "") { continue; }
				if(file_exists("$autorip/$thefolder/$thesubfolder/rip.completed.hold")) { continue; }
				if(file_exists("$autorip/$thefolder/$thesubfolder/rip.completed")) { continue; }
				$hasIdentity = 0;
				$identitycheck = "$autorip/$thefolder/$thesubfolder/*.identity";
				if (count(glob($identitycheck)) > 0) { $hasIdentity = 1; }	
				$ripping++;
				if($ripping == 1) {
					echo "<li class='title'><span class='label'><b>Currently Ripping:</b></span></li>";
				}
				$thesubfolder = clean("$thesubfolder");
				if($hasIdentity == 0) {
					echo "<li><span class='label'>$thefolder/$thesubfolder</span>";
				} else {
					foreach(glob($identitycheck) as $file) {
						$file = substr($file, strrpos($file, "/") + 1);
						$file = str_replace(".identity","",$file);
					 }
					echo "<li><span class='label'>$thefolder/$file</span>";				
				}
				echo "<img src='./img/loading.gif' />";
				if($hasIdentity == 0) {
					echo "<a href='#' onclick='showpossibles(\"$thefolder\",\"$thesubfolder\");' class='on-off-toggle'>Identify</a><img src='./img/loading.gif' style='display:none;' />";
				} else {
						echo "<img src='./img/green-tick.png' title='Identified'/>";
				}				
				$hasEncoding = 0;
				$encodingcheck = "$autorip/$thefolder/$thesubfolder/*.encoding";
				if (count(glob($encodingcheck)) > 0) { $hasEncoding = 1; }
				echo "<select name='encoding-ripping-$ripping' id='encoding-ripping-$ripping' size='1' onchange='changequality(this,\"$thefolder\",\"$thesubfolder\");'>";
				if($hasEncoding == 1) {
					foreach(glob($encodingcheck) as $file) {
						$file = substr($file, strrpos($file, "/") + 1);
						$file = str_replace(".encoding","",$file);
					 }
					echo "<option>$file Encoding</option>";
				}
				echo"<option value='default'>Default Encoding</option>
					<option value='no'>No Encoding</option>
					 <option value='1080H'>1080 High</option>
					 <option value='1080L'>1080 Low</option>
					 <option value='720H'>720 High</option>
					 <option value='720L'>720 Low</option>
					 </select>";
				echo "</li>";
			}
		}

		$needsprocess = 0;
		foreach($foldernames as $thefolder) {
			if($thefolder == "." || $thefolder == ".." || $thefolder == "" || $thefolder == "logs" || $thefolder == "Music" || $thefolder == "Blackhole") { continue; }
			$folderpath = $autorip . "/$thefolder";
			$subfolders = scandir($folderpath);
			foreach($subfolders as $thesubfolder) {
				if($thesubfolder == "." || $thesubfolder == ".." || $thesubfolder == "") { continue; }
				if(file_exists("$autorip/$thefolder/$thesubfolder/rip.completed.hold")) { continue; }				
				if(!file_exists("$autorip/$thefolder/$thesubfolder/rip.completed")) { continue; }
				if(file_exists("$autorip/$thefolder/$thesubfolder/encoding")) { continue; }
				$hasIdentity = 0;
				$identitycheck = "$autorip/$thefolder/$thesubfolder/*.identity";
				if (count(glob($identitycheck)) > 0) { continue; }
				$needsprocess++;
				if($needsprocess == 1) { 
					echo "<li class='title'><span class='label'><b>Need to Be Identified:</b></span></li>";
				}
				$thesubfolder = clean("$thesubfolder");
				if($hasIdentity == 0) {
					echo "<li><span class='label'>$thefolder/$thesubfolder</span>";
				} else {
					foreach(glob($identitycheck) as $file) {
						$file = substr($file, strrpos($file, "/") + 1);
						$file = str_replace(".identity","",$file);
					 }
					echo "<li><span class='label'>$thefolder/$file</span>";				
				}
				if($hasIdentity == 0) {
					echo "<a href='#' onclick='showpossibles(\"$thefolder\",\"$thesubfolder\");' class='on-off-toggle'>Identify</a><img src='./img/loading.gif' style='display:none;' />";
				} else {
						echo "<img src='./img/green-tick.png' title='Identified'/>";
				}
				$hasEncoding = 0;
				$encodingcheck = "$autorip/$thefolder/$thesubfolder/*.encoding";
				if (count(glob($encodingcheck)) > 0) { $hasEncoding = 1; }
				echo "<select name='encoding-$ripping' id='encoding-$ripping' size='1' onchange='changequality(this,\"$thefolder\",\"$thesubfolder\");'>";
				if($hasEncoding == 1) {
					foreach(glob($encodingcheck) as $file) {
						$file = substr($file, strrpos($file, "/") + 1);
						$file = str_replace(".encoding","",$file);
					 }
					echo "<option>$file Encoding</option>";
				}
				echo"<option value='default'>Default Encoding</option>
					<option value='no'>No Encoding</option>
					 <option value='1080H'>1080 High</option>
					 <option value='1080L'>1080 Low</option>
					 <option value='720H'>720 High</option>
					 <option value='720L'>720 Low</option>
					 </select>";
				echo "</li>";
			}
		}



		$hasprocess = 0;
		foreach($foldernames as $thefolder) {
			if($thefolder == "." || $thefolder == ".." || $thefolder == "" || $thefolder == "logs" || $thefolder == "Music" || $thefolder == "Blackhole") { continue; }
			$folderpath = $autorip . "/$thefolder";
			$subfolders = scandir($folderpath);
			foreach($subfolders as $thesubfolder) {
				if($thesubfolder == "." || $thesubfolder == ".." || $thesubfolder == "") { continue; }
				if(file_exists("$autorip/$thefolder/$thesubfolder/rip.completed.hold")) { continue; }				
				if(!file_exists("$autorip/$thefolder/$thesubfolder/rip.completed")) { continue; }
				if(!file_exists("$autorip/$thefolder/$thesubfolder/encoding")) { continue; }
				$hasprocess++;
				if($hasprocess == 1) {
					echo "<li class='title'><span class='label'><b>Currently Encoding:</b></span></li>";
				}
				$hasIdentity = 0;
				$identitycheck = "$autorip/$thefolder/$thesubfolder/*.identity";
				if (count(glob($identitycheck)) > 0) { $hasIdentity = 1; }	
				foreach(glob($identitycheck) as $file) {
					$file = substr($file, strrpos($file, "/") + 1);
					$file = str_replace(".identity","",$file);
				 }
				 $thesubfolder = clean("$thesubfolder");
				if($hasIdentity == 0) {
					echo "<li><span class='label'>$thefolder/$thesubfolder</span>";
				} else {
					foreach(glob($identitycheck) as $file) {
						$file = substr($file, strrpos($file, "/") + 1);
						$file = str_replace(".identity","",$file);
					 }
					echo "<li><span class='label'>$thefolder/$file</span>";				
				}
				echo "<img src='./img/loading.gif' />";
				if($hasIdentity == 0) {
					echo "<a href='#' onclick='showpossibles(\"$thefolder\",\"$thesubfolder\");' class='on-off-toggle'>Identify</a><img src='./img/loading.gif' style='display:none;' />";
				} else {
						echo "<img src='./img/green-tick.png' title='Identified'/>";
				}				
				$hasEncoding = 0;
				$encodingcheck = "$autorip/$thefolder/$thesubfolder/*.encoding";
				if (count(glob($encodingcheck)) > 0) { $hasEncoding = 1; }
				echo "<select name='encoding-$ripping' size='1'>";
				if($hasEncoding == 1) {
					foreach(glob($encodingcheck) as $file) {
						$file = substr($file, strrpos($file, "/") + 1);
						$file = str_replace(".encoding","",$file);
					 }
					echo "<option>$file Encoding</option>";
				} else {
					echo "<option>Default Encoding</option>";
				}
				echo"</select>";
				
				echo "</li>";
			}
		}

	
		
		$waitingforencode = 0;
		foreach($foldernames as $thefolder) {
			if($thefolder == "." || $thefolder == ".." || $thefolder == "" || $thefolder == "logs" || $thefolder == "Music" || $thefolder == "Blackhole") { continue; }
			$folderpath = $autorip . "/$thefolder";
			$subfolders = scandir($folderpath);
			foreach($subfolders as $thesubfolder) {
				if($thesubfolder == "." || $thesubfolder == ".." || $thesubfolder == "") { continue; }
				if(file_exists("$autorip/$thefolder/$thesubfolder/rip.completed.hold")) { continue; }				
				if(!file_exists("$autorip/$thefolder/$thesubfolder/rip.completed")) { continue; }
				if(file_exists("$autorip/$thefolder/$thesubfolder/encoding")) { continue; }
				$identitycheck = "$autorip/$thefolder/$thesubfolder/*.identity";
				if (count(glob($identitycheck)) == 0) { continue; }
				foreach(glob($identitycheck) as $file) {
					$file = substr($file, strrpos($file, "/") + 1);
					$file = str_replace(".identity","",$file);
				 }					
				$waitingforencode++;
				if($waitingforencode == 1) {
					echo "<li class='title'><span class='label'><b>Waiting for Encoding:</b></span>";
					if($hasprocess == 0) {
						echo "<a href='#' onclick='ashowpossibles(\"$thefolder\",\"$thesubfolder\");' class='on-off-toggle'>Start DVD Encoding</a><a href='#' onclick='ashowpossibles(\"$thefolder\",\"$thesubfolder\");' class='on-off-toggle'>Start BR Encoding</a>";
						//echo "<li class='title'><span class='label'><b>start Encoding DVD:</b></span><span class='label'><b>start Encoding BR:</b></span></li>";
					}
					echo "</li>";
				}
				echo "<li><span class='label'>$thefolder/$file</span>";
				echo "<img src='./img/green-tick.png' title='Identified'/>";
				$hasEncoding = 0;
				$encodingcheck = "$autorip/$thefolder/$thesubfolder/*.encoding";
				if (count(glob($encodingcheck)) > 0) { $hasEncoding = 1; }
				echo "<select name='encoding-$ripping' id='encoding-$ripping' size='1' onchange='changequality(this,\"$thefolder\",\"$thesubfolder\");'>";
				if($hasEncoding == 1) {
					foreach(glob($encodingcheck) as $file) {
						$file = substr($file, strrpos($file, "/") + 1);
						$file = str_replace(".encoding","",$file);
					 }
					echo "<option>$file Encoding</option>";
				}
				echo"<option value='default'>Default Encoding</option>
					<option value='no'>No Encoding</option>
					 <option value='1080H'>1080 High</option>
					 <option value='1080L'>1080 Low</option>
					 <option value='720H'>720 High</option>
					 <option value='720L'>720 Low</option>
					 </select>";				
				
				echo "</li>";
			}	
		}

	
	/*
		$waitformove = 0;
		foreach($foldernames as $thefolder) {
			if($thefolder == "." || $thefolder == ".." || $thefolder == "") { continue; }
			if(!file_exists("$autorip/$thefolder/$thefolder.ready")) { continue; }
			$waitformove++;
			if($waitformove == 1) { echo "<li class='title'><span class='label'><b>Waiting to be Moved:</b></span></li>"; }			
			echo "<li><span class='label'>$thefolder</span><img src='./img/green-tick.png' title='ready'/></li>";
		}*/
		
		$musiccheck = 0;
		$folderpath = "$autorip/Music";
		$subfolders = scandir($folderpath);
		foreach($subfolders as $thesubfolder) {
			if($thesubfolder == "." || $thesubfolder == ".." || $thesubfolder == "") { continue; }
			$musiccheck++;
			if($musiccheck == 1) { 
				echo "<li class='title'><span class='label'><b>Music:</b></span></li>";
			}
			$newsubfolders = scandir("$folderpath/$thesubfolder");
			foreach($newsubfolders as $thealbum) {
				if($thealbum == "." || $thealbum == ".." || $thealbum == "") { continue; }
				echo "<li><span class='label'>$thesubfolder/$thealbum</span></li>";
			}
		}


		$blackholecheck = 0;
		$folderpath = "$autorip/Blackhole";
		$subfolders = scandir($folderpath);
		foreach($subfolders as $thesubfolder) {
			if($thesubfolder == "." || $thesubfolder == ".." || $thesubfolder == "") { continue; }
			$newsubfolders = scandir("$folderpath/$thesubfolder");
			foreach($newsubfolders as $abouttomove) {
				if($abouttomove == "." || $abouttomove == ".." || $abouttomove == "") { continue; }
				$blackholecheck++;
				if($blackholecheck == 1) {
					echo "<li class='title'><span class='label'><b>Blackhole Directory:</b></span></li>";
				}
				echo "<li><span class='label'>$thesubfolder/$abouttomove</span></li>";
			}
		}
		
		
		$logcheck = 0;
		$folderpath = $autorip . "/logs";
		$subfolders = scandir($folderpath);
		foreach($subfolders as $thesubfolder) {
			if($thesubfolder == "." || $thesubfolder == ".." || $thesubfolder == "") { continue; }
			$logcheck++;
			if($logcheck == 1) { 
				echo "<li class='title'><span class='label'><b>Logs:</b></span></li>";
			}
			$fullpath = "$thefolder/$thesubfolder";
			echo "<li><span class='label'>$fullpath</span>";
			$files = glob("$autorip/$fullpath/*.{log,txt,nfo}", GLOB_BRACE);
			foreach($files as $file) {
				$file = substr($file, strrpos($file, "/") + 1);
				//echo $file."<br>";
				//$newfile = str_replace("$thefolder","$programtitle",$file);
				//echo $newfile."<br>";
			 echo "<a href='#' onclick='showlog(\"$fullpath/$file\");' class='log-file'>$file</a>";
			 }
			echo "<img src='./img/loading.gif' style='display:none;' /><br class='clear'></li>";
		}
	?>
	</ul>
	<div class='popup_box' style='overflow-y:auto;height:90%;top:4%;'> 
    <div class='ajax_content'></div>
     <a class='popupBoxClose' style='z-index:9999;'></a>
	</div>
<script>

	$("a").click(function() {
		$(this).next('img').css({ display: "block" });
		$(this).css({ display: "none" });
	});
	
	function showpossibles(dir,data) {
		var thisdir = encodeURIComponent(dir);
		var thisdata = encodeURIComponent(data);
		//var thisdata = data.replace(/ /g,'+'); 
		$.ajax({
		   url: "./possiblematches.php?dir="+thisdir+"&data="+thisdata,
		   error: function(xhr, error){
				alert(error);
			},
		   success: function(thehtml) {
				$('.popup_box').fadeIn(500);
				$('.popup_box .ajax_content').html(thehtml);
			},
			complete: function() {
				//completed();
			}
		});
	}

	
	
	
	function showlog(data) {
		var thisdata = "<?php echo"$autorip/";?>"+data;

		$('.popup_box').fadeIn(500);
			
			 $.get(thisdata, function(data) {
						//var fileDom = $(data);

						var lines = data.split("\n");

						$.each(lines, function(n, elem) {
							$('.popup_box .ajax_content').append('<div>' + elem + '</div>');
						});
					});			
		//$('.popup_box .ajax_content').load(thisdata);
	}

	
	
	
	
	
	
	function changequality(option,dir,title) {
		var thisdir = encodeURIComponent(dir);
		var title = encodeURIComponent(title);
		$.ajax({
		   url: "./changequality.php?option="+option.value+"&dir="+thisdir+"&title="+title+"",
		   error: function(xhr, error){
				alert(error);
			},
		   success: function(thehtml) {
				location.reload();
			},
			complete: function() {
				//completed();
			}
		});
	}	

	function loadPopupBox(data) {
    $('.popup_box').fadeIn(500);
    $('.popup_box .ajax_content').html(data);
    //$('#wrapper').css({'opacity': '0.3'});    //div with id wrapper is page's main wrapper
	}

	function unloadPopupBox() {
		$('.popup_box').fadeOut('fast');
		//$('#wrapper').css({ 'opacity': '1' });
	}

    $('.popupBoxClose,#popupwrapper').click(function() {
        //unloadPopupBox();
		location.reload();
    });


// idle timeout for network pings
var isIdle = 0;
function d(el){
    return document.getElementById(el);
}
ifvisible.setIdleDuration(35);

ifvisible.idle(function(){
	isIdle = 1;
});

ifvisible.wakeup(function(){
	isIdle = 0;				
});


	function refreshPage() {
		if(isIdle == 1) {
			location.reload();
		}
		refreshthepage = setTimeout(refreshPage, 10000);					
	}
	refreshthepage = setTimeout(refreshPage, 1000);


</script>
</body>
</html>
  