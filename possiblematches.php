<?php
if(!empty($_GET['data'])) {
	$thepost = $_GET['data'];
	$thispost = $thepost;
	$thepost = urlencode($thepost);
}
if(!empty($_GET['dir'])) {
	$thedir = $_GET['dir'];
	$thedir = urlencode($thedir);
}
	
require "config.php";


//figure out if music/tv/movies for name info
	
$theurl = "http://www.imdb.com/xml/find?json=1&nr=1&q=$thepost";
$xml=file_get_contents($theurl); // or die ("error");
$possiblematches = json_decode($xml, TRUE);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Possible Matches</title>
  <meta charset="utf-8">
  <meta name="viewport" content="height:device-height, width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, target-densitydpi=medium-dpi, user-scalable=no" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />
  <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
  <script type="text/javascript" src="/js/jquery1.9.1.min.js"></script>  
  <script type="text/javascript" src="/js/jquery.confirmon.js"></script>
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
<div id="overlaybuttons" style="display:block;">
	<ul id="possiblematches" class="links" style="clear:right;">
		<?php
			$subarrays = array('title_popular','title_substring','title_approx');
		
			foreach($subarrays as $title) {
				for ($i = 0; $i < 50; ++$i) {
					if(!isset($possiblematches[$title][$i]['title'])) { break; }
					$thetitle = $possiblematches[$title][$i]['title'];
					$tempyear = $possiblematches[$title][$i]['description'];
					$theyear = explode(",","$tempyear");
					$theyear = explode(" ","$theyear[0]", 2);
					$theyear = explode("/","$theyear[0]");
					$newtitle = $thetitle . " ($theyear[0])";
					echo "<li><span class='label'>$thetitle<br> $theyear[0]";
					if(isset($theyear[1]) && strlen($theyear[1]) > 2) { echo "<br>$theyear[1]"; }
					echo "</span> <a href='#' onclick='makeSelection(\"$thedir\",\"$thispost\",\"$newtitle\"); return false;' class='on-off-toggle off'>Select</a></li>";
				}
			}
		?>
	</ul>
</div>
<script>
	function makeSelection(dir,folder,newtitle) {
	var thisdir = encodeURIComponent(dir);
	var thisfolder = encodeURIComponent(folder);
		var thistitle = encodeURIComponent(newtitle);
		//var thisdata = data.replace(/ /g,'+'); 
		$.ajax({
		   url: "./rename.php?dir="+thisdir+"&folder="+thisfolder+"&title="+thistitle,
		   error: function(xhr, error){
				alert(error);
			},
		   success: function(thehtml) {
				//$('.popup_box').fadeIn(500);
				//$('.popup_box .ajax_content').html(thehtml);
				//unloadPopupBox();
				location.reload();
			},
			complete: function() {
				//completed();
			}
		});		
	}
</script>
</body>
</html>