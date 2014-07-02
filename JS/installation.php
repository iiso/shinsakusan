<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
	<!-- Basic Page Needs -->
	<meta charset="utf-8">
	<title>Installation | Music Artist/Track Search & Request Script</title>
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
		<div class="sixteen columns">
			<h2>Installation</h2>
			
			<h4>Step 1</h4>
			<p>Head over to the Last.fm site and <a href="http://www.last.fm/api/account">apply for an API account</a>, really easy to sign up and I got a key straight away.</p>
			
			<h4>Step 2</h4>
			<p>Using the provided <strong>schema.sql</strong> file in the download create the database and appropriate tables, if your hosting provider creates the database for you just use the statements to create the tables</p>
			
			<h4>Step 3</h4>
			<p>Open up the <strong>php/config.inc.php</strong> file and insert your database and Last.fm API keys:</p>
			
<pre>// define database settings
define('HOSTNAME','localhost');
define('DB_USERNAME','DATABASE_USERNAME_GOES_HERE');
define('DB_PASSWORD','DATABASE_PASSWORD_GOES_HERE');
define('DB_NAME','song_requests');

// defin Lastfm settings
define('LASTFM_API_KEY','KEY_GOES_HERE');
define('LASTFM_SECRET_KEY','KEY_GOES_HERE');</pre>
			
			<h4>Step 3</h4>
			<p>Enable or Disable various options</p>
			
<pre>define('ENABLE_ARTIST_IMAGES', TRUE);
define('ENABLE_YOUTUBE', TRUE);</pre>

			<h4>Step 5</h4>
			<p>Load up the site and you hopefully should be rocking!</p>
		</div>
		<div id="footer" class="sixteen columns">
			<p>Created by <a href="http://www.jamesfairhurst.co.uk/">James Fairhurst</a> | download source <a href="">here</a></p>
		</div>
	</div>
</body>
</html>