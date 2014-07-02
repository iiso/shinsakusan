<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
	<!-- Basic Page Needs -->
	<meta charset="utf-8">
	<title>Features | Music Artist/Track Search & Request Script</title>
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
			<h5>Version 1.0.1</h5>
			<hr />
		</div>
		<div class="sixteen columns">
			<h2>Features</h2>
			<p>A PHP &amp; MySQL script that uses the <a href="http://www.last.fm/api">Last.fm API</a> to search on Artists or tracks that you can then request. My initial need for the script was for a Wedding website so that visitors are able to request music for the evening party.</p>
			<ul class="square">
				<li>Artist Search</li>
				<li>Track Search</li>
				<li>Responsive design ready for mobiles &amp; tablets</li>
				<li>Ajax driven</li>
				<li>Request tracks
					<ul class="circle">
						<li>Keeps track of requests</li>
						<li>Session protection against multiple votes</li>
					</ul>
				</li>
				<li>Display the most requested Tracks</li>
				<li>Uses the Last.fm API for all artist and track names</li>
				<li>YouTube Integration to play the most requested tracks</li>
			</ul>
			
			<h3>Changes</h3>
			<h4>1.0.1 (24/02/12)</h4>
			<ul class="square">
				<li>Save &amp; display Artist Images</li>
				<li>JS Pagination on Top Requested Tracks</li>
				<li>YouTube integration</li>
			</ul>
		</div>
		<div id="footer" class="sixteen columns">
			<p>Created by <a href="http://www.jamesfairhurst.co.uk/">James Fairhurst</a> | download source <a href="">here</a></p>
		</div>
	</div>
</body>
</html>