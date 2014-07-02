<?php
// required include
require "php/config.inc.php";
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
	<!-- Basic Page Needs -->
	<meta charset="utf-8">
	<title>Music Artist/Track Search & Request Script</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS -->
	<link rel="stylesheet" href="css/base.css">
	<link rel="stylesheet" href="css/skeleton.css">
	<link rel="stylesheet" href="css/layout.css">
	<link rel="stylesheet" href="css/smoothness/jquery-ui-1.8.17.custom.css" />
	
	<!-- IE6-8 polyfill for media queries -->
	<!--[if lt IE 9]>
	<script src="js/respond.js"></script>
	<![endif]-->

	<!-- Favicons -->
	<link rel="shortcut icon" href="imgs/favicon.ico">
	<link rel="apple-touch-icon" href="imgs/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="imgs/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="imgs/apple-touch-icon-114x114.png">

</head>
<body>
	<div class="container">
		<div id="header" class="sixteen columns">
			<h1 class="remove-bottom">Music Artist/Track Search &amp; Request Script</h1>
			<ul>
				<li><a href="./">Home</a></li>
				<li><a href="./features.php">Features</a></li>
				<li><a href="./installation.php">Installation</a></li>
				<li><a href="./integration.php">Integration</a></li>
			</ul>
		</div>
		<div id="search_div" class="sixteen columns">
			<noscript>
			<p class="flash_bad">
				Your browser currently doesn't support javascript or you have it turned off.
				Functionality will be limited and will only return a list of nearby stores.
			</p>
			</noscript>

			<?php if($db === FALSE): ?>
			<ul class="flash_bad">
				<li>Unable to connect to the database, please check your settings</li>
			</ul>
			<?php endif; ?>
			
			<!--
			This is the main Form HTML
			-->
			<form action="./" method="POST" id="search">
				<fieldset>
					<legend>Search Artist or Track</legend>
					<div class="input">
						<label>Artist:</label>
						<input type="text" name="artist" id="artist" value="" />
						<img src="imgs/ajax-loader.gif" class="ajax_loader hide"/>
					</div>
					<div class="input">
						<label>Track:</label>
						<input type="text" name="track" id="track" value="" />
						<img src="imgs/ajax-loader.gif" class="ajax_loader hide"/>
					</div>
				</fieldset>
			</form>
			<!--
			This will populate via Ajax requesr after an Artist or Track search
			-->
			<table id="tracks">
				<thead>
					<tr>
						<th>Artist</th>
						<th>Track</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="3">Search for an Artist or Track above</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<!--
		This will display all the tracks and the number of time's it's being requested
		-->
		<div id="most-requested-tracks" class="sixteen columns">
			<h2>Most Requested Tracks</h2>
			<?php if(defined('ENABLE_YOUTUBE') && ENABLE_YOUTUBE): ?>
			<center><div id="videoDiv">Loading...</div></center>
			<?php endif; ?>
			
			<table>
				<thead>
					<tr>
						<th>Artist</th>
						<th>Track</th>
						<th class="request">Requests</th>
					</tr>
				</thead>
				<tbody>
					<?php echo most_requested_tracks_table_rows_html($top_requested_tracks); ?>
				</tbody>
			</table>
			
			<?php if(defined('ENABLE_ARTIST_IMAGES') && ENABLE_ARTIST_IMAGES && isset($artist_images) && !empty($artist_images)): ?>
			<div id="artist_images">
				<?php foreach($artist_images as $k=>$v):  ?>
				<a href="<?php echo $v['artist_url']; ?>" target="_blank">
					<img src="<?php echo $v['url']; ?>" height="100"/>
				</a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
		
		<div id="footer" class="sixteen columns">
			<p>Created by <a href="http://www.jamesfairhurst.co.uk/">James Fairhurst</a> | download source <a href="">here</a></p>
		</div>
	</div>
	
	<!-- JS
	================================================== -->
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="js/jquery-ui-1.8.17.custom.min.js"></script>
	<script src="js/jquery.tablePagination.0.5.min.js"></script>
	<?php if(ENABLE_YOUTUBE && isset($youtube_video_ids) && !empty($youtube_video_ids)): ?>
	<script src="http://www.google.com/jsapi" type="text/javascript"></script>
    <script type="text/javascript">
      google.load("swfobject", "2.1");
    </script>
	<script type="text/javascript">
		// define youtube player
		var ytplayer;
		// current video index
		var current_video_index = 0;
		// list of videos to display
		var video_ids = ["<?php echo join("\",\"",$youtube_video_ids); ?>"];
		
		// Lets Flash from another domain call JavaScript
		var params = { allowScriptAccess: "always" };
		// The element id of the Flash embed
		var atts = { id: "ytPlayer" };
		
		// embed the player when ready
		function _run() {
			// All of the magic handled by SWFObject (http://code.google.com/p/swfobject/)
			swfobject.embedSWF("http://www.youtube.com/v/" + video_ids[0] + "?version=3&enablejsapi=1", "videoDiv", "480", "295", "9", null, null, params, atts);
		}

		// callback function when the video object is ready
		function onYouTubePlayerReady(playerId) {
			ytplayer = document.getElementById("ytPlayer");
			ytplayer.addEventListener("onStateChange", "onytplayerStateChange");
		}
		
		// callback on each and every status change
		function onytplayerStateChange(newState) {
			// player is valid
			if(ytplayer) {
				// automatically start video on first run
				if(newState==-1) {
					ytplayer.playVideo();
					
				// video has stopped playing
				} else if(newState==0) {
					// move to next video
					current_video_index++;
					
					// see if next video actual exists
					if(!video_ids[current_video_index]) {
						// return to beginning if it doesn't
						current_video_index = 0;
					}
					
					// load the next/first video
					ytplayer.loadVideoById(video_ids[current_video_index]);
				}
			}
		}
		
		// get things rolling
		google.setOnLoadCallback(_run);
    </script>
	<?php endif; ?>
	<script src="js/jquery-common.js"></script>
</body>
</html>